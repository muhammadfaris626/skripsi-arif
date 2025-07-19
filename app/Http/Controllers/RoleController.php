<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class RoleController extends Controller {

    protected function applySearch($query, $search) {
        return $query->when($search, function($query, $search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        });
    }

    public function index(Request $request): Response {
        Gate::authorize('viewAny', Role::class);
        $searchQuery = Role::query();
        $this->applySearch($searchQuery, $request->search);
        $data = RoleResource::collection($searchQuery->paginate(12));
        return Inertia::render('Settings/Roles/IndexRole', [
            'fetchData' => $data,
            'permissions' => PermissionResource::collection(Permission::all()),
            'search' => $request->search ?? ''
        ]);
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
    public function store(RoleRequest $request): RedirectResponse {
        Gate::authorize('create', Role::class);
        $peran = Role::create(['name' => $request->name]);
        if ($request->has('permissions')) {
            $peran->syncPermissions($request->input('permissions.*.name'));
        }
        Session::flash('toast', 'Data berhasil ditambahkan.');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): Response {
        Gate::authorize('view', $role);
        $allPermissions = [
            'USER', 'ROLE', 'PERMISSION'
        ];
        $list = [];
        foreach ($allPermissions as $key => $value) {
            $list[] = ['role_id' => $role->id, 'category' => $value];
            $permissions = Permission::where('name', 'LIKE', '%' . $value . '%')->get();
            foreach ($permissions as $key1 => $data) {
                $check = DB::table('role_has_permissions')->where('role_id', $role->id)->where('permission_id', $data->id)->first();
                if (empty($check)) {
                    $list[$key][$value][] = ['id' => $data->id, 'name' => $data->name, 'status' => 0];
                } else {
                    $list[$key][$value][] = ['id' => $data->id, 'name' => $data->name, 'status' => 1];
                }
            }
        }
        return Inertia::render('Settings/Roles/ReadRole', [
            'fetchData' => $list
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, $id): RedirectResponse
    {
        $data = Role::find($id);
        Gate::authorize('update', $data);
        $data->update([
            'name' => $request->name
        ]);
        Session::flash('toast', 'Data berhasil diubah.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse {
        $data = Role::find($id);
        Gate::authorize('delete', $data);
        Role::where('id', $id)->delete();
        Session::flash('toast', 'Data berhasil dihapus.');
        return back();
    }

    public function updateRolePermission($role, $permission) {
        $checkRolePermission = DB::table('role_has_permissions')->where('role_id', $role)->where('permission_id', $permission)->first();
        $searchRole = Role::where('id', $role)->first();
        $searchPermission = Permission::where('id', $permission)->first();
        if (empty($checkRolePermission)) {
            $searchRole->givePermissionTo($searchPermission);
            $searchPermission->assignRole($searchRole);
            Session::flash('toast', 'Perizinan berhasil ditambahkan.');
        }else{
            $searchRole->revokePermissionTo($searchPermission);
            $searchPermission->removeRole($searchRole);
            Session::flash('toast', 'Perizinan berhasil dihapus.');
        }
        return back();
    }
}
