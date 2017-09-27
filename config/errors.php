<?php

error_reporting(E_ALL);

set_error_handler('Itravel\Exception\HandleExceptions::handleError');

set_exception_handler('Itravel\Exception\HandleExceptions::handleException');