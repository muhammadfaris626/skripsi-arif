<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarriageCertificateRequest;
use App\Http\Resources\MarriageCertificateResource;
use App\Http\Resources\WorkResource;
use App\Models\ApprovalSetting;
use App\Models\MarriageCertificate;
use App\Models\MarriageCertificateHistory;
use App\Models\Work;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class MarriageCertificateController extends Controller {

    protected function applySearch($query, $search) {
        return $query->when($search, function($query, $search) {
            $query->where('request_number', 'LIKE', '%' . $search . '%')
                ->orWhereHas('users', function($query) use($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%');
                })
                ->orWhere('name', 'LIKE', '%' . $search . '%');
        });
    }

    public function index(Request $request): Response {
        Gate::authorize('viewAny', MarriageCertificate::class);
        if (Auth::user()->roles[0]['name'] == 'user') {
            $fetch = MarriageCertificate::query()->where('user_id', Auth::user()->id)->orderBy('id', 'DESC');
        } else {
            $fetch = MarriageCertificate::orderBy('id', 'DESC');
        }
        $this->applySearch($fetch, $request->search);
        $data = MarriageCertificateResource::collection($fetch->paginate(12));
        return Inertia::render('Forms/MarriageCertificates/IndexMarriageCertificate', [
            'fetchData' => $data,
            'search' => $request->search ?? ''
        ]);
    }

    public function create(): Response {
        Gate::authorize('create', MarriageCertificate::class);
        $currentMonth = date('n'); // Mendapatkan bulan saat ini dalam angka (1-12)
        $romanMonth = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'][$currentMonth];
        $count = MarriageCertificate::count();
        $number = str_pad($count == 0 ? 1 : $count + 1, 3, '0', STR_PAD_LEFT);
        $requestNumber = '472/SKM/'.$number."/".$romanMonth."/".date('Y');
        return Inertia::render('Forms/MarriageCertificates/CreateMarriageCertificate', [
            'requestNumber' => $requestNumber,
            'works' => WorkResource::collection(Work::all())
        ]);
    }

    public function store(MarriageCertificateRequest $request): RedirectResponse {
        Gate::authorize('create', MarriageCertificate::class);
        $create = MarriageCertificate::create([
            'request_number' => $request->request_number,
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'place_of_birth' => $request->place_of_birth,
            'date_of_birth' => $request->date_of_birth,
            'work_id' => $request->work_id,
            'couple_name' => $request->couple_name,
            'partner_address' => $request->partner_address,
            'guardian_name' => $request->guardian_name,
            'wedding_date' => $request->wedding_date,
            'name_of_the_chief' => $request->name_of_the_chief,
            'bride_price' => $request->bride_price,
            'witness_name' => $request->witness_name
        ]);
        $checkApprovalSetting = ApprovalSetting::where('approval_category', 'Surat Keterangan Menikah')->first();
        for ($i=1; $i <= $checkApprovalSetting->step; $i++) {
            MarriageCertificateHistory::create([
                'certificate_id' => $create->id,
                'approval_category' => $checkApprovalSetting->approval_category,
                'step' => $i,
                'approver_id' => $checkApprovalSetting->{'approver_' . $i},
                'status' => 'Proses',
                'is_active' => $i == 1 ? 1 : 0,
            ]);
        }
        Session::flash('toast', 'Data berhasil ditambahkan.');
        return to_route('marriage-certificates.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(MarriageCertificate $marriageCertificate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MarriageCertificate $marriageCertificate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MarriageCertificate $marriageCertificate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MarriageCertificate $marriageCertificate)
    {
        //
    }
}
