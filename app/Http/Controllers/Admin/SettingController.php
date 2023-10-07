<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    private Setting $setting;

    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = $this->setting->paginate(15);
        return view('backend.settings.index', [
            'settings' => $settings
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.settings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            Setting::query()->create([
                'config_key' => $request->config_key,
                'config_value' => $request->config_value,
            ]);
            DB::commit();
            return redirect()->route('admin.settings.index')->with([
                'status_succeed' => trans('messages.create_category_succeed')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return redirect()->route('admin.settings.index')->with([
                'status_failed' => trans('messages.server_error')
            ]);
        }
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
        $setting = $this->setting->findOrFail($id);
        return view('backend.settings.edit', [
            'setting' => $setting
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $setting = Setting::query()->findOrFail($id);
            $setting->update([
                'config_key' => $request->config_key,
                'config_value' => $request->config_value,
            ]);
            DB::commit();
            return redirect()->route('admin.settings.index')->with([
                'status_succeed' => trans('messages.create_category_succeed')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return redirect()->route('admin.settings.index')->with([
                'status_failed' => trans('messages.server_error')
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $slider = $this->setting->query()->findOrFail($id);
            $slider->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => "Success"]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return response()->json(['status' => 500, 'message' => "Fail"], 500);
        }
    }
}
