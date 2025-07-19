<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class PermissionController extends Controller {

    protected function applySearch($query, $search) {
        return $query->when($search, function($query, $search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        });
    }

    public function index(Request $request): Response {
        Gate::authorize('viewAny', Permission::class);
        $searchQuery = Permission::query();
        $this->applySearch($searchQuery, $request->search);
        $data = PermissionResource::collection($searchQuery->paginate(12));
        return Inertia::render('Settings/Permissions/IndexPermission', [
            'fetchData' => $data,
            'search' => $request->search ?? ''
        ]);
    }

    public function create() {
        //
    }

    public function store(PermissionRequest $request): RedirectResponse {
        Gate::authorize('create', Permission::class);
        $create = Permission::create(['name' => $request->name]);
        Session::flash('toast', 'Data berhasil ditambahkan.');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionRequest $request, $id): RedirectResponse {
        $data = Permission::find($id);
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
        $data = Permission::find($id);
        Gate::authorize('delete', $data);
        Permission::where('id', $id)->delete();
        Session::flash('toast', 'Data berhasil dihapus.');
        return back();
    }
}
