<?php

namespace App\Services;

use App\Models\Invoice;

class InvoiceService
{
    public function getAllInvoices()
    {
        return Invoice::with('order.customer')->paginate(10);
    }

    public function getInvoiceById($id)
    {
        return Invoice::with('order.customer', 'order.items.product')->findOrFail($id);
    }

    public function updateInvoiceStatus($id, $status)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->update(['status' => $status]);
        return $invoice;
    }
}
