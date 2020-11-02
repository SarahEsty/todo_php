<?php


// connect to database
function db()
{
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $db = mysqli_connect("localhost:3306", "root", "", "todo") or die("couldn't connect to database");
    return $db;
}