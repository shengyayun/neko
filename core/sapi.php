<?php
if($item = json_decode(file_get_contents('php://input'), true))
{
    require "neko.php";
    $neko = new Neko();
    $neko->cache->push($item);
}