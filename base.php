<?php
require_once './db_connect.php';


function getAllTask()
{
    $db = db();
    $tasks = mysqli_query($db, "SELECT * FROM tasks WHERE isDeleted = 0");
    $taskList = [];
    while ($row = mysqli_fetch_array($tasks)) {
        $taskList[] = $row;
    }

    return array_reverse($taskList);
}


// select all tasks if page is visited or refreshed

function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}