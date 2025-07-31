<?php

namespace App\Http\Controllers;

use App\Models\BirthCertificate;
use App\Models\BusinessCertificate;
use App\Models\CoverLetter;
use App\Models\DomicileCertificate;
use App\Models\Employee;
use App\Models\FamilyCard;
use App\Models\InabilityCertificate;
use App\Models\Resident;
use App\Models\UnmarriedCertificate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response {
        $employees = Employee::count();
        $familyCards = FamilyCard::count();
        $residents = Resident::count();
        $birthCertificates = BirthCertificate::count();

        // Tahun sekarang
        $currentYear = Carbon::now()->year;
        // $currentYear = Carbon::now()->subYear()->year;
        // Surat Pengantar
        $suratPengantar = CoverLetter::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->pluck('count', 'month');
        $suratPengantarData = [];
        for ($a=1; $a <= 12; $a++) {
            $suratPengantarData[] = $suratPengantar[$a] ?? 0;
        }
        // Surat Domisili
        $suratDomisili = DomicileCertificate::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->pluck('count', 'month');
        $suratDomisiliData = [];
        for ($b=1; $b <= 12; $b++) {
            $suratDomisiliData[] = $suratDomisili[$b] ?? 0;
        }
        // Surat Keterangan Usaha
        $suratUsaha = BusinessCertificate::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->pluck('count', 'month');
        $suratUsahaData = [];
        for ($c=0; $c <= 12; $c++) {
            $suratUsahaData[] = $suratUsaha[$c] ?? 0;
        }
        // Surat Keterangan Belum Menikah
        $suratBelumMenikah = UnmarriedCertificate::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->pluck('count', 'month');
        $suratBelumMenikahData = [];
        for ($d=0; $d <= 12; $d++) {
            $suratBelumMenikahData[] = $suratBelumMenikah[$d] ?? 0;
        }
        // Surat Keterangan Tidak Mampu
        $suratTidakMampu = InabilityCertificate::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->pluck('count', 'month');
        $suratTidakMampuData = [];
        for ($e=0; $e <= 12; $e++) {
            $suratTidakMampuData[] = $suratTidakMampu[$e] ?? 0;
        }

        return Inertia::render('Dashboard', [
            'employees' => $employees,
            'familyCards' => $familyCards,
            'residents' => $residents,
            'birthCertificates' => $birthCertificates,
            'suratPengantarData' => $suratPengantarData,
            'suratDomisiliData' => $suratDomisiliData,
            'suratUsahaData' => $suratUsahaData,
            'suratBelumMenikahData' => $suratBelumMenikahData,
            'suratTidakMampuData' => $suratTidakMampuData
        ]);
    }
}
