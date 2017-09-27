<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$params = require '../config/params.php';
Itravel\Helper\Params::loadParams($params);

require_once '../bootstrap/app.php';

