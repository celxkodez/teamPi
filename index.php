

<?php
try{
//login.php

/**
 * Start the session.
 */
session_start();

/**
 * Include ircmaxell's password_compat library.
 */


/**
 * Include our MySQL connection.
 */
require 'config.php';


//If the POST var "login" exists (our submit button), then we can
//assume that the user has submitted the login form.
if(isset($_POST['login'])){
    
    //Retrieve the field values from our login form.
    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $passwordAttempt = !empty($_POST['password']) ? trim($_POST['password']) : null;
    
    //Retrieve the user account information for the given username.
    $sql = "SELECT id, username, password FROM user WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    
    //Bind value.
    $stmt->bindValue(':username', $username);
    
    //Execute.
    $stmt->execute();
    
    //Fetch row.
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //If $row is FALSE.
    if($user === false){
        //Could not find a user with that username!
        //PS: You might want to handle this error in a more user-friendly manner!
        die('Incorrect username / password combination!');
    } else{
        //User account found. Check to see if the given password matches the
        //password hash that we stored in our users table.
        
        //Compare the passwords.
        $validPassword = password_verify($passwordAttempt, $user['password']);
        
        //If $validPassword is TRUE, the login has been successful.
        if($validPassword){
            
            //Provide the user with a login session.
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['logged_in'] = time();
            
            //Redirect to our protected page, which we called signup.php
            header('Location: signup.php');
            exit;
            
        } else{
            //$validPassword was FALSE. Passwords do not match.
            die('Incorrect username / password combination!');
        }
    }
    
}
}
//catch exception
catch(Exception $e) {
    echo 'Message: ' .$e->getMessage('something went wrong');
  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="styles/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
            <!-- This is where the login form begins -->
    <div class="container">
                <div class="login">
                    <p>USER LOGIN</p>
                    <form class="form forom-horizontal" action="" method="POST">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Username" required name="username" class="input1">
                            <input type="password" class="form-control" placeholder="Password" required name="password" class="input1">
                            <ul><li><a href="#">Forgot Password?</a></li></ul>
                            <input type="submit" class="form-control submit" name="login" value="Login" class="input2">
                            <ul><li><a href="signup.php">Create Account</a></li></ul> 
                        </div>  
                    </form>
                    
                </div>
            </div>
    </div>
    <script src="jquery/jquery.min.js"></script>
    <script src="styles/js/bootstrap.min.js"></script>
</body>
</html>
