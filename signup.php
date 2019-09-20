

    <?php
try{
//register.php

/**
 * Start the session.
 */
session_start();


/**
 * Include our MySQL connection.
 */
require 'config.php';


//If the POST var "register" exists (our submit button), then we can
//assume that the user has submitted the registration form.
if(isset($_POST['submit'])){
    //post the form
    /*$firstname=$_POST['firstname'];

    $lastname=$_POST['lastname'];

    $username=$_POST['username'];

    $password=$_POST['password'];
    */
    
    //Retrieve the field values from our registration form.
    $firstname = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
    $lastname = !empty($_POST['lastname']) ? trim($_POST['lastname']) : null;
    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
    
    //TO ADD: Error checking (username characters, password length, etc).
    //Basically, you will need to add your own error checking BEFORE
    //the prepared statement is built and executed.
    
    //Now, we need to check if the supplied username already exists.
    
    //Construct the SQL statement and prepare it.
    $sql = "SELECT COUNT(username) AS num FROM user WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    
    //Bind the provided username to our prepared statement.
    $stmt->bindValue(':username', $username);
    
    //Execute.
    $stmt->execute();
    
    //Fetch the row.
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //If the provided username already exists - display error.
    //TO ADD - Your own method of handling this error. For example purposes,
    //I'm just going to kill the script completely, as error handling is outside
    //the scope of this tutorial.
    if($row['num'] > 0){
        die('That username already exists!');
    }
    
    //Hash the password as we do NOT want to store our passwords in plain text.
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    
    //Prepare our INSERT statement.
    //Remember: We are inserting a new row into our users table.
    $sql = "INSERT INTO `user`(`firstname`, `lastname`, `username`, `password`) VALUES (:firstname, :lastname, :username, :password)";

    //$sql = "INSERT INTO user (username, password) VALUES (:username, :password)";
    $stmt = $pdo->prepare($sql);
    
    //Bind our variables.
    $stmt->bindValue(':firstname', $firstname);

    $stmt->bindValue(':lastname', $lastname);

    $stmt->bindValue(':username', $username);


    $stmt->bindValue(':password', $passwordHash);

    //Execute the statement and insert the new account.
    $result = $stmt->execute();
    
    //If the signup process is successful.
    if($result){
        //What you do here is up to you!
        echo 'Thank you for registering with with us.';
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
    <title>Signup</title>
    <link rel="stylesheet" href="styles/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
        <div class="container_signup">
                <div class="signup">
                    <h1>Create Account</h1>
                    <form class="form form-horizontal" action="" method="POST">
                        <div class="form-group">
                            <input type="text" class="form-control incont" placeholder="Firstname" required name="firstname" >
                            <input type="text" class="form-control incont" placeholder="Lastname" required name="lastname" >
                            <input type="text" class="form-control incont" placeholder="Username" required name="username" >
                            <input type="password" class="form-control incont" placeholder="Password" required name="password" >
                            <input type="submit" class="form-control submit" name="submit" value="Sign Up" >
                            <p>Got an account? <a href="index.php">Log In</a></p> 
                        </div>  
                    </form>
                    
                </div>
            </div>
    </div>



    <script src="jquery/jquery.min.js"></script>
    <script src="styles/js/bootstrap.min.js"></script>    
</body>
</html>