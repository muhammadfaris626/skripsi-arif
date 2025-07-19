<?php

namespace App\Http\Controllers;

use App\Http\Resources\BusinessCertificateHistoryResource;
use App\Http\Resources\CoverLetterHistoryResource;
use App\Http\Resources\DomicileCertificateHistoryResource;
use App\Http\Resources\InabilityCertificateHistoryResource;
use App\Http\Resources\MarriageCertificateHistoryResource;
use App\Http\Resources\UnmarriedCertificateHistoryResource;
use App\Models\BusinessCertificate;
use App\Models\BusinessCertificateHistory;
use App\Models\CoverLetterHistory;
use App\Models\DomicileCertificate;
use App\Models\DomicileCertificateHistory;
use App\Models\Employee;
use App\Models\InabilityCertificate;
use App\Models\InabilityCertificateHistory;
use App\Models\MarriageCertificateHistory;
use App\Models\UnmarriedCertificate;
use App\Models\UnmarriedCertificateHistory;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class NotificationController extends Controller {

    protected function applySearch($query, $search, $employeeId) {
        return $query->where('approver_id', $employeeId)->when($search, function($query) use ($search) {
            $query->where(function($query) use ($search) {
                $query->whereHas('certificate', function($query) use($search) {
                    $query->where('request_number', 'LIKE', '%' . $search . '%')
                        ->orWhere('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('resident_number', 'LIKE', '%' . $search . '%')
                        ->orWhere('family_number', 'LIKE', '%' . $search . '%');
                });
            });
        });
    }

    public function index(): Response {
        if (Gate::allows('notification: menu')) {
            if (Auth::user()->roles[0]->name == 'root') {
                $countCoverLetter = CoverLetterHistory::where('is_active', 1)->count();
                $countDomicileCertificate = DomicileCertificateHistory::where('is_active', 1)->count();
                $countBusinessCertificate = BusinessCertificateHistory::where('is_active', 1)->count();
                $countUnmarriedCertificate = UnmarriedCertificateHistory::where('is_active', 1)->count();
                $countInabilityCertificate = InabilityCertificateHistory::where('is_active', 1)->count();
            } else {
                $employee = Employee::where('employee_number', Auth::user()->username)->first();
                $countCoverLetter = CoverLetterHistory::where('approver_id', $employee->position_id)->where('is_active', 1)->count();
                $countDomicileCertificate = DomicileCertificateHistory::where('approver_id', $employee->position_id)->where('is_active', 1)->count();
                $countBusinessCertificate = BusinessCertificateHistory::where('approver_id', $employee->position_id)->where('is_active', 1)->count();
                $countUnmarriedCertificate = UnmarriedCertificateHistory::where('approver_id', $employee->position_id)->where('is_active', 1)->count();
                $countInabilityCertificate = InabilityCertificateHistory::where('approver_id', $employee->position_id)->where('is_active', 1)->count();
            }

            return Inertia::render('Notifications/IndexNotification', [
                'countCoverLetter'          => $countCoverLetter,
                'countDomicileCertificate'  => $countDomicileCertificate,
                'countBusinessCertificate'  => $countBusinessCertificate,
                'countUnmarriedCertificate' => $countUnmarriedCertificate,
                'countInabilityCertificate' => $countInabilityCertificate
            ]);
        } else {
            abort(403, 'Access Denied');
        }
    }

    public function certificate(Request $request): Response {
        $employee = Employee::where('employee_number', Auth::user()->username)->first();
        if ($request->certificate == 'cover-letter') {
            $path = 'Notifications/CoverLetter';
            $searchQuery = CoverLetterHistory::query()
                ->select('id', 'certificate_id', 'certificate_category_id', 'step', 'approver_id', 'status', 'is_active')
                ->orderBy('id', 'DESC');
            if (Auth::user()->roles[0]->name != 'root') {
                $this->applySearch($searchQuery, $request->search, $employee->position_id);
            }
            $data = CoverLetterHistoryResource::collection($searchQuery->paginate(12));
        } elseif ($request->certificate == 'domicile-certificate') {
            $path = 'Notifications/DomicileCertificate';
            $searchQuery = DomicileCertificateHistory::query()
                ->select('id', 'certificate_id', 'certificate_category_id', 'step', 'approver_id', 'status', 'is_active')
                ->orderBy('id', 'DESC');
            if (Auth::user()->roles[0]->name != 'root') {
                $this->applySearch($searchQuery, $request->search, $employee->position_id);
            }
            $data = DomicileCertificateHistoryResource::collection($searchQuery->paginate(12));
        } elseif ($request->certificate == 'business-certificate') {
            $path = 'Notifications/BusinessCertificate';
            $searchQuery = BusinessCertificateHistory::query()
                ->select('id', 'certificate_id', 'certificate_category_id', 'step', 'approver_id', 'status', 'is_active')
                ->orderBy('id', 'DESC');
            if (Auth::user()->roles[0]->name != 'root') {
                $this->applySearch($searchQuery, $request->search, $employee->position_id);
            }
            $data = BusinessCertificateHistoryResource::collection($searchQuery->paginate(12));
        } elseif ($request->certificate == 'unmarried-certificate') {
            $path = 'Notifications/UnmarriedCertificate';
            $searchQuery = UnmarriedCertificateHistory::query()
                ->select('id', 'certificate_id', 'certificate_category_id', 'step', 'approver_id', 'status', 'is_active')
                ->orderBy('id', 'DESC');
            if (Auth::user()->roles[0]->name != 'root') {
                $this->applySearch($searchQuery, $request->search, $employee->position_id);
            }
            $data = UnmarriedCertificateHistoryResource::collection($searchQuery->paginate(12));
        } elseif ($request->certificate == 'inability-certificate') {
            $path = 'Notifications/InabilityCertificate';
            $searchQuery = InabilityCertificateHistory::query()
                ->select('id', 'certificate_id', 'certificate_category_id', 'step', 'approver_id', 'status', 'is_active')
                ->orderBy('id', 'DESC');
            if (Auth::user()->roles[0]->name != 'root') {
                $this->applySearch($searchQuery, $request->search, $employee->position_id);
            }
            $data = InabilityCertificateHistoryResource::collection($searchQuery->paginate(12));
        }
        return Inertia::render($path, [
            'fetchData' => $data,
            'search' => $request->search ?? '',
            'certificate' => $request->certificate
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse {
        if ($request->approvalCategory == "Surat Pengantar") {
            $history = CoverLetterHistory::find($id);
            $history->update([
                'status' => $request->statusApproval,
                'is_active' => '0'
            ]);
            $check = CoverLetterHistory::where('certificate_id', $history->certificate_id)->where('step', $history->step+1)->first();
            if (!empty($check)) {
                $check->update([
                    'is_active' => '1'
                ]);
            }
        } elseif ($request->approvalCategory == "Surat Keterangan Domisili") {
            $history = DomicileCertificateHistory::find($id);
            $history->update([
                'status' => $request->statusApproval,
                'is_active' => '0'
            ]);
            $check = DomicileCertificateHistory::where('certificate_id', $history->certificate_id)->where('step', $history->step+1)->first();
            if (!empty($check)) {
                $check->update([
                    'is_active' => '1'
                ]);
            } else {
                $certificate = DomicileCertificate::where('id', $history->certificate_id)->first();
                $certificate->update([
                    'validity_period' => Carbon::now()->addMonth()
                ]);
            }
        } elseif ($request->approvalCategory == "Surat Keterangan Usaha") {
            $history = BusinessCertificateHistory::find($id);
            $history->update([
                'status' => $request->statusApproval,
                'is_active' => '0'
            ]);
            $check = BusinessCertificateHistory::where('certificate_id', $history->certificate_id)->where('step', $history->step+1)->first();
            if (!empty($check)) {
                $check->update([
                    'is_active' => '1'
                ]);
            } else {
                $certificate = BusinessCertificate::where('id', $history->certificate_id)->first();
                $certificate->update([
                    'validity_period' => Carbon::now()->addMonth()
                ]);
            }
        } elseif ($request->approvalCategory == "Surat Keterangan Belum Menikah") {
            $history = UnmarriedCertificateHistory::find($id);
            $history->update([
                'status' => $request->statusApproval,
                'is_active' => '0'
            ]);
            $check = UnmarriedCertificateHistory::where('certificate_id', $history->certificate_id)->where('step', $history->step+1)->first();
            if (!empty($check)) {
                $check->update([
                    'is_active' => '1'
                ]);
            } else {
                $certificate = UnmarriedCertificate::where('id', $history->certificate_id)->first();
                $certificate->update([
                    'validity_period' => Carbon::now()->addMonth()
                ]);
            }
        } elseif ($request->approvalCategory == "Surat Keterangan Tidak Mampu") {
            $history = InabilityCertificateHistory::find($id);
            $history->update([
                'status' => $request->statusApproval,
                'is_active' => '0'
            ]);
            $check = InabilityCertificateHistory::where('certificate_id', $history->certificate_id)->where('step', $history->step+1)->first();
            if (!empty($check)) {
                $check->update([
                    'is_active' => '1'
                ]);
            } else {
                $certificate = InabilityCertificate::where('id', $history->certificate_id)->first();
                $certificate->update([
                    'validity_period' => Carbon::now()->addMonth()
                ]);
            }
        }
        Session::flash('toast', 'Persetujuan surat berhasil dilakukan.');
        return back();
    }
}
