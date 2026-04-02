<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use App\Models\Bird;
use App\Models\MedicationUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicationController extends Controller
{
    // Display all medications
    public function index()
    {
        $medications = Medication::all();
        
        // Calculate remaining quantities
        foreach ($medications as $medication) {
            $medication->remaining = $medication->getRemainingQuantity();
        }
        
        return view('admin.medications.index', [
            'title' => 'Medication Management',
            'medications' => $medications
        ]);
    }

    // Show form to add medication
    public function create()
    {
        return view('admin.medications.create', [
            'title' => 'Add Medication Stock'
        ]);
    }

    // Store medication
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'medication_name' => 'required|string|max:255',
            'medication_type' => 'required|string|max:255',
            'supplier' => 'nullable|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
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
        $data['total_cost'] = $request->quantity * $request->unit_price;

        Medication::create($data);

        return redirect('/medications')->with('success', 'Medication stock added successfully!');
    }

    // Medication usage form
    public function usageCreate()
    {
        $medications = Medication::all();
        $birds = Bird::where('status', 'active')->get();
        
        return view('admin.medications.usage_create', [
            'title' => 'Record Medication Usage',
            'medications' => $medications,
            'birds' => $birds
        ]);
    }

    // Store medication usage
    public function usageStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'medication_id' => 'required|exists:medications,id',
            'bird_id' => 'required|exists:birds,id',
            'administration_date' => 'required|date',
            'quantity_used' => 'required|numeric|min:0',
            'administered_by' => 'nullable|string|max:255',
            'reason' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if quantity doesn't exceed available stock
        $medication = Medication::findOrFail($request->medication_id);
        $remaining = $medication->getRemainingQuantity();
        
        if ($request->quantity_used > $remaining) {
            return redirect()->back()
                ->withErrors(['quantity_used' => 'Quantity used cannot exceed available stock (' . $remaining . ' ' . $medication->unit . ')'])
                ->withInput();
        }

        MedicationUsage::create($request->all());

        return redirect('/medications/usage')->with('success', 'Medication usage recorded successfully!');
    }

    // Medication usage history
    public function usageIndex()
    {
        $usages = MedicationUsage::with(['medication', 'bird'])
            ->orderBy('administration_date', 'desc')
            ->get();
        
        return view('admin.medications.usage_index', [
            'title' => 'Medication Usage History',
            'usages' => $usages
        ]);
    }
}
