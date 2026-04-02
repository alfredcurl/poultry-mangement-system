<?php

namespace App\Http\Controllers;

use App\Models\Bird;
use App\Models\MortalityRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BirdController extends Controller
{
    // Display all birds
    public function index()
    {
        $birds = Bird::with('mortalityRecords')->get();
        
        // Calculate current quantities
        foreach ($birds as $bird) {
            $bird->current_quantity = $bird->getCurrentQuantity();
        }
        
        return view('admin.birds.index', [
            'title' => 'Bird Management',
            'birds' => $birds
        ]);
    }

    // Show form to add new bird batch
    public function create()
    {
        return view('admin.birds.create', [
            'title' => 'Add Bird Batch'
        ]);
    }

    // Store new bird batch
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bird_type' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'acquisition_date' => 'required|date',
            'acquisition_cost' => 'required|numeric|min:0',
            'age_in_weeks' => 'required|integer|min:0',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Bird::create($request->all());

        return redirect('/birds')->with('success', 'Bird batch added successfully!');
    }

    // Show edit form
    public function edit(Bird $bird)
    {
        return view('admin.birds.edit', [
            'title' => 'Edit Bird Batch',
            'bird' => $bird
        ]);
    }

    // Update bird batch
    public function update(Request $request, Bird $bird)
    {
        $validator = Validator::make($request->all(), [
            'bird_type' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'acquisition_date' => 'required|date',
            'acquisition_cost' => 'required|numeric|min:0',
            'age_in_weeks' => 'required|integer|min:0',
            'status' => 'required|in:active,sold,deceased',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $bird->update($request->all());

        return redirect('/birds')->with('success', 'Bird batch updated successfully!');
    }

    // Get bird data (AJAX)
    public function getBirdData($id)
    {
        $bird = Bird::with('mortalityRecords')->findOrFail($id);
        $bird->current_quantity = $bird->getCurrentQuantity();
        
        return response()->json($bird);
    }
}
