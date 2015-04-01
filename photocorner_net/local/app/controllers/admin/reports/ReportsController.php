<?php

namespace Controllers\Admin\Reports;

use DB;
use Report;
use View;

class ReportsController extends \BaseController {

    public function getReports()
    {
        $reports = Report::with('user')->orderBy('created_at', 'desc')->get();

        return View::make('admin/reports/index')
            ->with('reports', $reports)
            ->with('title', 'Latest Reports');
    }

    public function getReadReport($id)
    {
        $report = Report::with('user')->find($id);
        $report->solved = '1';
        $report->save();

        return View::make('admin/reports/read')
            ->with('title', 'Full Report')
            ->with('report', $report);
    }
}