<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoverLetterRequest;
use App\Http\Resources\CertificateCategoryResource;
use App\Http\Resources\CoverLetterResource;
use App\Http\Resources\PositionResource;
use App\Http\Resources\ResidentResource;
use App\Http\Resources\WorkResource;
use App\Models\ApprovalSetting;
use App\Models\CertificateCategory;
use App\Models\CoverLetter;
use App\Models\CoverLetterHistory;
use App\Models\Position;
use App\Models\Resident;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class CoverLetterController extends Controller {

    protected function applySearch($query, $search) {
        return $query->when($search, function($query, $search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('place_of_birth', 'LIKE', '%' . $search . '%')
                ->orWhere('religion', 'LIKE', '%' . $search . '%')
                ->orWhere('resident_number', 'LIKE', '%' . $search . '%')
                ->orWhere('family_number', 'LIKE', '%' . $search . '%');
        });
    }

    public function index(Request $request): Response {
        Gate::authorize('viewAny', CoverLetter::class);
        if (Auth::user()->roles[0]['name'] == 'user') {
            $searchQuery = CoverLetter::query()->where('user_id', Auth::user()->id)->orderBy('id', 'DESC');
        } else {
            $searchQuery = CoverLetter::query()->orderBy('id', 'DESC');
        }
        $this->applySearch($searchQuery, $request->search);
        $data = CoverLetterResource::collection($searchQuery->paginate(12));
        return Inertia::render('Forms/CoverLetters/IndexCoverLetter', [
            'fetchData' => $data,
            'search' => $request->search ?? '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response {
        Gate::authorize('create', CoverLetter::class);
        $currentMonth = date('n'); // Mendapatkan bulan saat ini dalam angka (1-12)
        $romanMonth = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'][$currentMonth];
        $count = CoverLetter::count();
        $number = str_pad($count == 0 ? 1 : $count + 1, 3, '0', STR_PAD_LEFT);
        $resident = Resident::where('resident_number', Auth::user()->username)->first();
        $requestNumber = $number."/RT.".$resident->familyCard->rt."/RW.".$resident->familyCard->rw."/KTB/".$romanMonth."/".date('Y');
        $positionName = "Kepala RT ".$resident->familyCard->rt." / RW ".$resident->familyCard->rw;
        $position = Position::where('position_name', $positionName)->first();
        $certificateCategory = CertificateCategory::where('certificate_category_name', 'Surat Pengantar')->first();
        $certificateCategories = CertificateCategory::all()->reject(function($category) {
            return $category->certificate_category_name === 'Surat Pengantar';
        });
        return Inertia::render('Forms/CoverLetters/CreateCoverLetter', [
            'requestNumber' => $requestNumber,
            'resident' => new ResidentResource($resident),
            'position' => new PositionResource($position),
            'certificateCategory' => new CertificateCategoryResource($certificateCategory),
            'works' => WorkResource::collection(Work::all()),
            'certificateCategories' => CertificateCategoryResource::collection($certificateCategories)
        ]);
    }

public function store(CoverLetterRequest $request): RedirectResponse {
    Gate::authorize('create', CoverLetter::class);
    $create = CoverLetter::create([
        'request_number'          => $request->request_number,
        'user_id'                 => $request->user_id,
        'resident_id'             => $request->resident_id,
        'name'                    => $request->name,
        'place_of_birth'          => $request->place_of_birth,
        'date_of_birth'           => $request->date_of_birth,
        'gender'                  => $request->gender,
        'religion'                => $request->religion,
        'work_id'                 => $request->work_id['id'],
        'address'                 => $request->address,
        'resident_number'         => $request->resident_number,
        'family_number'           => $request->family_number,
        'certificate_category_id' => $request->certificate_category_id['id']
    ]);
    $approvalSetting = ApprovalSetting::where('certificate_category_id', $request->certificateCategory)->where('position_id', $request->position_id)->first();
    for ($i=1; $i <= $approvalSetting->step; $i++) {
        CoverLetterHistory::create([
            'certificate_id'          => $create->id,
            'certificate_category_id' => $approvalSetting->certificate_category_id,
            'step'                    => $i,
            'approver_id'             => $approvalSetting->{'approver_' . $i},
            'status'                  => 'Proses',
            'is_active'               => $i == 1 ? 1 : 0
        ]);
    }
    $letter = new CoverLetterResource(CoverLetter::where('id', $create->id)->first());
    // Notification Whatsapp
    $whatsappMessage = '
        Halo, *'.$letter->resident->resident_name."*\n\nPermohonan Surat Pengantar Anda dengan nomor referensi *"
        .$letter->request_number."* telah berhasil diajukan pada *".Carbon::parse($letter->created_at)->translatedFormat('j F Y')
        ."*. Kami akan segera memprosesnya, dan Anda akan menerima pemberitahuan lebih lanjut setelah surat selesai diproses.
        \n\nHarap menunggu konfirmasi lebih lanjut.\n\nTerima kasih!\n\nSalam hormat,\nSIAK Kelurahan Katimbang";
    $whatsappNumber  = $letter->resident->phone_number;
    $whatsappToken   = '1ASQEtpn-MR3AdxVg!Gn';
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('target' => $whatsappNumber,'message' => $whatsappMessage),
        CURLOPT_HTTPHEADER => array(
            'Authorization: '. $whatsappToken
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    Session::flash('toast', 'Data berhasil ditambahkan.');
    return to_route('cover-letters.index');
}

    /**
     * Display the specified resource.
     */
    public function show(CoverLetter $coverLetter): Response {
        return Inertia::render('Forms/CoverLetters/ShowCoverLetter', [
            'fetchData' => new CoverLetterResource($coverLetter)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CoverLetter $coverLetter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CoverLetter $coverLetter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CoverLetter $coverLetter)
    {
        //
    }
}
