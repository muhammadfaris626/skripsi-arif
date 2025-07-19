<?php

namespace App\Http\Controllers;

use App\Http\Requests\FamilyCardRequest;
use App\Http\Resources\FamilyCardResource;
use App\Http\Resources\ProvinceResource;
use App\Models\FamilyCard;
use App\Models\Province;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class FamilyCardController extends Controller {

    protected function applySearch($query, $search) {
        return $query->when($search, function($query, $search) {
            $query->select('family_cards.*',
                'provinces.name as province_name',
                'regencies.name as regency_name',
                'districts.name as district_name',
                'villages.name as village_name')
                ->leftJoin('provinces', 'provinces.id', '=', 'family_cards.province_id')
                ->leftJoin('regencies', 'regencies.id', '=', 'family_cards.regency_id')
                ->leftJoin('districts', 'districts.id', '=', 'family_cards.district_id')
                ->leftJoin('villages', 'villages.id', '=', 'family_cards.village_id')
                ->where('family_cards.family_number', 'LIKE', '%' . $search . '%')
                ->orWhere('family_cards.name', 'LIKE', '%' . $search . '%')
                ->orWhere('family_cards.address', 'LIKE', '%' . $search . '%')
                ->orWhere('family_cards.rt', 'LIKE', '%' . $search . '%')
                ->orWhere('family_cards.rw', 'LIKE', '%' . $search . '%')
                ->orWhere('family_cards.postal_code', 'LIKE', '%' . $search . '%')
                ->orWhere('provinces.name', 'LIKE', '%' . $search . '%')
                ->orWhere('regencies.name', 'LIKE', '%' . $search . '%')
                ->orWhere('districts.name', 'LIKE', '%' . $search . '%')
                ->orWhere('villages.name', 'LIKE', '%' . $search . '%');
        });
    }

    public function index(Request $request): Response {
        Gate::authorize('viewAny', FamilyCard::class);
        $searchQuery = FamilyCard::query();
        $this->applySearch($searchQuery, $request->search);
        $data = FamilyCardResource::collection($searchQuery->paginate(12));
        return Inertia::render('Data/FamilyCards/IndexFamilyCard', [
            'fetchData' => $data,
            'search' => $request->search ?? '',
            'provinces' => ProvinceResource::collection(Province::all())
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
    public function store(FamilyCardRequest $request): RedirectResponse {
        Gate::authorize('create', FamilyCard::class);
        FamilyCard::create([
            'family_number' => $request->family_number,
            'name' => $request->name,
            'address' => $request->address,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'province_id' => $request->province_id['id'],
            'regency_id' => $request->regency_id['id'],
            'district_id' => $request->district_id['id'],
            'village_id' => $request->village_id['id'],
            'postal_code' => $request->postal_code
        ]);
        Session::flash('toast', 'Data berhasil ditambahkan.');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(FamilyCard $familyCard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FamilyCard $familyCard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FamilyCardRequest $request, FamilyCard $familyCard): RedirectResponse {
        Gate::authorize('update', $familyCard);

        $province = isset($request->province_id[0]['id']) ? $request->province_id[0]['id'] : $request->province_id['id'];
        $regency = isset($request->regency_id[0]['id']) ? $request->regency_id[0]['id'] : $request->regency_id['id'];
        $district = isset($request->district_id[0]['id']) ? $request->district_id[0]['id'] : $request->district_id['id'];
        $village = isset($request->village_id[0]['id']) ? $request->village_id[0]['id'] : $request->village_id['id'];

        $familyCard->update([
            'family_number' => $request->family_number,
            'name' => $request->name,
            'address' => $request->address,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'province_id' => $province,
            'regency_id' => $regency,
            'district_id' => $district,
            'village_id' => $village,
            'postal_code' => $request->postal_code
        ]);
        Session::flash('toast', 'Data berhasil diubah.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FamilyCard $familyCard): RedirectResponse {
        Gate::authorize('delete', $familyCard);
        $familyCard->delete();
        Session::flash('toast', 'Data berhasil dihapus.');
        return back();
    }
}
