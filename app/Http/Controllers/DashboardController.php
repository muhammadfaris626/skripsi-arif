<?php

namespace App\Http\Controllers;

use App\Models\BirthCertificate;
use App\Models\Employee;
use App\Models\FamilyCard;
use App\Models\Resident;
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

        return Inertia::render('Dashboard', [
            'employees' => $employees,
            'familyCards' => $familyCards,
            'residents' => $residents,
            'birthCertificates' => $birthCertificates
        ]);
    }
}
