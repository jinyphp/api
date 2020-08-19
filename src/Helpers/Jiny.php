<?php

namespace jiny;

function isAPI()
{
    $type = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : null;
    // echo $_SERVER['CONTENT_TYPE'];
    // exit;
    if ($type == 'application/json') {
        return true;
    }
    return false;
}