<?php

namespace App\Http\Controllers;

use App\Http\Requests\PositionRequest;
use App\Http\Resources\PositionResource;
use App\Models\Position;
use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class PositionController extends Controller {

    protected function applySearch($query, $search) {
        return $query->when($search, function($query, $search) {
            $query->where('position_name', 'LIKE', '%' . $search . '%');
        });
    }

    public function index(Request $request): Response {
        Gate::authorize('viewAny', Position::class);
        $searchQuery = Position::query();
        $this->applySearch($searchQuery, $request->search);
        $data = PositionResource::collection($searchQuery->paginate(12));
        return Inertia::render('Settings/Positions/IndexPosition', [
            'fetchData' => $data,
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
    public function store(PositionRequest $request): RedirectResponse {
        Gate::authorize('create', Position::class);
        $create = Position::create(['position_name' => $request->position_name]);
        Session::flash('toast', 'Data berhasil ditambahkan.');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Position $position)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Position $position)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PositionRequest $request, $id): RedirectResponse {
        $data = Position::find($id);
        Gate::authorize('update', $data);
        $data->update([
            'position_name' => $request->position_name
        ]);
        Session::flash('toast', 'Data berhasil diubah.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse {
        $data = Position::find($id);
        Gate::authorize('delete', $data);
        Position::where('id', $id)->delete();
        Session::flash('toast', 'Data berhasil dihapus.');
        return back();
    }
}
