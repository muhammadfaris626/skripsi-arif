<?php

namespace App\Http\Controllers;

use App\Http\Requests\EducationRequest;
use App\Http\Resources\EducationResource;
use App\Models\Education;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class EducationController extends Controller {

    protected function applySearch($query, $search) {
        return $query->when($search, function($query, $search) {
            $query->where('work_name', 'LIKE', '%' . $search . '%');
        });
    }

    public function index(Request $request): Response {
        Gate::authorize('viewAny', Education::class);
        $searchQuery = Education::query();
        $this->applySearch($searchQuery, $request->search);
        $data = EducationResource::collection($searchQuery->paginate(12));
        return Inertia::render('Settings/Educations/IndexEducation', [
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
    public function store(EducationRequest $request): RedirectResponse {
        Gate::authorize('create', Education::class);
        $create = Education::create($request->validated());
        Session::flash('toast', 'Data berhasil ditambahkan.');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Education $education)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Education $education)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EducationRequest $request, Education $education): RedirectResponse
    {
        Gate::authorize('update', $education);
        $education->update([
            'education_name' => $request->education_name
        ]);
        Session::flash('toast', 'Data berhasil diubah.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Education $education): RedirectResponse
    {
        Gate::authorize('delete', $education);
        $education->delete();
        Session::flash('toast', 'Data berhasil dihapus.');
        return back();
    }
}
