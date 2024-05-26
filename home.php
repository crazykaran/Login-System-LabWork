<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        form {
            margin-bottom: 20px;
            margin-top:60px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"]{
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        textarea {
            width: 100%;
            height:20vh;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .logout {
            float:right;
            position:sticky;
            top:20px;
            right:20px;
            margin-top: 20px;
        }

        .post-container {
            margin-top: 20px;
        }

        .post {
            background-color: #f9f9f9;
            border-left: 6px solid #4CAF50;
            margin: 10px 0;
            padding: 10px 20px;
        }

        .post h2 {
            margin-top: 0;
        }

        pre {
            white-space: pre-wrap; /* Preserve whitespace and wrap lines */
            font-family: monospace; /* Use a monospaced font for consistent spacing */
            padding: 10px;
            border-radius: 4px;
            background-color: #f3f3f3;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <form class="logout" action="logout.php" method="post">
        <input type="submit" value="Logout">
    </form>

    <form action="upload.php" method="POST">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <br>
        <label for="about">About:</label>
        <textarea id="about" name="about" class="tab-input" required></textarea>
        <br>
        <label for="code">Code:</label>
        <textarea id="code" name="code" class="tab-input"></textarea>
        <br>
        <input type="submit" value="Post">
    </form>


    <div class="post-container">
        <?php
        session_start();
        require 'dbConnection.php';

        if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true ){
            
            $stmt = "SELECT * FROM {$_SESSION['username']}";
            $result=$conn->query($stmt);
            
            while($row = $result->fetch_assoc()) {
                // Access individual columns using associative array keys
                echo '<div class="post">';
                echo "<h2>Title: " . $row["topic"]. "</h2>";
                echo "<p>" . nl2br($row["about"]). "</p>";
                echo "<pre>". nl2br($row["code"]). "</pre>";
                echo '</div>';
            }
        } else {
            // User is not logged in
            header("location:https://localhost/demo/login.php");
        }
        ?>
    </div>
</body>
</html>
