<?php

namespace Itravel\Database;

abstract class Model
{

    protected $dbo;

    function __construct($db){
        try{
            $this->dbo = $db;
        } catch (\Exception $ex) {
            exit("Database connection could not be established");
        }
    }

}
