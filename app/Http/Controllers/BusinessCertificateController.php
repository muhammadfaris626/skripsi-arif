<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessCertificateRequest;
use App\Http\Resources\BusinessCertificateResource;
use App\Http\Resources\CoverLetterResource;
use App\Http\Resources\ResidentResource;
use App\Http\Resources\WorkResource;
use App\Models\ApprovalSetting;
use App\Models\BusinessCertificate;
use App\Models\BusinessCertificateHistory;
use App\Models\CertificateCategory;
use App\Models\CoverLetter;
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

class BusinessCertificateController extends Controller {

    protected function applySearch($query, $search) {
        return $query->when($search, function($query, $search) {
            $query->where('request_number', 'LIKE', '%' . $search . '%')
                ->orWhereHas('users', function($query) use($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%');
                })
                ->orWhere('business_name', 'LIKE', '%' . $search . '%')
                ->orWhere('long_term', 'LIKE', '%' . $search . '%');
        });
    }

    public function index(Request $request): Response{
        Gate::authorize('viewAny', BusinessCertificate::class);
        if (Auth::user()->roles[0]['name'] == 'user') {
            $fetch = BusinessCertificate::query()->where('user_id', Auth::user()->id)->orderBy('id', 'DESC');
        } else {
            $fetch = BusinessCertificate::orderBy('id', 'DESC');
        }
        $this->applySearch($fetch, $request->search);
        $data = BusinessCertificateResource::collection($fetch->paginate(12));
        return Inertia::render('Forms/BusinessCertificates/IndexBusinessCertificate', [
            'fetchData' => $data,
            'search' => $request->search ?? '',

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response {
        Gate::authorize('create', BusinessCertificate::class);
        $currentMonth = date('n'); // Mendapatkan bulan saat ini dalam angka (1-12)
        $romanMonth = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'][$currentMonth];
        $count = BusinessCertificate::count();
        $number = str_pad($count == 0 ? 1 : $count + 1, 3, '0', STR_PAD_LEFT);
        $requestNumber = '503/'.$number."/KTB/".$romanMonth."/".date('Y');
        $resident = Resident::where('resident_number', Auth::user()->username)->first();
        $category = CertificateCategory::where('certificate_category_name', 'Surat Keterangan Usaha')->first();
        $coverLetters = CoverLetter::where('user_id', Auth::user()->id)
            ->where('certificate_category_id', $category->id)
            ->where('status', 0)
            ->withCount(['coverLetterHistory as approved_count' => function($query) {
                $query->where('status', 'Disetujui');
            }])
            ->withCount('coverLetterHistory')
            ->having('cover_letter_history_count', '>', 0)
            ->havingRaw('approved_count = cover_letter_history_count')
            ->get();
        return Inertia::render('Forms/BusinessCertificates/CreateBusinessCertificate', [
            'requestNumber' => $requestNumber,
            'resident' => new ResidentResource($resident),
            'works' => WorkResource::collection(Work::all()),
            'coverLetters' => CoverLetterResource::collection($coverLetters)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BusinessCertificateRequest $request): RedirectResponse{
        Gate::authorize('create', BusinessCertificate::class);
        $create = BusinessCertificate::create([
            'cover_letter_id'   => $request->cover_letter_id['id'],
            'request_number'    => $request->request_number,
            'user_id'           => $request->user_id,
            'resident_id'       => $request->resident_id,
            'name'              => $request->name,
            'resident_number'   => $request->resident_number,
            'place_of_birth'    => $request->place_of_birth,
            'date_of_birth'     => $request->date_of_birth,
            'religion'          => $request->religion,
            'gender'            => $request->gender,
            'work_id'           => $request->work_id['id'],
            'address'           => $request->address,
            'business_name'     => $request->business_name,
            'business_address'  => $request->business_address,
            'long_term'         => $request->long_term,
            'description'       => $request->description,
            'validity_period'   => ''
        ]);
        $position = Position::where('position_name', 'Seksi Pemerintahan, Ketentraman dan Ketertiban Umum')->first();
        $category = CertificateCategory::where('certificate_category_name', 'Surat Keterangan Usaha')->first();
        $checkApprovalSetting = ApprovalSetting::where('certificate_category_id', $category->id)->where('position_id', $position->id)->first();
        for ($i=1; $i <= $checkApprovalSetting->step; $i++) {
            BusinessCertificateHistory::create([
                'certificate_id'    => $create->id,
                'certificate_category_id' => $checkApprovalSetting->certificate_category_id,
                'step'              => $i,
                'approver_id'       => $checkApprovalSetting->{'approver_' . $i},
                'status'            => 'Proses',
                'is_active'         => $i == 1 ? 1 : 0
            ]);
        }

        $letter = new BusinessCertificateResource(BusinessCertificate::where('id', $create->id)->first());
        // Notification Whatsapp
        $whatsappMessage = 'Halo, *'.$letter->resident->resident_name."*\n\nPermohonan Surat Keterangan Usaha Anda dengan nomor referensi *".$letter->request_number."* telah berhasil diajukan pada *".Carbon::parse($letter->created_at)->translatedFormat('j F Y')."*. Kami akan segera memprosesnya, dan Anda akan menerima pemberitahuan lebih lanjut setelah surat selesai diproses. \n\nHarap menunggu konfirmasi lebih lanjut.\n\nTerima kasih!\n\nSalam hormat,\nSIAK Kelurahan Katimbang";
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
        return to_route('businessCertificates.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(BusinessCertificate $businessCertificate): Response {
        return Inertia::render('Forms/BusinessCertificates/ShowBusinessCertificate', [
            'fetchData' => new BusinessCertificateResource($businessCertificate)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BusinessCertificate $businessCertificate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BusinessCertificate $businessCertificate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BusinessCertificate $businessCertificate)
    {
        //
    }
}
