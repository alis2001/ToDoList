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
?>
