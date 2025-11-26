<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Interfaces\ReportCategoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Menampilkan data category pada halaman home
    private ReportCategoryInterface $reportCategoryRepository;

    public function __construct(ReportCategoryInterface $reportCategoryRepository)
    {
        $this->reportCategoryRepository = $reportCategoryRepository;
    }
    public function index()
    {
        $categories = $this->reportCategoryRepository->getAllReportCategories();
        return view('pages.app.home', compact('categories'));
    }
}
