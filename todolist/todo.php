<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta>
    <title>To-Do List with Database</title>
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .tasks {
            list-style: none;
            padding: 0;
        }
        .tasks li {
            margin-bottom: 10px;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>To-Do List</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="text" name="task" placeholder="Enter task...">
            <button type="submit" name="submit">Add Task</button>
        </form>
        <ul class="tasks">
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "todolist";
            
            $conn = mysqli_connect($servername, $username, $password, $dbname);

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['submit'])) {
                    $task = $_POST['task'];

                    $sql = "INSERT INTO tasks (task) VALUES ('$task')";
                    mysqli_query($conn, $sql);
                } elseif (isset($_POST['edit'])) {
                    $taskId = $_POST['id'];
                    $taskName = $_POST['task_name'];

                    $sql = "UPDATE tasks SET task='$taskName' WHERE id='$taskId'";
                    mysqli_query($conn, $sql);
                } elseif (isset($_POST['delete'])) {
                    $taskId = $_POST['id'];

                    $sql = "DELETE FROM tasks WHERE id='$taskId'";
                    mysqli_query($conn, $sql);
                }
            }

            $sql = "SELECT * FROM tasks";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                $taskId = $row['id'];
                $taskName = $row['task'];
                echo "<li>";
                echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='POST' style='display: inline;'>";
                echo "<input type='hidden' name='id' value='$taskId'>";
                echo "<input type='text' name='task_name' value='$taskName'>";
                echo "<button type='submit' name='edit'>Edit</button>";
                echo "</form>";
                echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='POST' style='display: inline; margin-left: 10px;'>";
                echo "<input type='hidden' name='id' value='$taskId'>";
                echo "<button type='submit' name='delete'>Delete</button>";
                echo "</form>";
                echo "</li>";
            }

            mysqli_close($conn);
            ?>
        </ul>
    </div>
</body>
</html>
