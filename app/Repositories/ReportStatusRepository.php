<?php
namespace App\Repositories;

use App\Interfaces\ReportStatusRepositoryInterface;
use App\Models\ReportStatus;


class ReportStatusRepository implements ReportStatusRepositoryInterface
{
    public function getAllReportStatuses()
    {
        return ReportStatus::all();
    }

    public function getReportStatusById(int $id)
    {
        return ReportStatus::find($id);
    }

    public function createReportStatus(array $data)
    {
        return ReportStatus::create($data);
    }

    public function updateReportStatus(int $id, array $data)
    {
        $reportStatus = ReportStatus::find($id);
        $reportStatus->update($data);
        return $reportStatus;
    }

    public function deleteReportStatus(int $id)
    {
        $reportStatus = ReportStatus::find($id);
        $reportStatus->delete();
        return $reportStatus;
    }
}
