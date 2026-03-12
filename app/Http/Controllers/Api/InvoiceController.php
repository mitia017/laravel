<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Services\InvoiceService;

class InvoiceController extends Controller
{
    protected $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function index()
    {
        $invoices = $this->invoiceService->getAllInvoices();
        return InvoiceResource::collection($invoices);
    }

    public function show($id)
    {
        $invoice = $this->invoiceService->getInvoiceById($id);
        return new InvoiceResource($invoice);
    }

    public function update(UpdateInvoiceRequest $request, $id)
    {
        $invoice = $this->invoiceService->updateInvoiceStatus($id, $request->validated()['status']);
        return new InvoiceResource($invoice);
    }
}
