<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class InvoiceController extends Controller
{
    public function show($orderId)
    {
        // Ambil data order berdasarkan ID
        $order = Order::with(['customer'])->where('id', $orderId)->firstOrFail();


        // Hitung PPN 10%
        $ppn = $order->total_price * 0.1;

        return view('pelanggan.invoice', compact('order', 'ppn'));
    }
}
