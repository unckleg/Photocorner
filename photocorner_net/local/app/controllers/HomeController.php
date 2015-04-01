<?php

class HomeController extends BaseController {


    /**
     * @return mixed
     */
    public function getIndex()
    {
        $title = siteSettings('siteName');

        return View::make('home/index', compact('title'));
    }

}