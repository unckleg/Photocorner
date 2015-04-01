<?php

/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
class ReportController extends BaseController {

    public function postReportUser($username)
    {
        $validate = Report::validate(Input::all());
        if ($validate->fails())
        {
            return Redirect::back()->withErrors($validate);
        }
        $report = new Report();
        $report->report = $username;
        $report->type = 'user';
        $report->user_id = Auth::user()->id;
        $report->description = Input::get('report');
        $report->save();

        return Redirect::route('gallery')->with('flashSuccess', 'Thanks, user is now reported we will take quick actions');
    }

    public function postReportImage($id)
    {
        $validate = Report::validate(Input::all());
        if ($validate->fails())
        {
            return Redirect::back()->withErrors($validate);
        }

        $report = new Report();
        $report->report = $id;
        $report->user_id = Auth::user()->id;
        $report->type = 'image';
        $report->description = Input::get('report');
        $report->save();

        return Redirect::route('gallery')->with('flashSuccess', 'Thanks, Image is now reported we will take quick actions');
    }

    public function getReport()
    {
        $title = t('Report');

        return View::make('report/index', compact('title'));
    }
}