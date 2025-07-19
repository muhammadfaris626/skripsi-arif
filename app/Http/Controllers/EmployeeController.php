<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EducationResource;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\PositionResource;
use App\Http\Resources\RankResource;
use App\Models\Education;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Rank;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class EmployeeController extends Controller {

    protected function applySearch($query, $search) {
        return $query->when($search, function($query, $search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        });
    }

    public function index(Request $request): Response {
        Gate::authorize('viewAny', Employee::class);
        $searchQuery = Employee::query();
        $this->applySearch($searchQuery, $request->search);
        $data = EmployeeResource::collection($searchQuery->orderBy('id', 'DESC')->paginate(12));
        return Inertia::render('Employees/IndexEmployee', [
            'fetchData' => $data,
            'search' => $request->search ?? '',
            'positions' => PositionResource::collection(Position::all()),
            'educations' => EducationResource::collection(Education::all()),
            'ranks' => RankResource::collection(Rank::all())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request): RedirectResponse {
        Gate::authorize('create', Employee::class);
        Employee::create([
            'employee_number' => $request->employee_number,
            'name' => $request->name,
            'gender' => $request->gender,
            'address' => $request->address,
            'phone' => $request->phone,
            'effective_date' => $request->effective_date,
            'position_id' => $request->position_id,
            'rank_id' => $request->rank_id,
            'employee_status' => $request->employee_status,
            'blood_group' => $request->blood_group,
            'education_id' => $request->education_id['id']
        ]);
        User::create([
            'name'     => $request->name,
            'username' => $request->employee_number,
            'email'    => $request->employee_number."@gmail.com",
            'password' => bcrypt($request->employee_number)
        ]);
        Session::flash('toast', 'Data berhasil ditambahkan.');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, $id): RedirectResponse {
        $data = Employee::find($id);
        Gate::authorize('update', $data);
        $data->update([
            'employee_number' => $request->employee_number,
            'name' => $request->name,
            'gender' => $request->gender,
            'address' => $request->address,
            'phone' => $request->phone,
            'effective_date' => $request->effective_date,
            'position_id' => $request->position_id,
            'rank_id' => $request->rank_id,
            'employee_status' => $request->employee_status,
            'blood_group' => $request->blood_group,
            'education_id' => $request->education_id['id']
        ]);
        $user = User::where('username', $data->employee_number)->first();
        $user->update([
            'name' => $request->name,
            'username' => $request->employee_number,
            'email' => $request->employee_number."@gmail.com",
            'password' => bcrypt($request->employee_number)
        ]);
        Session::flash('toast', 'Data berhasil diubah.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse {
        $data = Employee::find($id);
        Gate::authorize('delete', $data);
        User::where('username', $data->employee_number)->delete();
        $data->delete();
        Session::flash('toast', 'Data berhasil dihapus.');
        return back();
    }
}
