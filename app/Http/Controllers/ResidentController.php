<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResidentRequest;
use App\Http\Resources\EducationResource;
use App\Http\Resources\FamilyCardResource;
use App\Http\Resources\ResidentResource;
use App\Http\Resources\WorkResource;
use App\Models\Education;
use App\Models\FamilyCard;
use App\Models\Resident;
use App\Models\User;
use App\Models\Work;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Str;

class ResidentController extends Controller {

    protected function applySearch($query, $search) {
        return $query->when($search, function($query, $search) {
            $query->whereHas('familyCard', function($query) use($search) {
                $query->where('family_number', 'LIKE', '%' . $search . '%');
            })
            ->orWhere('resident_name', 'LIKE', '%' . $search . '%')
            ->orWhere('resident_number', 'LIKE', '%' . $search . '%')
            ->orWhere('gender', 'LIKE', '%' . $search . '%')
            ->orWhere('place_of_birth', 'LIKE', '%' . $search . '%')
            ->orWhere('date_of_birth', 'LIKE', '%' . $search . '%')
            ->orWhere('religion', 'LIKE', '%' . $search . '%')
            ->orWhereHas('education', function($query) use($search) {
                $query->where('education_name', 'LIKE', '%' . $search . '%');
            })
            ->orWhereHas('work', function($query) use($search) {
                $query->where('work_name', 'LIKE', '%' . $search . '%');
            })
            ->orWhere('blood_group', 'LIKE', '%' . $search . '%')
            ->orWhere('marital_status', 'LIKE', '%' . $search . '%')
            ->orWhere('wedding_date', 'LIKE', '%' . $search . '%')
            ->orWhere('relationship_status', 'LIKE', '%' . $search . '%')
            ->orWhere('citizenship', 'LIKE', '%' . $search . '%')
            ->orWhere('paspor_number', 'LIKE', '%' . $search . '%')
            ->orWhere('kitap_number', 'LIKE', '%' . $search . '%')
            ->orWhere('father_name', 'LIKE', '%' . $search . '%')
            ->orWhere('mother_name', 'LIKE', '%' . $search . '%')
            ->orWhere('phone_number', 'LIKE', '%' . $search . '%');
        });
    }

    public function index(Request $request): Response {
        Gate::authorize('viewAny', Resident::class);
        $searchQuery = Resident::query();
        $this->applySearch($searchQuery, $request->search);
        $data = ResidentResource::collection($searchQuery->orderBy('id', 'DESC')->paginate(12));
        return Inertia::render('Data/Residents/IndexResident', [
            'fetchData' => $data,
            'search' => $request->search ?? '',
            'familyCards' => FamilyCardResource::collection(FamilyCard::all()),
            'works' => WorkResource::collection(Work::all()),
            'educations' => EducationResource::collection(Education::all())
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
    public function store(ResidentRequest $request): RedirectResponse {
        Gate::authorize('create', Resident::class);
        $create = Resident::create($request->validated());
        User::create([
            'name' => $create->resident_name,
            'username' => $create->resident_number,
            'email' => $create->resident_number.'@gmail.com',
            'password' => bcrypt($create->resident_number),
        ])->assignRole('user');

        Session::flash('toast', 'Data berhasil ditambahkan.');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Resident $resident)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resident $resident)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ResidentRequest $request, Resident $resident): RedirectResponse {
        Gate::authorize('update', $resident);
        $education = isset($request->education_id[0]['id']) ? $request->education_id[0]['id'] : $request->education_id['id'];
        $work = isset($request->work_id[0]['id']) ? $request->work_id[0]['id'] : $request->work_id['id'];
        $checkUser = User::where('username', $resident->resident_number)->first();
        $resident->update([
            'resident_number' => $request->resident_number,
            'resident_name' => $request->resident_name,
            'gender' => $request->gender,
            'place_of_birth' => $request->place_of_birth,
            'date_of_birth' => $request->date_of_birth,
            'religion' => $request->religion,
            'phone_number' => $request->phone_number,
            'education_id' => $education,
            'work_id' => $work,
            'marital_status' => $request->marital_status,
            'relationship_status' => $request->relationship_status,
            'citizenship' => $request->citizenship,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'passport_number' => $request->passport_number,
            'description' => $request->description
        ]);

        $checkUser->update([
            'name' => $resident->resident_name,
            'username' => $resident->resident_number,
            'email' => $resident->resident_number.'@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt($resident->resident_number),
            'remember_token' => Str::random(10),
        ]);
        Session::flash('toast', 'Data berhasil diubah.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resident $resident): RedirectResponse {
        Gate::authorize('delete', $resident);
        $user = User::where('username', $resident->resident_number)->delete();
        $resident->delete();
        Session::flash('toast', 'Data berhasil dihapus.');
        return back();
    }
}
