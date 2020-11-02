<?php
require './db_connect.php';


$db = db();
//  errors variable
$errors = "";

// insert a task if the submit button is clicked
if (isset($_POST['submit'])) {
    if (empty($_POST['task'])) {
        $errors = "Fill in your task";
    } else {
        $task = $_POST['task'];
        $dueDate = $_POST['dueDate'];
        $createdAt = date('Y-m-d H:i:s');
        $isCompleted = 0;
        $isDeleted = 0;

        $sql = "INSERT INTO tasks (task, isCompleted, dueDate, createdAt, isDeleted) VALUES ('$task', '$isCompleted', '$dueDate', '$createdAt', '$isDeleted')";
        mysqli_query($db, $sql);
        header('location: ./todo.php');
    }
}

if (isset($_GET['del_task'])) {
    $id = $_GET['del_task'];


    $query = "UPDATE tasks SET isDeleted = '1' WHERE id = '$id'";

    mysqli_query($db, $query);

    header('location: ./todo.php');
}
if (isset($_GET['mark_task'])) {
    $id = $_GET['mark_task'];

    $completedValue = '1';

    $query = "SELECT task, isCompleted FROM tasks WHERE id = '$id'";
    $result = mysqli_query($db, $query);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        if ($row) {

            $isCompleted = $row['isCompleted'];

            $completedValue =  $isCompleted == '1' ? '0' : '1';
        }
    }

    $updateQuery = "UPDATE tasks SET isCompleted = '$completedValue' WHERE id = '$id'";
    mysqli_query($db, $updateQuery);
    header('location:./todo.php');
}
