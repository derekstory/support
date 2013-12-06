<?php
ob_start();
include 'connect.php';
include 'header.php';

echo '<h2>Sign out</h2>';

if($_SESSION['signed_in'] == true)
{
        $_SESSION['signed_in'] = NULL;
        $_SESSION['user_name'] = NULL;
        $_SESSION['user_id']   = NULL;

        header('location:index.php');
}
else
{
        echo '<h3 style="color:#000; margin-top:200px; margin-left:50px">You are not signed in. Would you like to <a href="signin.php">sign-in</a>?</h3>';
}
ob_end_flush();
?>