<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Interfaces\ReportCategoryInterface;
use App\Interfaces\ReportRepositoryInterface;
use App\Interfaces\ResidentRepositoryInterface;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert as Swal;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    // memanggil repository report
    private ReportRepositoryInterface $reportRepository;
    // memanggil repository category
    private ReportCategoryInterface $reportCategoryRepository;
    // memanggil repository resident
    private ResidentRepositoryInterface $residentRepository;

    public function __construct(ReportRepositoryInterface $reportRepository, ReportCategoryInterface $reportCategoryRepository, ResidentRepositoryInterface $residentRepository)
    {
        $this->reportRepository = $reportRepository;
        $this->reportCategoryRepository = $reportCategoryRepository;
        $this->residentRepository = $residentRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ambil semua data report beserta resident dan category
        $reports = $this->reportRepository->getAllReports();
        return view('pages.admin.report.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $residents = $this->residentRepository->getAllResidents();
        $categories = $this->reportCategoryRepository->getAllReportCategories();
        
        return view('pages.admin.report.create', compact('residents', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportRequest $request)
    {
        $data = $request->validated();
        // generate code
        $data['code'] = 'TGN-' . mt_rand(100000, 999999);
        // simpan image
        $data['image'] = $request->file('image')->store('assets/report/image', 'public');

        // TODO: implement store logic
        $this->reportRepository->createReport($data);
        Swal::success('Berhasil', 'Laporan berhasil ditambahkan');
        return redirect()->route('admin.report.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // ambil data report beserta report
        $report = $this->reportRepository->getReportById($id);
        return view('pages.admin.report.show', compact('report'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // ambil data report beserta resident, category dan report category
        $report = $this->reportRepository->getReportById($id);
        $residents = $this->residentRepository->getAllResidents();
        $categories = $this->reportCategoryRepository->getAllReportCategories();
        
        return view('pages.admin.report.edit', compact('report', 'residents', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportRequest $request, string $id)
    {
        $data = $request->validated();
        // update image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('assets/report/image', 'public');
        }
        $this->reportRepository->updateReport($id, $data);
        Swal::success('Berhasil', 'Laporan berhasil diupdate');
        return redirect()->route('admin.report.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // delete image
        $report = $this->reportRepository->getReportById($id);
        if ($report->image) {
            Storage::delete($report->image);
        }
        $this->reportRepository->deleteReport($id);
        Swal::success('Berhasil', 'Laporan berhasil dihapus');
        return redirect()->route('admin.report.index');
    }
}
