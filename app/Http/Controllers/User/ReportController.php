<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Interfaces\ReportCategoryInterface;
use App\Interfaces\ReportRepositoryInterface;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // menampilkan data report
    private ReportRepositoryInterface $reportRepository;
    // category
    private ReportCategoryInterface $reportCategoryRepository;

    public function __construct(ReportRepositoryInterface $reportRepository, ReportCategoryInterface $reportCategoryRepository)
    {
        
        $this->reportRepository = $reportRepository;
        $this->reportCategoryRepository = $reportCategoryRepository;
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

    // function take laporan menggunakan kamera
    public function take(){
        return view('pages.app.report.take');
    }
    // function untuk priview laporan
    public function priview()
    {
        return view('pages.app.report.priview');
    }
    // function create laporan
    public function create()
    {
        $categories = $this->reportCategoryRepository->getAllReportCategories();
        return view('pages.app.report.create', compact('categories'));
    }
}
