<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Interfaces\ReportCategoryInterface;
use App\Interfaces\ReportRepositoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Menampilkan data category pada halaman home
    private ReportCategoryInterface $reportCategoryRepository;
    // menampilkan data report
    private ReportRepositoryInterface $reportRepository;

    public function __construct(ReportCategoryInterface $reportCategoryRepository, ReportRepositoryInterface $reportRepository)
    {
        $this->reportCategoryRepository = $reportCategoryRepository;
        $this->reportRepository = $reportRepository;
    }
    public function index()
    {
        $categories = $this->reportCategoryRepository->getAllReportCategories();
        $reports = $this->reportRepository->getLatestReports();
        return view('pages.app.home', compact('categories', 'reports'));
    }
}
