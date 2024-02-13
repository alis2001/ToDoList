<?php
function handleRequests($todoList) {
    $errorMessage = "";
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        switch ($action) {
            case 'add':
                if (isset($_GET['task']) && !empty($_GET['task'])) {
                    $task = $_GET['task'];
                    $todoList->addTask($task);
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
?>
