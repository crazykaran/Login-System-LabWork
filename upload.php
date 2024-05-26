<?php
    session_start();
    require 'dbConnection.php';
    $title=$_POST['title'];
    $about=$_POST['about'];
    $code=$_POST['code'];

    $code = htmlspecialchars($code); // Convert special characters to HTML entities
    
    $stmt = $conn->prepare("INSERT INTO {$_SESSION['username']} VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $about, $code);

    // Execute the statement
    $stmt->execute();

    header("location:https://localhost/demo/home.php");


?>