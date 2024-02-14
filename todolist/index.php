<?php
	include 'todolist.php';
	$todoList = new ToDoList("localhost", "root", "", "todolist");
	$todoList->handleRequests($todoList);
	$todoList->render($todoList);
	
	

?>