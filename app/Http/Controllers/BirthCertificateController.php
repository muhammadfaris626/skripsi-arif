<?php

namespace App\Http\Controllers;

use App\Http\Requests\BirthCertificateRequest;
use App\Http\Resources\BirthCertificateResource;
use App\Http\Resources\FamilyCardResource;
use App\Models\BirthCertificate;
use App\Models\FamilyCard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class BirthCertificateController extends Controller {
    protected function applySearch($query, $search) {
        return $query->when($search, function($query, $search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('religion', 'LIKE', '%' . $search . '%')
                ->orWhereHas('familyCard', function($query) use($search) {
                    $query->where('family_number', 'LIKE', '%' . $search . '%')
                        ->orWhere('name', 'LIKE', '%' . $search . '%');
                });
        });
    }

    public function index(Request $request): Response {
        Gate::authorize('viewAny', BirthCertificate::class);
        $searchQuery = BirthCertificate::query();
        $this->applySearch($searchQuery, $request->search);
        $data = BirthCertificateResource::collection($searchQuery->orderBy('id', 'DESC')->paginate(12));
        return Inertia::render('Data/BirthCertificates/IndexBirthCertificate', [
            'fetchData' => $data,
            'search' => $request->search ?? '',
            'familyCards' => FamilyCardResource::collection(FamilyCard::all())
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
    public function store(BirthCertificateRequest $request): RedirectResponse {
        Gate::authorize('create', BirthCertificate::class);
        BirthCertificate::create([
            'name' => $request->name,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'place_of_birth' => $request->place_of_birth,
            'date_of_birth' => $request->date_of_birth,
            'time_of_birth' => $request->time_of_birth,
            'family_card_id' => $request->family_card_id['id'],
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'address' => $request->address,
            'child_from' => $request->child_from,
            'give_birth_in' => $request->give_birth_in,
            'birth_location' => $request->birth_location,
            'weight' => $request->weight,
            'birth_certificate' => $request->birth_certificate,
        ]);
        Session::flash('toast', 'Data berhasil ditambahkan.');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(BirthCertificate $birthCertificate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BirthCertificate $birthCertificate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BirthCertificateRequest $request, BirthCertificate $birthCertificate): RedirectResponse {
        Gate::authorize('update', $birthCertificate);
        $familyCard = isset($request->family_card_id[0]['id']) ? $request->family_card_id[0]['id'] : $request->family_card_id['id'];
        $birthCertificate->update([
            'name' => $request->name,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'place_of_birth' => $request->place_of_birth,
            'date_of_birth' => $request->date_of_birth,
            'time_of_birth' => $request->time_of_birth,
            'family_card_id' => $familyCard,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'address' => $request->address,
            'child_from' => $request->child_from,
            'give_birth_in' => $request->give_birth_in,
            'birth_location' => $request->birth_location,
            'weight' => $request->weight,
            'birth_certificate' => $request->birth_certificate,
        ]);
        Session::flash('toast', 'Data berhasil diubah.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BirthCertificate $birthCertificate): RedirectResponse {
        Gate::authorize('delete', $birthCertificate);
        $birthCertificate->delete();
        Session::flash('toast', 'Data berhasil dihapus.');
        return back();
    }
}
