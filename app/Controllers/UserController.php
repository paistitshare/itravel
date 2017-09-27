<?php

namespace App\Controllers;

use \Itravel\Http\Controller as BaseController;

class UserController extends BaseController
{

    /**
     * render index template
     *
     * @return void
     */
    public function createAction()
    {
        $data = ['username' => 'Vitaly Matsuk', 'id' => 1];

        header('Content-type: application/json');

        echo json_encode($data);
    }

}