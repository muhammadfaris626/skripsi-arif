<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApprovalTracking;
use App\Models\BusinessCertificateHistory;
use App\Models\CoverLetterHistory;
use App\Models\District;
use App\Models\DomicileCertificateHistory;
use App\Models\Employee;
use App\Models\InabilityCertificateHistory;
use App\Models\MarriageCertificateHistory;
use App\Models\Regency;
use App\Models\Resident;
use App\Models\UnmarriedCertificateHistory;
use App\Models\Village;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiDataController extends Controller
{
    public function getRegency($id) {
        $regencies = Regency::where('province_id', $id)->get();
        return response()->json($regencies);
    }

    public function getDistrict($id) {
        $districts = District::where('regency_id', $id)->get();
        return response()->json($districts);
    }

    public function getVillage($id) {
        $villages = Village::where('district_id', $id)->get();
        return response()->json($villages);
    }

    public function countCertificate($username): JsonResponse {
        if ($username == 'root') {
            $countCoverLetter = CoverLetterHistory::where('is_active', 1)->count();
            $countDomicileCertificate = DomicileCertificateHistory::where('is_active', 1)->count();
            $countBusinessCertificate = BusinessCertificateHistory::where('is_active', 1)->count();
            $countUnmarriedCertificate = UnmarriedCertificateHistory::where('is_active', 1)->count();
            $countInabilityCertificate = InabilityCertificateHistory::where('is_active', 1)->count();
            $count = $countCoverLetter + $countDomicileCertificate + $countBusinessCertificate + $countUnmarriedCertificate + $countInabilityCertificate;
            if ($count == 0) {
                $count = 0;
            }
            return response()->json([
                'count' => $count,
            ]);
        } else {
            $employee = Employee::where('employee_number', $username)->first();
            if (!empty($employee)) {
                $countCoverLetter = CoverLetterHistory::where('approver_id', $employee->position_id)->where('is_active', 1)->count();
                $countDomicileCertificate = DomicileCertificateHistory::where('approver_id', $employee->position_id)->where('is_active', 1)->count();
                $countBusinessCertificate = BusinessCertificateHistory::where('approver_id', $employee->position_id)->where('is_active', 1)->count();
                $countUnmarriedCertificate = UnmarriedCertificateHistory::where('approver_id', $employee->position_id)->where('is_active', 1)->count();
                $countInabilityCertificate = InabilityCertificateHistory::where('approver_id', $employee->position_id)->where('is_active', 1)->count();
                $count = $countCoverLetter + $countDomicileCertificate + $countBusinessCertificate + $countUnmarriedCertificate + $countInabilityCertificate;
                if ($count == 0) {
                    $count = 0;
                }
                return response()->json([
                    'count' => $count,
                ]);
            } else {
                return response()->json([
                    'count' => 0
                ]);
            }
        }
    }

    public function testingWhatsapp($dataList) {
        // Notification Whatsapp
        $resident = Resident::where('resident_number', $dataList['resident_number'])->first();
        $nomor = $dataList['nomor'];
        $tanggal = $dataList['tanggal'];

        if ($dataList['total_approval'] == $dataList['disetujui']) {
            $whatsappMessage = "Halo, *" . $resident->resident_name . "*\n\nPermohonan " . $dataList['type'] . " Anda dengan nomor surat *" . $nomor . "* telah berhasil *DISETUJUI* pada tanggal *" . $tanggal . "*.\n\nUntuk mengunduh atau melihat surat Anda, silahkan kunjungi website berikut:\nhttps://siakkelurahankatimbang.web.id.\n\nJika ada pertanyaan lebih lanjut, silahkan hubungi petugas kami.\n\nTerima kasih.\n\nSalam hormat, SIAK Kelurahan Katimbang";
        } else {
            $whatsappMessage = 'Halo, *'.$resident->resident_name."*\n\nPermohonan" . $dataList['type'] . "Anda dengan nomor referensi *".$nomor."* telah berhasil diajukan pada *".$tanggal."*. Kami akan segera memprosesnya, dan Anda akan menerima pemberitahuan lebih lanjut setelah surat selesai diproses. \n\nHarap menunggu konfirmasi lebih lanjut.\n\nTerima kasih!\n\nSalam hormat,\nSIAK Kelurahan Katimbang";
        }

        $whatsappNumber  = $dataList['whatsapp'];
        $whatsappToken   = 'U58PdWHooqzp63SLAVZX';
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
        return response()->json(['message' => $whatsappMessage]);
    }
}
