<?php
error_reporting(E_ALL);

//You can also report all errors by using -1
error_reporting(-1);

//If you are feeling old school
ini_set('error_reporting', E_ALL);
session_start();

function base_url($uri = '')
{
    return 'http://' . $_SERVER["HTTP_HOST"] . ($_SERVER["HTTP_HOST"] == "/school") . '/' . ($uri ? $uri : '');
}

function dnp($data)
{
    echo '<pre style="border: 1px solid green;">';
    print_r($data);
    echo '</pre>';
}

function dnd($data)
{
    echo '<pre style="border: 1px solid green;">';
    var_dump($data);
    echo '</pre>';
}

function setMessage($message, $type = 'info')
{
    $_SESSION['message'] = (object)['text' => $message, 'type' => $type];
}

$link = new mysqli('localhost', 'root', '', 'school');


function random_color_part()
{
    return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
}

function random_color()
{
    return random_color_part() . random_color_part() . random_color_part();
}

function changeDateFormat($date, $format = "Y-m-d") {
    return date($format, strtotime(str_replace(",", " ", $date)));
}

function changeDateFormatToLong($date, $format = "d M, Y") {
    return date($format, strtotime(str_replace(",", " ", $date)));
}

function generateRandomString($length = 16) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
