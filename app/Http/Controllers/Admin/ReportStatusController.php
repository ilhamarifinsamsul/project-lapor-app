<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportStatusRequest;
use App\Http\Requests\UpdateStatusReportRequest;
use App\Interfaces\ReportRepositoryInterface;
use App\Interfaces\ReportStatusRepositoryInterface;
use RealRashid\SweetAlert\Facades\Alert as Swal;
use Illuminate\Support\Facades\Storage;

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
        $status = $this->reportStatusRepository->getReportStatusById($id);
        return view('pages.admin.report-status.show', compact('status'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $status = $this->reportStatusRepository->getReportStatusById($id);
        return view('pages.admin.report-status.edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatusReportRequest $request, string $id)
    {
        // update image
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('assets/report-status/image', 'public');
        }
        $this->reportStatusRepository->updateReportStatus($id, $data);
        Swal::toast('Report Status updated successfully', 'success');
        return redirect()->route('admin.report.show', $request->report_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $status = $this->reportStatusRepository->getReportStatusById($id);
        if ($status->image) {
            Storage::delete($status->image);
        }
        $this->reportStatusRepository->deleteReportStatus($id);
        Swal::toast('Report Status deleted successfully', 'success');
        return redirect()->route('admin.report.show', $status->report_id);
    }
}
