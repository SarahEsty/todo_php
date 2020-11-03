<?php
require_once './db_connect.php';


function getAllTask($dropdownValue)
{
    $db = db();
    $tasks = mysqli_query($db, "SELECT * FROM tasks WHERE isDeleted = 0");
    $taskList = [];
    while ($row = mysqli_fetch_array($tasks)) {
        $taskList[] = $row;
    }

    return switchArrayByDropdownValue($dropdownValue, $taskList);
}


// select all tasks if page is visited or refreshed

function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function switchArrayByDropdownValue($dropdownValue, $list)
{

    switch ($dropdownValue) {

        case 'createdAt_asc':
            usort($list, function ($a, $b) {
                $a = $a['createdAt'];
                $b = $b['createdAt'];
                return ($a == $b) ? 0 : (($a < $b) ? -1 : 1);
            });
            break;
        case 'dueDate_desc':
            usort($list, function ($a, $b) {
                $a = $a['dueDate'];
                $b = $b['dueDate'];
                return ($a == $b) ? 0 : (($a < $b) ? -1 : 1);
            });
            break;
        case 'dueDate_asc':
            usort($list, function ($a, $b) {
                $a = $a['dueDate'];
                $b = $b['dueDate'];
                return ($a == $b) ? 0 : (($a > $b) ? -1 : 1);
            });
            break;
        case 'taskName':
            usort($list, function ($a, $b) {
                $a = $a['task'];
                $b = $b['task'];
                return ($a == $b) ? 0 : (($a < $b) ? -1 : 1);
            });
            break;

        default:
            usort($list, function ($a, $b) {
                $a = $a['createdAt'];
                $b = $b['createdAt'];
                return ($a == $b) ? 0 : (($a > $b) ? -1 : 1);
            });
            break;
    }
    return $list;
}