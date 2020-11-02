<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Update TodoL</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="stylesheet" href="styles.css">

</head>

<body class="container">
    <div>
        <h1 class="heading my-2">Edit Todo</h1>
    </div>

    <?php
    require_once './db_connect.php';

    $db = db();
    $task = "";

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $query = "SELECT task FROM tasks WHERE id = '$id'";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result);
            if ($row) {
                $task = $row['task'];

                echo "
                <form action='updatetodo.php?id=$id' method='post'>
            <div class='form-group'>
                <label for='task'>Task</label>
                <input type='text' class='form-control' value='$task' name='task' id='task'
                    aria-describedby='whats your task?'>
                 </div>
                 <div class='form-group'>
                 <label for='dueDate'>Add Date</label>
                 <input type='datetime-local' name='dueDate' class='form-control' id='dueDate'>
             </div>
            <button type='submit' name='submit' id='submit' class='btn btn-secondary btn-block'>Edit Task</button>
        </form> ";
            }
        } else {
            echo "no todo";
        }
    }

    if (isset($_POST['submit'])) {
        $task = $_POST['task'];

        if (empty($task)) {
            $errors = "Tasks cannot be empty";
        } else {

            $query = "UPDATE tasks SET task = '$task', dueDate = '$dueDate' WHERE id = '$id'";
            $insertEdited = mysqli_query($db, $query);
            if ($insertEdited) {
                echo "successfully updated";
                header('location: ./todo.php');
            } else {
                echo mysqli_error($db);
            }
        }
    }
    ?>
</body>

</html>