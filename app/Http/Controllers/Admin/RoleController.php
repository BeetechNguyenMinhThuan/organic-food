<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    private $permission;
    private $role;

    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = $this->role->paginate(15);
        return view('backend.roles.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = $this->permission->get();
        return view('backend.roles.create', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $role = $this->role->create([
                'name' => $request->name,
            ]);

            $permissions = $request->permissions;
            if (!empty($permissions)) {
                $role->syncPermissions($permissions);
            }

            DB::commit();
            return redirect()->route('admin.roles.index')->with([
                'status_succeed' => trans('messages.create_succeed')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return redirect()->route('admin.roles.index')->with([
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
        $permissions = $this->permission->get();
        $role = $this->role->findOrFail($id);
        return view('backend.roles.edit', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $role = $this->role->findOrFail($id);
            $permissions = $request->permissions;
            $role->name = $request->name;
            $role->save();
            $role->syncPermissions($permissions);
            DB::commit();
            return redirect()->route('admin.roles.index')->with([
                'status_succeed' => trans('messages.update_succeed')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return redirect()->route('admin.roles.index')->with([
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
            $role = $this->role->query()->findOrFail($id);
            $role->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => "Success"]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return response()->json(['status' => 500, 'message' => "Fail"], 500);
        }
    }
}
