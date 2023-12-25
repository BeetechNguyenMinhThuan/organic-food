<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\AccountAdminService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AccountAdminController extends Controller
{
    private $accountAdminService;

    public function __construct(AccountAdminService $accountAdminService)
    {
        $this->accountAdminService = $accountAdminService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->accountAdminService->get();
        return view('backend.account-admins.index', [
            'users' => $users
        ]);
    }

    public function listAdmin()
    {
        $admins = Admin::query()->paginate(15);
        return view('backend.account-admins.list-admin', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->accountAdminService->getRole();
        return view('backend.account-admins.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->accountAdminService->createUser($request);
            DB::commit();
            return redirect()->route('admin.account-admins.index')->with([
                'status_succeed' => trans('messages.create_succeed')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("File: " . $e->getFile() . '---Line: ' . $e->getLine() . "---Message: " . $e->getMessage());
            return redirect()->route('admin.account-admins.index')->with([
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
        $user = $this->accountAdminService->findItem($id);
        $roles = $this->accountAdminService->getRole();
        return view('backend.account-admins.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $this->accountAdminService->updateUser($request, $id);
            DB::commit();
            return redirect()->route('admin.account-admins.index')->with([
                'status_succeed' => trans('messages.update_succeed')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("File: " . $e->getFile() . '---Line: ' . $e->getLine() . "---Message: " . $e->getMessage());
            return redirect()->route('admin.account-admins.index')->with([
                'status_failed' => trans('messages.server_error')
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $userDelete = $this->accountAdminService->delete($id);
        if ($userDelete) {
            return response()->json(['status' => 200, 'message' => "Success"]);
        }
        return response()->json(['status' => 500, 'message' => "Fail"], 500);
    }
}
