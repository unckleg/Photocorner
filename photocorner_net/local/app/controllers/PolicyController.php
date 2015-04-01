<?php

/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
class PolicyController extends BaseController {

    /**
     * Terms and services
     *
     * @return mixed
     */
    public function getTos()
    {
        $title = t('Terms of Services');

        return View::make('policy/tos', compact('title'));
    }

    /**
     * Privacy Policies
     *
     * @return mixed
     */
    public function getPrivacy()
    {
        $title = t('Privacy Policy');

        return View::make('policy/privacy', compact('title'));
    }

    /**
     * Faq of the site
     *
     * @return mixed
     */
    public function getFaq()
    {
        $title = t('FAQ');

        return View::make('policy/faq', compact('title'));
    }

    /**
     * About us
     *
     * @return mixed
     */
    public function getAbout()
    {
        $title = t('About Us');

        return View::make('policy/about', compact('title'));
    }
}