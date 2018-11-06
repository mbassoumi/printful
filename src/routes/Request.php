<?php
/**
 * Created by PhpStorm.
 * User: mbbas
 * Date: 11/6/2018
 * Time: 6:28 PM
 */

include_once 'RequestInterface.php';

class Request implements RequestInterface
{

    public function __construct()
    {
        $this->initRoute();
    }

    private function initRoute()
    {
        foreach ($_SERVER as $key => $value) {
            $this->{$this->toCamelCase($key)} = $value;
        }
    }

    private function toCamelCase($string)
    {
        $result = strtolower($string);

        preg_match_all('/_[a-z]/', $result, $matches);
        foreach ($matches[0] as $match) {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }
        return $result;
    }

    public function getBody()
    {
        if ($this->requestMethod === "GET") {
            return;
        }
        if ($this->requestMethod == "POST") {
            $result = array();
            foreach ($_POST as $key => $value) {
                $result[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
            return $result;
        }

        return [];
    }


}