<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    // Display all expenses
    public function index(Request $request)
    {
        $query = Expense::query();
        
        // Filter by date range if provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('expense_date', [$request->start_date, $request->end_date]);
        }
        
        $expenses = $query->orderBy('expense_date', 'desc')->get();
        $totalExpenses = $expenses->sum('amount');
        
        return view('admin.expenses.index', [
            'title' => 'Expense Management',
            'expenses' => $expenses,
            'totalExpenses' => $totalExpenses
        ]);
    }

    // Show form to add expense
    public function create()
    {
        return view('admin.expenses.create', [
            'title' => 'Add Expense'
        ]);
    }

    // Store expense
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'expense_type' => 'required|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'paid_to' => 'nullable|string|max:255',
            'receipt_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Expense::create($request->all());

        return redirect('/expenses')->with('success', 'Expense added successfully!');
    }

    // Show edit form
    public function edit(Expense $expense)
    {
        return view('admin.expenses.edit', [
            'title' => 'Edit Expense',
            'expense' => $expense
        ]);
    }

    // Update expense
    public function update(Request $request, Expense $expense)
    {
        $validator = Validator::make($request->all(), [
            'expense_type' => 'required|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'paid_to' => 'nullable|string|max:255',
            'receipt_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $expense->update($request->all());

        return redirect('/expenses')->with('success', 'Expense updated successfully!');
    }

    // Delete expense
    public function destroy(Expense $expense)
    {
        $expense->delete();
        
        return redirect('/expenses')->with('success', 'Expense deleted successfully!');
    }

    // Monthly expense report
    public function monthlyReport(Request $request)
    {
        $month = $request->input('month', date('Y-m'));
        
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        
        $expenses = Expense::whereRaw("DATE_FORMAT(expense_date, '%Y-%m') = ?", [$month])
            ->selectRaw('expense_type, SUM(amount) as total_amount, COUNT(*) as count')
            ->groupBy('expense_type')
            ->get();
        
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        
        $totalExpenses = $expenses->sum('total_amount');
        
        return view('admin.reports.monthly_expenses', [
            'title' => 'Monthly Expense Report',
            'month' => $month,
            'expenses' => $expenses,
            'totalExpenses' => $totalExpenses
        ]);
    }
}
