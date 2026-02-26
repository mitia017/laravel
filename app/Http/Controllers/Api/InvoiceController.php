<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        return response()->json(Invoice::with('client')->latest()->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'number' => 'required|string|unique:invoices,number',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,paid,cancelled',
            'date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:date',
        ]);

        $invoice = Invoice::create($validated);

        return response()->json($invoice->load('client'), 201);
    }

    public function show(Invoice $invoice)
    {
        return response()->json($invoice->load('client'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'number' => 'required|string|unique:invoices,number,' . $invoice->id,
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,paid,cancelled',
            'date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:date',
        ]);

        $invoice->update($validated);

        return response()->json($invoice->load('client'));
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return response()->json(null, 204);
    }

    public function downloadPdf(Invoice $invoice)
    {
        $invoice->load('client');

        $pdf = Pdf::loadView('pdf.invoice', ['invoice' => $invoice]);

        return $pdf->download("invoice_{$invoice->number}.pdf");
    }
}
