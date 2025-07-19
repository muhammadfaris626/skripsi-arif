<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkRequest;
use App\Http\Resources\WorkResource;
use App\Models\Work;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class WorkController extends Controller {

    protected function applySearch($query, $search) {
        return $query->when($search, function($query, $search) {
            $query->where('work_name', 'LIKE', '%' . $search . '%');
        });
    }

    public function index(Request $request): Response {
        Gate::authorize('viewAny', Work::class);
        $searchQuery = Work::query();
        $this->applySearch($searchQuery, $request->search);
        $data = WorkResource::collection($searchQuery->paginate(12));
        return Inertia::render('Settings/Works/IndexWork', [
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
    public function store(WorkRequest $request): RedirectResponse {
        Gate::authorize('create', Work::class);
        $create = Work::create($request->validated());
        Session::flash('toast', 'Data berhasil ditambahkan.');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Work $work)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Work $work)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WorkRequest $request, Work $work): RedirectResponse
    {
        Gate::authorize('update', $work);
        $work->update([
            'work_name' => $request->work_name
        ]);
        Session::flash('toast', 'Data berhasil diubah.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Work $work): RedirectResponse {
        Gate::authorize('delete', $work);
        $work->delete();
        Session::flash('toast', 'Data berhasil dihapus.');
        return back();
    }
}
