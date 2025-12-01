<?php

namespace App\Repositories;

use App\Interfaces\ReportRepositoryInterface;
use App\Models\Report;
use App\Models\ReportCategory;
use Illuminate\Support\Facades\Storage;

class ReportRepository implements ReportRepositoryInterface
{
    public function getAllReports()
    {
        return Report::all();
    }

    public function getLatestReports()
    {
        return Report::latest()->get()->take(5);
    }

    public function getReportByCode($code)
    {
        return Report::where('code', $code)->first();
    }

    public function getReportsByCategory(string $category)
    {
        $category = ReportCategory::where('name', $category)->first();
        return Report::where('report_category_id', $category->id)->get();
    }

    public function getReportById(int $id)
    {
        return Report::where('id', $id)->first();
    }

    public function createReport(array $data)
    {
        $report = Report::create($data);
        
    }

    public function updateReport(int $id, array $data)
    {
        $report = $this->getReportById($id);
        return $report->update($data);
    }

    public function deleteReport(int $id)
    {
        $report = $this->getReportById($id);

        // Hapus file gambar dari storage jika ada
        if ($report->image) {
            $imagePath = 'public/' . $report->image;
            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
                Storage::delete($imagePath);
            }
        }

        return $report->delete();
    }
}
