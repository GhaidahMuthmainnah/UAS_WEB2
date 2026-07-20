<?php

namespace App\Http\Controllers;

use App\Models\ExpenseRecord;
use App\Models\Order;
use Illuminate\Http\Request;

class ExpenseRecordController extends Controller
{
    public function index()
    {
        return view('expense.index', [
            'title' => 'Buku Kas & Pengeluaran',
            'expenses' => ExpenseRecord::with('order')->latest('expense_date')->get(),
            'orders' => Order::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'nullable|exists:orders,id',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        ExpenseRecord::create($validated);
        return redirect()->route('expense.index')->withSuccess('Catatan pengeluaran berhasil disimpan!');
    }

    public function update(Request $request, ExpenseRecord $expense)
    {
        $validated = $request->validate([
            'order_id' => 'nullable|exists:orders,id',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $expense->update($validated);
        return redirect()->route('expense.index')->withSuccess('Catatan pengeluaran berhasil diubah!');
    }

    public function destroy(ExpenseRecord $expense)
    {
        $expense->delete();
        return redirect()->route('expense.index')->withSuccess('Catatan dihapus!');
    }
}
