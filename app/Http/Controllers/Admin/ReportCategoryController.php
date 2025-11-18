<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportCategoryRequest;
use App\Http\Requests\UpdateReportCategoryRequest;
use App\Interfaces\ReportCategoryInterface;
use RealRashid\SweetAlert\Facades\Alert as Swal;

class ReportCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // call interface
    private ReportCategoryInterface $reportCategoryInterface;
    public function __construct(ReportCategoryInterface $reportCategoryInterface)
    {
        $this->reportCategoryInterface = $reportCategoryInterface;
    }

    public function index()
    {
        $categories = $this->reportCategoryInterface->getAllReportCategories();
        return view('pages.admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportCategoryRequest $request)
    {
        $data = $request->validated();
        // Icon di upload
        $data['image'] = $request->file('image')->store('assets/images', 'public');
        $this->reportCategoryInterface->createReportCategory($data);
        
        Swal::toast('Category created successfully', 'success')->timerProgressBar();

        return redirect()->route('admin.report-category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = $this->reportCategoryInterface->getReportCategoryById($id);
        return view('pages.admin.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = $this->reportCategoryInterface->getReportCategoryById($id);
        return view('pages.admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportCategoryRequest $request, string $id)
    {
        $data = $request->validated();
        // Icon di upload
        if ($request->image) {
            $data['image'] = $request->file('image')->store('assets/images', 'public');
        }
        $this->reportCategoryInterface->updateReportCategory((int)$id, $data);

        Swal::toast('Category updated successfully', 'success')->timerProgressBar();

        return redirect()->route('admin.report-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->reportCategoryInterface->deleteReportCategory($id);
        Swal::toast('Category deleted successfully', 'success')->timerProgressBar();
        return redirect()->route('admin.report-category.index');
    }
}
