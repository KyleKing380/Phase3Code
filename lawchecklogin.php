<?php

    session_start();
    $username = $_POST['username'];
    $password = $_POST['password'];

    session_start();
    echo "'$username'" . "<br>";
    echo "'$password'" . "<br>";
    if ($username == 'root' && $password == 'newpassword') //credentials for the normal users. change this to your phpmyadmin credentials
    {
        echo "In True Block";
        $_SESSION['login'] = $username;
        $goto = "Location: lawdata.php";  //This is our landing page
    } else if ($username == 'firmadmin' && $password == 'dbadmin') //credentials for admin. leave this as is
    {
        echo"In True Block";
        $_SESSION['login'] = $username;
        $goto = "Location: admindata.php";
    }else {
        echo "In False Block";
        $_SESSION['login'] = '';
	    $ref = getenv("HTTP_REFERER");     //This is the referrer page -- the login form
	    $goto = "Location: " . $ref;
    }	

    echo "Session Login Value = " . $_SESSION['login'] . "<br>";
    header($goto);
?>
