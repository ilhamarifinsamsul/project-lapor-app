<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Resident;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // count by status report
    public function countByStatus(string $status)
    {
        if ($status === 'pending') {
            // laporan tanpa status atau status terakhir pending
            return Report::where(function ($query) {
                $query->whereDoesntHave('reportStatuses')
                    ->orWhereHas('reportStatuses', function ($sub) {
                        $sub->whereIn('id', function ($sq) {
                            $sq->selectRaw('MAX(id)')
                                ->from('report_statuses')
                                ->groupBy('report_id');
                        })->where('status', 'pending');
                    });
            })->count();
        }

        return Report::whereHas('reportStatuses', function ($query) use ($status) {
            $query->whereIn('id', function ($subquery) {
                $subquery->selectRaw('MAX(id)')
                    ->from('report_statuses')
                    ->groupBy('report_id');
            })->where('status', $status);
        })->count();
    }

    public function index()
    {
        // total residents
        $totalResidents = Resident::count();
        // total Laporan
        $totalReports = Report::count();
        // total Laporan selesai
        $totalCompletedReports = $this->countByStatus('completed');
        // total Laporan pending
        $totalPendingReports = $this->countByStatus('pending');
        // total Laporan in progress
        $totalInProgressReports = $this->countByStatus('in_progress');
        return view('pages.admin.dashboard', compact('totalResidents', 'totalReports', 'totalCompletedReports', 'totalPendingReports', 'totalInProgressReports'));
    }
}
