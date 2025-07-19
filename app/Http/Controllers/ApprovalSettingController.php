<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApprovalSettingRequest;
use App\Http\Resources\ApprovalSettingResource;
use App\Http\Resources\CertificateCategoryResource;
use App\Http\Resources\PositionResource;
use App\Models\ApprovalSetting;
use App\Models\CertificateCategory;
use App\Models\Position;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class ApprovalSettingController extends Controller {

    protected function applySearch($query, $search) {
        return $query->when($search, function($query, $search) {
            $query->where('id', 'LIKE', '%' . $search . '%')
                ->orWhereHas('position', function($query) use($search) {
                    $query->where('position_name', 'LIKE', '%' . $search . '%');
                });
        });
    }

    public function index(Request $request): Response {
        Gate::authorize('viewAny', ApprovalSetting::class);
        $searchQuery = ApprovalSetting::query();
        $this->applySearch($searchQuery, $request->search);
        $data = ApprovalSettingResource::collection($searchQuery->orderBy('id', 'DESC')->paginate(12));
        return Inertia::render('Settings/ApprovalSettings/IndexApprovalSetting', [
            'fetchData' => $data,
            'search' => $request->search ?? '',
            'positions' => PositionResource::collection(Position::all()),
            'certificateCategories' => CertificateCategoryResource::collection(CertificateCategory::all())
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
    public function store(ApprovalSettingRequest $request): RedirectResponse {
        Gate::authorize('create', ApprovalSetting::class);
        // dd($request);
        ApprovalSetting::create($request->validated());
        Session::flash('toast', 'Data berhasil ditambahkan.');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(ApprovalSetting $approvalSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ApprovalSetting $approvalSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ApprovalSettingRequest $request, ApprovalSetting $approvalSetting): RedirectResponse{
        Gate::authorize('update', $approvalSetting);
        // Daftar approver yang mungkin ada
        $approvers = ['approver_1', 'approver_2', 'approver_3', 'approver_4', 'approver_5'];

        // Tentukan berapa banyak approver yang harus dihapus
        $removeCount = 5 - $request->step; // Hitung jumlah approver yang perlu dihapus

        if ($removeCount > 0) {
            $toRemove = array_slice($approvers, -$removeCount); // Ambil approver yang perlu dihapus
            $request->merge(array_fill_keys($toRemove, null)); // Hapus nilai dengan mengatur menjadi null
        }

        // Update data
        $approvalSetting->update([
            'certificate_category_id' => $request->certificate_category_id,
            'position_id' => $request->position_id,
            'step' => $request->step,
            'approver_1' => $request->input('approver_1'),
            'approver_2' => $request->input('approver_2'),
            'approver_3' => $request->input('approver_3'),
            'approver_4' => $request->input('approver_4'),
            'approver_5' => $request->input('approver_5'),
        ]);
        Session::flash('toast', 'Data berhasil diubah.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApprovalSetting $approvalSetting): RedirectResponse {
        Gate::authorize('delete', $approvalSetting);
        $approvalSetting->delete();
        Session::flash('toast', 'Data berhasil dihapus.');
        return back();
    }
}
