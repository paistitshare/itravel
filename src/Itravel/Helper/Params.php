<?php


namespace Itravel\Helper;

class Params
{

    private static $params = [];

    public static function loadParams($params)
    {
        self::$params = array_merge(self::$params, $params);
    }

    public static function getParam($key) {
        return self::$params[$key];
    }
}