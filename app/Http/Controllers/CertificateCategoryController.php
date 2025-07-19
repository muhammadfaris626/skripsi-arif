<?php

namespace App\Http\Controllers;

use App\Http\Requests\CertificateCategoryRequest;
use App\Http\Resources\CertificateCategoryResource;
use App\Models\CertificateCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class CertificateCategoryController extends Controller {

    protected function applySearch($query, $search) {
        return $query->when($search, function($query, $search) {
            $query->where('certificate_category_name', 'LIKE', '%' . $search . '%');
        });
    }

    public function index(Request $request): Response {
        Gate::authorize('viewAny', CertificateCategory::class);
        $searchQuery = CertificateCategory::query();
        $this->applySearch($searchQuery, $request->search);
        $data = CertificateCategoryResource::collection($searchQuery->paginate(12));
        return Inertia::render('Settings/CertificateCategories/IndexCertificateCategory', [
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
    public function store(CertificateCategoryRequest $request): RedirectResponse {
        Gate::authorize('create', CertificateCategory::class);
        CertificateCategory::create(['certificate_category_name' => $request->certificate_category_name]);
        Session::flash('toast', 'Data berhasil ditambahkan.');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(CertificateCategory $certificateCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CertificateCategory $certificateCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CertificateCategoryRequest $request, CertificateCategory $certificateCategory): RedirectResponse {
        Gate::authorize('update', $certificateCategory);
        $certificateCategory->update([
            'certificate_category_name' => $request->certificate_category_name
        ]);
        Session::flash('toast', 'Data berhasil diubah.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CertificateCategory $certificateCategory): RedirectResponse {
        Gate::authorize('delete', $certificateCategory);
        $certificateCategory->delete();
        Session::flash('toast', 'Data berhasil dihapus.');
        return back();
    }
}
