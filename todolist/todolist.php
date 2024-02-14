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

        function getTasks($options = []) {
            $orderBy = isset($options['orderBy']) ? $options['orderBy'] : 'id ASC';
            $sql = "SELECT * FROM tasks ORDER BY $orderBy";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }

        function closeConnection() {
            mysqli_close($this->conn);
        }

        function handleRequests($todoList) {
            $errorMessage = "";
            if (isset($_GET['action'])) {
                $action = $_GET['action'];
                switch ($action) {
                    case 'add':
                        if (isset($_GET['task']) && !empty($_GET['task'])) {
                            $task = $_GET['task'];
                            $todoList->addTask($task);
                            header("Location: {$_SERVER['PHP_SELF']}");
                            exit();
                        } else {
                            $errorMessage = "Please enter a task.";
                        }
                        break;
                    case 'edit':
                        if (isset($_GET['id']) && isset($_GET['task_name'])) {
                            $taskId = $_GET['id'];
                            $taskName = $_GET['task_name'];
                            $todoList->editTask($taskId, $taskName);
                        }
                        break;
                    case 'delete':
                        if (isset($_GET['id'])) {
                            $taskId = $_GET['id'];
                            $todoList->deleteTask($taskId);
                        }
                        break;
                    default:
                        break;
                }
            }
            if (!empty($errorMessage)) {
                echo "<p class='error'>$errorMessage</p>";
            }
        }
        function render($todoList){
            $result = $todoList->getTasks(['orderBy' => 'id ASC']);
            require 'listview.php';

            
        }
    }
?>
