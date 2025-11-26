<?php
namespace App\Interfaces;

interface ReportRepositoryInterface {
    public function getAllReports();
    // function untuk melihat laporan terakhir di halaman user
    public function getLatestReports();
    public function getReportById(int $id);
    public function createReport(array $data);
    public function updateReport(int $id, array $data);
    public function deleteReport(int $id);
}
