<?php
require_once "./db_connect.php";
require_once "./base.php";
?>

<?php
if (!empty($_POST['deleteMultiple'])) {
    $db = db();
    $ids = $_POST['deleteMultiple'];

    $query = "UPDATE tasks SET isDeleted = '1' WHERE id IN ($ids)";

    foreach ($_POST['deleteMultiple'] as $check) {
        echo "value = $check";
        $query = "UPDATE tasks SET isDeleted = '1' WHERE id = '$check'";

        mysqli_query($db, $query);
    }
    header('location: ./todo.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Todo List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">


    <link rel="stylesheet" href="./styles.css">

</head>

<body class="container">
    <div>
        <h1 class="heading my-2">Sarah's Todo List</h1>
    </div>

    <!-- inputs -->
    <div class="row">
        <div class="col-md-6 mx-auto ">
            <div class="card card-body my-4 shadow-sm">
                <form action="businesslogic.php" method="post" value="$title">
                    <div class="form-group">
                        <label for="task">Task</label>
                        <input type="text" class="form-control" name="task" id="task"
                            aria-describedby="whats your task?" placeholder="Add a task ...">
                    </div>

                    <div class="form-group">
                        <label for="dueDate">Add Date</label>
                        <input type="datetime-local" name="dueDate" class="form-control" id="dueDate">
                    </div>


                    <button type="submit" name="submit" id="submit" class="btn btn-primary btn-block">Add
                        Task</button>
                </form>
            </div>
        </div>
    </div>


    <form action="todo.php" method="post">
        <!-- top action buttons -->
        <div class="d-flex justify-content-end mb-2">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Sort by
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" value='taskName'>Alphabetically</a>
                    <a class="dropdown-item" value='dueDate_asc'>Due Date - Asc</a>
                    <a class="dropdown-item" value='dueDate_desc'>Due Date - Desc</a>
                    <a class="dropdown-item" value='createdDate_asc'>Created Date - Asc</a>
                    <a class="dropdown-item" value='createdDate_desc'>Created Date - Desc</a>
                </div>
            </div>

            <input type="submit" class="btn btn-danger ml-2" value="Delete Selected" />


            <!-- <button class="btn btn-danger ml-2" id="deleteAll" data-toggle="modal" data-target="#deleteAllModal">
            Delete Selected
        </button> -->

        </div>
        <table class="table table-borderless" id="myTable">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Tasks</th>
                    <th>Created Date</th>
                    <th>Due Date</th>
                    <th> <input type="checkbox" name="chk_all" class="chk_all">
                    </th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>


                <?php

                //how to acccess the value of the dropdown in php to dynamically change the values;
                $sortBy = 'createdDate_desc';

                if (isset($_GET['sortBy'])) {
                    $sortBy = $_GET['sortBy'];
                }

                $task = getAllTask($sortBy);

                ?>
                <?php
                foreach ($task as $i => $row) {
                    $i++;
                ?>
                <tr id="task">

                    <td> <?php echo $i; ?> </td>
                    <td
                        class="task <?php echo strtotime($row['dueDate']) > strtotime(date('Y-m-d H:i:s')) ? null : 'text-danger' ?> <?php echo $row['isCompleted'] === "0" ? null : 'done' ?>">
                        <?php echo $row['task']; ?>
                    </td>

                    <td
                        class="<?php echo strtotime($row['dueDate']) > strtotime(date('Y-m-d H:i:s')) ? null : 'text-danger' ?> <?php echo $row['isCompleted'] === "0" ? null : 'done' ?>">
                        <?php echo date('g:ia \o\n D jS M Y', strtotime($row['createdAt'])) ?>
                    </td>

                    <td
                        class=" <?php echo strtotime($row['dueDate']) > strtotime(date('Y-m-d H:i:s')) ? null : 'text-danger' ?> <?php echo $row['isCompleted'] === "0" ? null : 'done' ?>">
                        <?php echo date('g:ia \o\n D jS M Y', strtotime($row['dueDate'])) ?>
                    </td>


                    <!-- Checkbox input -->
                    <td class=" ">
                        <input type="checkbox" class="checkboxes" value="<?php echo $row['id'] ?>"
                            name="deleteMultiple[]" id="deleteMultiple">
                    </td>

                    <td class="text-center">
                        <!-- delete <a> tag -->
                        <a type="button" data-toggle="modal" data-id="<?php echo $row['id'] ?>"
                            data-target="#deleteModal" title="Delete" class='delete'
                            href="businesslogic.php?del_task=<?php echo $row['id'] ?>"> <i class='fa fa-trash'></i></a>

                        <!-- mark <a> tag-->
                        <a type="button" data-toggle="modal" data-id="<?php echo $row['id'] ?>" data-target="#markModal"
                            title="Mark" class='mark' href="businesslogic.php?mark_task=<?php echo $row['id'] ?>"> <i
                                class='fa <?php echo $row['isCompleted'] == '0' ? 'fa-check' : 'fa-repeat'  ?>'></i></a>

                        <!-- edit <a> tag-->
                        <a title="Edit" class='edit' role="button" href="updatetodo.php?id=<?php echo $row['id'] ?>"> <i
                                class='fa fa-edit'></i></a>
                    </td>
                </tr>
                <?php
                }
                ?>

            </tbody>
        </table>

    </form>



    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this task ?

                    <input type="hidden" name="taskId" id="taskId" value="" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" id="delete_todo" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mark Modal -->
    <div class="modal fade" id="markModal" tabindex="-1" role="dialog" aria-labelledby="markModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="markModalLabel">Mark as Done</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you have completed this task?

                    <input type="hidden" name="taskId" id="taskId" value="" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" id="mark_todo" class="btn btn-success">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete all modal -->
    <div class="modal fade" id="deleteAllModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Selected</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete these tasks?

                    <input type="hidden" name="taskId" id="taskId" value="" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Leave</button>
                    <button type="button" id="mark_todo" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
    integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous">
</script>
<script>
$(document).ready(function() {
    var href;
    $(".delete").click(function() {
        href = $(this).attr("href");
        console.log(href)
    })

    $("#delete_todo").click(function() {
        window.location = href
    })

    $(".mark").click(function() {
        href = $(this).attr("href");
        console.log(href)
    })

    $("#mark_todo").click(function() {
        window.location = href
    });

    //Listen for a click on any of the dropdown items
    $(".dropdown-menu a").click(function() {
        //Get the value
        var sortBy = $(this).attr("value");
        console.log(sortBy, 'sortBy');
        window.location = 'todo.php?sortBy=' + sortBy;

    });

});

$(document).ready(function() {
    // binding the check all box to onClick event
    $(".chk_all").click(function() {
        var checkAll = $(".chk_all").prop('checked');
        if (checkAll) {
            $(".checkboxes").prop("checked", true);
        } else {
            $(".checkboxes").prop("checked", false);
        }
    });
    // if all checkboxes are selected, then checked the main checkbox class and vise versa
    $(".checkboxes").click(function() {
        if ($(".checkboxes").length == $(".subscheked:checked").length) {
            $(".chk_all").attr("checked", "checked");
        } else {
            $(".chk_all").removeAttr("checked");
        }
    });
});
</script>

</html>