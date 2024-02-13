<?php
include 'todolist.php';
include 'requestHandler.php';

$todoList = new ToDoList("localhost", "root", "", "todolist");

handleRequests($todoList);

$result = $todoList->getTasks("ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List with Database</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <h1>To-Do List</h1>
        <form action="" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="task" class="form-control task-input" placeholder="Enter task...">
                <div class="input-group-append">
                    <button type="submit" name="submit" class="btn btn-primary">Add Task</button>
                </div>
            </div>
            <input type="hidden" name="action" value="add">
        </form>
        <ul class="list-group">
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <li class="list-group-item">
                    <form action="" method="GET">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <div class="input-group">
                            <input type="text" name="task_name" class="form-control task-input" value="<?php echo $row['task']; ?>">
                            <div class="input-group-append">
                                <button type="submit" name="action" value="edit" class="btn btn-info">Edit</button>
                                <button type="submit" name="action" value="delete" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </form>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
