<?php

namespace App\Http\Controllers;

use App\Models\Bird;
use App\Models\MortalityRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MortalityController extends Controller
{
    // Display all mortality records
    public function index()
    {
        $records = MortalityRecord::with('bird')->orderBy('death_date', 'desc')->get();
        
        return view('admin.mortality.index', [
            'title' => 'Mortality Records',
            'records' => $records
        ]);
    }

    // Show form to add mortality record
    public function create()
    {
        $birds = Bird::where('status', 'active')->get();
        
        return view('admin.mortality.create', [
            'title' => 'Record Mortality',
            'birds' => $birds
        ]);
    }

    // Store mortality record
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bird_id' => 'required|exists:birds,id',
            'death_date' => 'required|date',
            'number_of_deaths' => 'required|integer|min:1',
            'cause_of_death' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if number of deaths doesn't exceed current bird quantity
        $bird = Bird::findOrFail($request->bird_id);
        $currentQuantity = $bird->getCurrentQuantity();
        
        if ($request->number_of_deaths > $currentQuantity) {
            return redirect()->back()
                ->withErrors(['number_of_deaths' => 'Number of deaths cannot exceed current bird quantity (' . $currentQuantity . ')'])
                ->withInput();
        }

        MortalityRecord::create($request->all());

        return redirect('/mortality')->with('success', 'Mortality record added successfully!');
    }

    // Show edit form
    public function edit(MortalityRecord $mortality)
    {
        $birds = Bird::where('status', 'active')->get();
        
        return view('admin.mortality.edit', [
            'title' => 'Edit Mortality Record',
            'record' => $mortality,
            'birds' => $birds
        ]);
    }

    // Update mortality record
    public function update(Request $request, MortalityRecord $mortality)
    {
        $validator = Validator::make($request->all(), [
            'bird_id' => 'required|exists:birds,id',
            'death_date' => 'required|date',
            'number_of_deaths' => 'required|integer|min:1',
            'cause_of_death' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $mortality->update($request->all());

        return redirect('/mortality')->with('success', 'Mortality record updated successfully!');
    }

    // Delete mortality record
    public function destroy(MortalityRecord $mortality)
    {
        $mortality->delete();
        
        return redirect('/mortality')->with('success', 'Mortality record deleted successfully!');
    }
}
