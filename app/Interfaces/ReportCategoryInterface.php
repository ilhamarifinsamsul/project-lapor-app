<?php
namespace App\Interfaces;

interface ReportCategoryInterface {
    public function getAllReportCategories();
    public function getReportCategoryById(int $id);
    public function createReportCategory(array $data);
    public function updateReportCategory(int $id, array $data);
    public function deleteReportCategory(int $id);
}
