<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportRequest;
use App\Interfaces\ReportCategoryInterface;
use App\Interfaces\ReportRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    // function myReport
    public function myReport(Request $request){
        // $status = $request->status ?? 'pending';
        $reports = $this->reportRepository->getReportsByResidentId($request->status);
        return view('pages.app.report.my-report', compact('reports'));
        
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
    // function store laporan
    public function store(StoreReportRequest $request)
    {
        // TODO: Implement store logic
        $data = $request->validated();
        // code
        $data['code'] = 'TGN-' . mt_rand(100000, 999999);
        // resident_id
        $data['resident_id'] = Auth::user()->resident->id;
        
        // // latitude and longitude
        // $data['latitude'] = $request->input('lat');
        // $data['longitude'] = $request->input('lng');
        
        // image
        $data['image'] = $request->file('image')->store('assets/report/image', 'public');

        // TODO: implement store logic
        $this->reportRepository->createReport($data);
        return redirect()->route('report.success');
    }

    public function success()
    {
        return view('pages.app.report.success');
    }
}
