<?php

namespace App\Repositories;

use App\Interfaces\ReportRepositoryInterface;
use App\Models\Report;
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

    public function getReportById(int $id)
    {
        return Report::where('id', $id)->first();
    }

    public function createReport(array $data)
    {
        return Report::create($data);
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
