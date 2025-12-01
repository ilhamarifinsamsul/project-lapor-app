<?php

namespace App\Repositories;

use App\Interfaces\ReportRepositoryInterface;
use App\Models\Report;
use App\Models\ReportCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

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

    public function getReportsByResidentId(string $status)
    {
        return Report::where('resident_id', Auth::user()->resident->id)
            ->where(function ($query) use ($status) {
                // Jika status pending, tampilkan juga laporan tanpa status
                if ($status === 'pending') {
                    $query->whereDoesntHave('reportStatuses')
                        ->orWhereHas('reportStatuses', function ($sub) {
                            $sub->whereIn('id', function ($sq) {
                                $sq->selectRaw('MAX(id)')
                                    ->from('report_statuses')
                                    ->groupBy('report_id');
                            })->where('status', 'pending');
                        });
                } else {
                    // Status lain harus berdasarkan status terakhir
                    $query->whereHas('reportStatuses', function ($sub) use ($status) {
                        $sub->whereIn('id', function ($sq) {
                            $sq->selectRaw('MAX(id)')
                                ->from('report_statuses')
                                ->groupBy('report_id');
                        })->where('status', $status);
                    });
                }
            })
            ->get();
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
