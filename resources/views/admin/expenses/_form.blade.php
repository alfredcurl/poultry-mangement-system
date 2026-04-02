@csrf
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Expense Type</label>
        <input type="text" name="expense_type" class="form-control" value="{{ old('expense_type', $expense->expense_type ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Expense Date</label>
        <input type="date" name="expense_date" class="form-control" value="{{ old('expense_date', isset($expense) ? $expense->expense_date->format('Y-m-d') : date('Y-m-d')) }}" required>
    </div>
    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3" required>{{ old('description', $expense->description ?? '') }}</textarea>
    </div>
    <div class="col-md-4">
        <label class="form-label">Amount</label>
        <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount', $expense->amount ?? 0) }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Paid To</label>
        <input type="text" name="paid_to" class="form-control" value="{{ old('paid_to', $expense->paid_to ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Receipt Number</label>
        <input type="text" name="receipt_number" class="form-control" value="{{ old('receipt_number', $expense->receipt_number ?? '') }}">
    </div>
    <div class="col-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $expense->notes ?? '') }}</textarea>
    </div>
    <div class="col-12">
        <button class="btn btn-primary">
            <i class="fas fa-save me-1"></i>
            {{ isset($expense) ? 'Update Expense' : 'Save Expense' }}
        </button>
        <a href="/expenses" class="btn btn-link">Cancel</a>
    </div>
</div>

