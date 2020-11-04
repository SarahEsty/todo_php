<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete All</title>
</head>

<body>
    <!-- Checkbox input -->
    <td class="text-center completed">
        <input type="checkbox" class="checkboxes" name="isCompleted" id="isCompleted" <?php echo $row['isCompleted'] === "0" ? null : "checked" ?>>
        <input type="checkbox" name="chk_all" class="chk_all">

    </td>
</body>

<script>
    $('#deleteAll').click(function() {
        var href = new Array();
        if ($('input:checkbox:checked').length > 0) {
            $('input:checkbox:checked').each(function() {
                task.push($(this).attr('id'));
                $(this).closest('tr') > remove();
            })
            sendResponse(task)
        } else {
            alert('No Task Selected');

        }
    });

    function sendResponse(task) {
        s.ajax({
            type: 'post',
            url: todo.php,
            data: {
                'task': task
            },
            success: function(response) {
                alert(response);
            },
            error: function(errResponse) {
                alert(errResponse);
            }
        });
    }
</script>

</html>