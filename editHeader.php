<!doctype html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="Nextep Support Documentation" />
    <title>Support Documentation</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script type='text/javascript' src="scripts/jquery.php"></script>
    <script src="ckeditor/ckeditor.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Josefin+Sans' rel='stylesheet' type='text/css'>
</head>
<body>
<?php
       if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
        {}else
        {
        header("Location: signin.php");
	exit;
        }
?>
<div id="header">
    <div id="optionBar">

      <a href="index.php"><div class="headOptionLeft" id="head1">Home</div></a>
      <div id="head2" class="headOptionLeft">New Entry</div>
      <a href="admin"><div class="headOptionLeft" id="head3">Admin</div></a>

      <form>
	<input id="submit" type="submit" value="Search" />
	<input id="search" type="text" placeholder="search for document"/>
      </form>
        <?php
         $sql2 = "SELECT
                        user_id,
                        user_name,
                        user_level
                FROM
                        users
                WHERE
                        user_name = '" . ($_SESSION['user_name']) . "'";

        $result = mysql_query($sql);
        if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
        {
        echo '<a href="signout.php"><div id="signIn" class="signinHead" >Log Out as ' . $_SESSION['user_name'] . '</div></a>';
        }
        else
        {
        header("Location: signin.php");
	exit;
        }
	?>      
    </div>
 </div>
<div id="sideWrap">
 <div id="sidebar">
   <img id="sideLogo" src="images/logo.gif" />
   <?php
   $q = mysql_query("SELECT * FROM `categories`,`users` WHERE cat_author = user_name ORDER BY cat_name");
   $total = mysql_num_rows($q);
   {
   if($total < 1)
        {
        echo '<h5 style="color:#000">There are no categories yet.</h5>';
        }
        else
        while($r=mysql_fetch_array($q))
        {
        $cat_name = $r["cat_name"];
	$cat_id = $r["cat_id"];
        echo'<a href="category.php?id=' . $cat_id . '">
	       <div class="sideCatWrap">
               <h4 class="sideCat">-' . $cat_name . '-</h4>
	       </div>
        </a>';
        }
   }
   ?>
 </div>
</div>
