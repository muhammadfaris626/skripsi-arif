<?php

namespace App\Http\Controllers;

use App\Http\Requests\RankRequest;
use App\Http\Resources\RankResource;
use App\Models\Rank;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class RankController extends Controller {

    protected function applySearch($query, $search) {
        return $query->when($search, function($query, $search) {
            $query->where('rank_name', 'LIKE', '%' . $search . '%');
        });
    }

    public function index(Request $request): Response {
        Gate::authorize('viewAny', Rank::class);
        $searchQuery = Rank::query();
        $this->applySearch($searchQuery, $request->search);
        $data = RankResource::collection($searchQuery->paginate(12));
        return Inertia::render('Settings/Ranks/IndexRank', [
            'fetchData' => $data,
            'search' => $request->search ?? ''
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
    public function store(RankRequest $request): RedirectResponse {
        Gate::authorize('create', Rank::class);
        $create = Rank::create(['rank_name' => $request->rank_name]);
        Session::flash('toast', 'Data berhasil ditambahkan.');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Rank $rank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rank $rank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RankRequest $request, Rank $rank): RedirectResponse {
        Gate::authorize('update', $rank);
        $rank->update([
            'rank_name' => $request->rank_name
        ]);
        Session::flash('toast', 'Data berhasil diubah.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rank $rank): RedirectResponse {
        Gate::authorize('delete', $rank);
        $rank->delete();
        Session::flash('toast', 'Data berhasil dihapus.');
        return back();
    }
}
