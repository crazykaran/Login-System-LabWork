<?php
    session_start();

    require 'dbConnection.php';

    $username=$_POST["username"];
    $password=$_POST["password"];
    
    //check crediantials
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    
    if($user){
        $hashed_password=$user['pass'];
        if(password_verify($password, $hashed_password)) {
            $_SESSION['isLoggedIn']=true;
            $_SESSION['username']=$username;
            header("location:https://localhost/demo/home.php");
        } else{
            echo "<script>alert('Wrong Password');</script>";
            header("Refresh: 0; URL=https://localhost/demo/login.php");
            die();
        }
    }else{
        echo "<script>alert(\"User Doesn't Exists\");</script>";
        header("Refresh: 0; URL=https://localhost/demo/login.php");
        die();
    }
?>