<?php
class ToDoList {
    private $conn;

    function __construct($servername, $username, $password, $dbname) {
        $this->conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    function addTask($task) {
        $sql = "INSERT INTO tasks (task) VALUES ('$task')";
        mysqli_query($this->conn, $sql);
    }

    function editTask($taskId, $taskName) {
        $sql = "UPDATE tasks SET task='$taskName' WHERE id='$taskId'";
        mysqli_query($this->conn, $sql);
    }

    function deleteTask($taskId) {
        $sql = "DELETE FROM tasks WHERE id='$taskId'";
        mysqli_query($this->conn, $sql);
    }

    function getTasks() {
        $sql = "SELECT * FROM tasks";
        $result = mysqli_query($this->conn, $sql);
        return $result;
    }

    function closeConnection() {
        mysqli_close($this->conn);
    }
}

$todoList = new ToDoList("localhost", "root", "", "todolist");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        $task = $_POST['task'];
        $todoList->addTask($task);
    } elseif (isset($_POST['edit'])) {
        $taskId = $_POST['id'];
        $taskName = $_POST['task_name'];
        $todoList->editTask($taskId, $taskName);
    } elseif (isset($_POST['delete'])) {
        $taskId = $_POST['id'];
        $todoList->deleteTask($taskId);
    }
}

$result = $todoList->getTasks();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            display: flex;
            align-items: center;
        }
        .task-input {
            flex: 1;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>To-Do List</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="text" name="task" class="task-input" placeholder="Enter task...">
            <button type="submit" name="submit">Add Task</button>
        </form>
        <ul class="tasks">
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <li>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="text" name="task_name" class="task-input" value="<?php echo $row['task']; ?>">
                        <button type="submit" name="edit">Edit</button>
                    </form>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>

<?php
$todoList->closeConnection();
?>
