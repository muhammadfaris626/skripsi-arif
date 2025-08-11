<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\EducationResource;
use App\Http\Resources\WorkResource;
use App\Models\Education;
use App\Models\FamilyCard;
use App\Models\Resident;
use App\Models\User;
use App\Models\Work;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register', [
            'works' => WorkResource::collection(Work::all()),
            'educations' => EducationResource::collection(Education::all())
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'no_kk' => 'required',
            'nama_lengkap' => 'required',
            'nik' => 'required',
            'gender' => 'required',
            'education_id' => 'required',
            'work_id' => 'required',
            'place_of_birth' => 'required',
            'date_of_birth' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'phone_number' => 'required',
            'religion' => 'required',
            'blood_group' => 'required',
            'marital_status' => 'required',
            'relationship_status' => 'required',
            'citizenship' => 'required',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required'],
        ], [
            'no_kk.required' => 'Kolom nomor kartu keluarga wajib diisi.',
            'nama_lengkap.required' => 'Kolom nama lengkap wajib diisi.',
            'nik.required' => 'Kolom nomor induk kependudukan wajib diisi.',
            'gender.required' => 'Kolom jenis kelamin wajib diisi.',
            'education_id.required' => 'Kolom pendidikan wajib diisi.',
            'work_id.required' => 'Kolom pekerjaan wajib diisi.',
            'place_of_birth.required' => 'Kolom tempat lahir wajib diisi.',
            'date_of_birth.required' => 'Kolom tanggal lahir wajib diisi.',
            'father_name.required' => 'Kolom nama ayah wajib diisi.',
            'mother_name.required' => 'Kolom nama ibu wajib diisi.',
            'phone_number.required' => 'Kolom nomor telepon wajib diisi.',
            'religion.required' => 'Kolom agama wajib diisi.',
            'blood_group.required' => 'Kolom golongan darah wajib diisi.',
            'marital_status.required' => 'Kolom status perkawinan wajib diisi.',
            'relationship_status.required' => 'Kolom status dalam keluarga wajib diisi.',
            'citizenship.required' => 'Kolom kewarganegaraan wajib diisi.',
            'email.required' => 'Kolom email wajib diisi.',
            'email.unique' => 'Email telah terdaftar.',
            'password.required' => 'Kolom password wajib diisi.'
        ]);



        $create = Resident::create([
            'family_card_id' => FamilyCard::where('family_number', $request->no_kk)->first()->id,
            'resident_name' => $request->nama_lengkap,
            'resident_number' => $request->nik,
            'gender' => $request->gender,
            'place_of_birth' => $request->place_of_birth,
            'date_of_birth' => $request->date_of_birth,
            'religion' => $request->religion,
            'education_id' => $request->education_id,
            'work_id' => $request->work_id,
            'blood_group' => $request->blood_group,
            'marital_status' => $request->marital_status,
            'wedding_date' => $request->wedding_date,
            'relationship_status' => $request->relationship_status,
            'citizenship' => $request->citizenship,
            'paspor_number' => $request->paspor_number,
            'kitap_number' => $request->kitap_number,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'phone_number' => $request->phone_number
        ]);
        $user = User::create([
            'name' => $create->resident_name,
            'username' => $create->resident_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ])->assignRole('user');

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
