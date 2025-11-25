<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportStatusRequest;
use App\Interfaces\ReportRepositoryInterface;
use App\Interfaces\ReportStatusRepositoryInterface;
use RealRashid\SweetAlert\Facades\Alert as Swal;

use Illuminate\Http\Request;

class ReportStatusController extends Controller
{

    // memanggil repository reportStatus
    private ReportStatusRepositoryInterface $reportStatusRepository;
    // memanggil repository report
    private ReportRepositoryInterface $reportRepository;


    public function __construct(ReportStatusRepositoryInterface $reportStatusRepository, ReportRepositoryInterface $reportRepository)
    {
        $this->reportStatusRepository = $reportStatusRepository;
        $this->reportRepository = $reportRepository;

    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($reportId)
    {
        $report = $this->reportRepository->getReportById($reportId);
        return view('pages.admin.report-status.create', compact('report'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportStatusRequest $request)
    {
        $data = $request->validated();
       
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('assets/report-status/image', 'public');
        }
        $this->reportStatusRepository->createReportStatus($data);
        Swal::toast('Report Status created successfully', 'success');
        return redirect()->route('admin.report.show', $request->report_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
