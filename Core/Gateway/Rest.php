<?php
/**
 * REST 처리 동작 구분
 */

interface Rest
{
    public function get();
    public function post();
    public function put();
    public function delete();
}