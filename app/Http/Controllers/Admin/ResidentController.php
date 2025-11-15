<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResidentRequest;
use App\Http\Requests\UpdateResidentRequest;
use App\Interfaces\ResidentRepositoryInterface;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    private ResidentRepositoryInterface $residentRepository;
    public function __construct(ResidentRepositoryInterface $residentRepository)
    {
        $this->residentRepository = $residentRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get all residents
        $residents = $this->residentRepository->getAllResidents();
        return view('pages.admin.resident.index', compact('residents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.resident.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResidentRequest $request)
    {
        $data = $request->validated();
        // avatar upload
        $data['avatar'] = $request->file('avatar')->store('assets/avatars', 'public');
        $this->residentRepository->createResident($data);

        return redirect()->route('admin.resident.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // show detail of resident
        $resident = $this->residentRepository->getResidentById($id);
        return view('pages.admin.resident.show', compact('resident'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $resident = $this->residentRepository->getResidentById($id);

        return view('pages.admin.resident.edit', compact('resident'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResidentRequest $request, string $id)
    {
        // update resident
        $data = $request->validated();
        // jika avatar di update
        if ($request->avatar) {
            $data['avatar'] = $request->file('avatar')->store('assets/avatars', 'public');
        }
        $this->residentRepository->updateResident((int)$id, $data);

        return redirect()->route('admin.resident.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
