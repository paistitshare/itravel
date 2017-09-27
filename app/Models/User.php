<?php

namespace App;

use \Itravel\Database\Database;
use \Itravel\Database\Model as BaseModel;

class User extends BaseModel
{

    protected $dbo;

    public function __construct(){
        $this->dbo = Database::getInstance();
    }

}
