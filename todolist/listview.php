
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
                    <div class="input-group">
                        <input type="text" name="task_name" class="form-control task-input" value="<?php echo $row['task']; ?>">
                        <div class="input-group-append">
                            <a href="?action=edit&id=<?php echo $row['id']; ?>" class="btn btn-info">Edit</a>
                            <a href="?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
