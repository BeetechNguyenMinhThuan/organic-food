<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = $this->orderService->getPaginate();
        return view('backend.orders.index', [
            'orders' => $orders
        ]);
    }

    public function detail($id)
    {
        $order = $this->orderService->findItem($id);
        $orderDetail = $order->orderDetail;
        return view('backend.orders.detail', compact('order', 'orderDetail'));
    }

    public function updateStatus($id)
    {
        $order = $this->orderService->findItem($id);
        if ($order->order_status == Order::PENDING) {
            $order->order_status = Order::COMPLETED;
            $order->save();
        } else {
            $order->order_status = Order::PENDING;
            $order->save();
        }
        return redirect()->back()->with(['status_succeed' => "Cập nhật đơn hàng thành công!"]);
    }

    public function exportToPDF($id){
        return $this->orderService->exportToPDF($id);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
