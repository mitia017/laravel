<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClients = Client::count();
        $totalInvoices = Invoice::count();
        $totalRevenue = Invoice::where('status', 'paid')->sum('amount');
        $pendingInvoices = Invoice::where('status', 'pending')->count();

        return response()->json([
            'total_clients' => $totalClients,
            'total_invoices' => $totalInvoices,
            'total_revenue' => $totalRevenue,
            'pending_invoices' => $pendingInvoices,
            'recent_clients' => Client::latest()->limit(5)->get(),
            'recent_invoices' => Invoice::with('client')->latest()->limit(5)->get(),
        ]);
    }
}
