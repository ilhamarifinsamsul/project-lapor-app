<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResidentRequest;
use App\Interfaces\ResidentRepositoryInterface;
use RealRashid\SweetAlert\Facades\Alert as Swal;

class RegisteController extends Controller
{
    private ResidentRepositoryInterface $residentRepository;
    public function __construct(ResidentRepositoryInterface $residentRepository)
    {
        $this->residentRepository = $residentRepository;
    }
    // function index
    public function index()
    {
        return view('pages.auth.register');
    }

    // function store
    public function store(StoreResidentRequest $request){
        $data = $request->validated();
        $data['avatar'] = $request->file('avatar')->store('assets/avatars', 'public');
        $this->residentRepository->createResident($data);

        // Swal::toast('Resident created successfully', 'success')->timerProgressBar();

        return redirect()->route('login')->with('success', 'Pendaftaran Akun Berhasil, Silahkan Login');
    }
}
