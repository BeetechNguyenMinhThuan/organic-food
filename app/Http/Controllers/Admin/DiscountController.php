<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountRequest;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discounts = Discount::query()->paginate(15);
        return view('backend.discounts.index', compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.discounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DiscountRequest $request)
    {
        $discount = new Discount();
        $discount->name = $request->name;
        $discount->start_at = $request->start_at;
        $discount->end_at = $request->end_at;
        $discount->max_use = $request->max_use;
        $discount->percent = $request->percent;
        $discount->save();
        return redirect()->route('admin.discounts.index')->with(['status_succeed' => trans('messages.create_succeed')]);

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
        $discount = Discount::query()->findOrFail($id);
        return view('backend.discounts.edit', compact('discount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $discount = Discount::query()->findOrFail($id);
        $discount->name = $request->name;
        $discount->start_at = $request->start_at;
        $discount->end_at = $request->end_at;
        $discount->max_use = $request->max_use;
        $discount->percent = $request->percent;
        $discount->save();
        return redirect()->route('admin.discounts.index')->with(['status_succeed' => trans('messages.create_succeed')]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Discount::query()->findOrFail($id)->delete();
        return redirect()->back()->with(['status_succeed' => trans('messages.create_succeed')]);
    }
}
