<?php

namespace App\Repositories;
use App\Interfaces\ReportCategoryInterface;
use App\Models\ReportCategory;

class ReportCategoryRepository implements ReportCategoryInterface
{
    public function getAllReportCategories()
    {
        return ReportCategory::all();
    }

    public function getReportCategoryById(int $id)
    {
        return ReportCategory::where('id', $id)->first();
    }

    public function createReportCategory(array $data)
    {
        return ReportCategory::create($data);
    }

    public function updateReportCategory(int $id, array $data)
    {
        $reportCategory = $this->getReportCategoryById($id);
        return $reportCategory->update($data);
    }

    public function deleteReportCategory(int $id)
    {
        $reportCategory = $this->getReportCategoryById($id);
        return $reportCategory->delete();
    }
}