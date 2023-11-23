<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\User;
use App\Traits\StorageImageTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class UserService
{
    use StorageImageTrait;

    const PAGINATE = 15;
    private User $user;
    private Role $role;
    private Admin $admin;

    public function __construct(Admin $admin, User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
        $this->admin = $admin;
    }

    /**
     * Display a listing of Users
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get()
    {
        $query = $this->user::query()
            ->latest();

//        if ($searchByStock = request('filter_stock')) {
//            $this->filterByStock($searchByStock, $query, [10, 100, 200]);
//        }
//
//        $search = request('search');
//        $query->when($search, function ($query1) use ($search) {
//            $query1->whereHas('category', function ($query2) use ($search) {
//                $query2
//                    ->Where('product_categories.name', 'LIKE', "%{$search}%")
//                    ->orWhere('products.name', 'LIKE', "%{$search}%");
//            });
//        });


        return $query->paginate(self::PAGINATE);
    }

    /**
     * Display a listing of Users To Array
     * @return array
     */
    public function getToArray($isArray = false)
    {

    }

    /**
     * Insert User
     * @param ImageService $imageService
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function createUser($request)
    {
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'birthday' => $request->birthday,
            'address' => $request->address,
            'password' => Hash::make(123),
            'status' => 1
        ];
        // Store avatar image
        if ($request->hasFile('avatar')) {
            $avatar = $request->avatar;
            $data['avatar'] = $this->uploadFile($avatar, USER_DIR . '/' . auth()->id() . '/' . Str::random(30) . "." . $avatar->getClientOriginalExtension());
        }

        $user = $this->user->query()->create($data);

        // Assign role for user
        $roles = $request->roles;
        if (!empty($roles)) {
            $user->syncRoles($roles);
        }
        return $user;
    }

    /**
     * Get User via ID
     * @param int $id
     * @return Builder|Builder[]|Collection|Model
     */
    public function findItem($id)
    {
        return $this->user::query()->findOrFail($id);
    }

    /**
     * Update User
     * @param int $id ,
     * @param UpdateUserRequest $request
     * @param ImageService $imageService
     * @return bool
     */
    public function updateUser($request, $id)
    {
        //--- 1. Update user ---
        $user = $this->findItem($id);
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'birthday' => $request->birthday,
            'address' => $request->address,
        ];

        $old_avatar_path = null;
        if ($request->hasFile('avatar')) {
            $old_avatar_path = $user->avatar;
            $avatar = $request->avatar;
            $data['avatar'] = $this->uploadFile($avatar, USER_DIR . '/' . auth()->id() . '/' . Str::random(30) . "." . $avatar->getClientOriginalExtension());
        }

        $user->update($data);

        // --- 2.Remove old file avatar ---
        if ($old_avatar_path) {
            // Remove old file
            $this->deleteFile($old_avatar_path);
        }

        // Assign role for user
        $roles = $request->roles;
        $user->syncRoles($roles);
    }

    /**
     * Delete User
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $this->findItem($id)->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return false;
        }
    }

    /**
     * Export User CSV
     * @return BinaryFileResponse
     */
    public function exportCSV()
    {
        return Excel::download(new UserExport($this), 'products-csv.csv');
    }

    /**
     * Export User PDF
     * @return Response
     */
    public function exportPDF()
    {
        $products = collect($this->getToArray());
        $mytime = Carbon::now()->isoFormat('DD/MM/YYYY');
        $pdf = Pdf::loadView('pdf.product.products', [
            'products' => $products,
            'title' => "Users List",
            'mytime' => $mytime
        ]);
        return $pdf->download('products.pdf');
    }

    /**
     * Filter stock
     * @param string $searchValue
     * @param string $query
     * @param array $range
     * @return void
     */
    private function filterByStock($searchValue, $query, $range)
    {
        if ($searchValue == 1) {
            $query->where('stock', '<', $range[0]);
        } else if ($searchValue == 2) {
            $query->WhereBetween('stock', [$range[0], $range[1]]);
        } else if ($searchValue == 3) {
            $query->WhereBetween('stock', [$range[1], $range[2]]);
        } else {
            $query->where('stock', '>', $range[2]);
        }
    }

    public function getRole()
    {
        return $this->role->get();
    }
}
