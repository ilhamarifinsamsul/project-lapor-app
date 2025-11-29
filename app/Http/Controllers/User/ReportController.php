<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Interfaces\ReportRepositoryInterface;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // menampilkan data report
    private ReportRepositoryInterface $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        
        $this->reportRepository = $reportRepository;
    }
    // function untuk menampilkan data report
    public function index(Request $request){
        if ($request->has('category')) {
            $reports = $this->reportRepository->getReportsByCategory($request->category);
        }else{
            $reports = $this->reportRepository->getAllReports();
        }
        return view('pages.app.report.index', compact('reports'));
    }

    public function show($code){
        $report = $this->reportRepository->getReportByCode($code);

        return view('pages.app.report.show', compact('report'));
    }
}
