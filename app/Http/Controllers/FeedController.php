<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\Bird;
use App\Models\FeedUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedController extends Controller
{
    // Display all feeds
    public function index()
    {
        $feeds = Feed::all();
        
        // Calculate remaining quantities
        foreach ($feeds as $feed) {
            $feed->remaining = $feed->getRemainingQuantity();
        }
        
        return view('admin.feeds.index', [
            'title' => 'Feed Management',
            'feeds' => $feeds
        ]);
    }

    // Show form to add feed
    public function create()
    {
        return view('admin.feeds.create', [
            'title' => 'Add Feed Stock'
        ]);
    }

    // Store feed
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'feed_name' => 'required|string|max:255',
            'feed_type' => 'required|string|max:255',
            'supplier' => 'nullable|string|max:255',
            'quantity_in_kg' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:purchase_date',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['total_cost'] = $request->quantity_in_kg * $request->unit_price;

        Feed::create($data);

        return redirect('/feeds')->with('success', 'Feed stock added successfully!');
    }

    // Feed usage form
    public function usageCreate()
    {
        $feeds = Feed::all();
        $birds = Bird::where('status', 'active')->get();
        
        return view('admin.feeds.usage_create', [
            'title' => 'Record Feed Usage',
            'feeds' => $feeds,
            'birds' => $birds
        ]);
    }

    // Store feed usage
    public function usageStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'feed_id' => 'required|exists:feeds,id',
            'bird_id' => 'required|exists:birds,id',
            'usage_date' => 'required|date',
            'quantity_used_kg' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if quantity doesn't exceed available stock
        $feed = Feed::findOrFail($request->feed_id);
        $remaining = $feed->getRemainingQuantity();
        
        if ($request->quantity_used_kg > $remaining) {
            return redirect()->back()
                ->withErrors(['quantity_used_kg' => 'Quantity used cannot exceed available stock (' . $remaining . ' kg)'])
                ->withInput();
        }

        FeedUsage::create($request->all());

        return redirect('/feeds/usage')->with('success', 'Feed usage recorded successfully!');
    }

    // Feed usage history
    public function usageIndex()
    {
        $usages = FeedUsage::with(['feed', 'bird'])
            ->orderBy('usage_date', 'desc')
            ->get();
        
        return view('admin.feeds.usage_index', [
            'title' => 'Feed Usage History',
            'usages' => $usages
        ]);
    }
}
