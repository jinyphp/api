<?php
/*
 * This file is part of the jinyPHP package.
 *
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jiny;

function version()
{
    return "0.1";
}

class TimeLog
{
    private static $start;
    private static $times = [];

    public static function init()
    {
        self::$start = self::get_time();
        // self::$times []= self::$start;
    }

    public static function check($msg)
    {
        // 시간측정
        $time = self::get_time() - self::$start;
        self::$times []= [$msg, $time];
    }

    public static function output()
    {
        return var_dump(self::$times);
    }

    public static function get_time() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }
}