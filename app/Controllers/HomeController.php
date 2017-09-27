<?php

namespace App\Controllers;

use \Itravel\Http\Controller as BaseController;
use \Itravel\View\View as View;

class HomeController extends BaseController
{

    /**
     * render index template
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderTwig('Home/index.html');
    }

}