<?php

namespace App\Http\Controllers;

use App\Models\ServiceOrder;
use Illuminate\Http\Request;

class ServiceOrderController extends Controller
{
    public function index()
    {
        // Ambil semua data service order
        $serviceOrders = ServiceOrder::latest()->get();

        // Lempar ke view
        return view('service-orders.index', compact('serviceOrders'));
    }

    public function create()
    {
        return view('service-orders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'service_type'   => 'required',
            'status'         => 'required',
        ]);

        ServiceOrder::create($request->all());

        return redirect()->route('service-orders.index')->with('success', 'Service order berhasil ditambahkan.');
    }

    public function edit(ServiceOrder $serviceOrder)
    {
        return view('service-orders.edit', compact('serviceOrder'));
    }

    public function update(Request $request, ServiceOrder $serviceOrder)
    {
        $request->validate([
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'service_type'   => 'required',
            'status'         => 'required',
        ]);

        $serviceOrder->update($request->all());

        return redirect()->route('service-orders.index')->with('success', 'Service order berhasil diupdate.');
    }

    public function destroy(ServiceOrder $serviceOrder)
    {
        $serviceOrder->delete();
        return redirect()->route('service-orders.index')->with('success', 'Service order berhasil dihapus.');
    }
}
