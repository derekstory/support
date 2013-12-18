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
<div id="modalBack" class="modal"></div>
<div id="modalWrap" class="modal">
  <div id="newPostModal">
    <h4 id="modalClose">-Close-</h4>
    <form method="post" name="newContent" action="content.php">
        <h1 class="formHeader">New Documentation</h1>
          <?php
	  if($_SERVER['REQUEST_METHOD'] != 'POST')
	  {
            echo '<h3 class="formNames">Title</h3>
	    <textarea name="post_title" maxLength="80" ></textarea>
            <h3 class="formNames">Content</h3>
	    <p>
               <textarea id="contentText" name="post_content">&lt;p&gt;&lt;/p&gt;</textarea>
               <script>
               CKEDITOR.replace( "post_content" );
	       </script>
            </p>
	    <div id="categories">
	      <div id="categoryWrap">
                <h1 class="formNames">Category</h1>
		<select id="categories_select" name="categories">';
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
			    $cat_name2 = str_replace(' ', '', $r["cat_name"]);
                            
			    echo '<option value="' . $cat_name2 . '">' . $cat_name . '</option>';
			    }
		}		  
              echo '</select>
	      </div>
	      <div id="subcatWrap">
                <h1 class="formNames">Sub-Category</h1>
                <div class="formNames">Will default to "General" if no selection</div>';

		$q = mysql_query("SELECT * FROM `categories`,`users` WHERE cat_author = user_name ORDER BY cat_name");
		$total = mysql_num_rows($q);
		{
		if($total < 1)
			    {
			    echo '<h5 style="color:#000">There are no subcategories yet.</h5>';
			    }
			    else
			    while($r=mysql_fetch_array($q))
			    {
			    $cat_name = str_replace(' ', '', $r["cat_name"]);
			    $cat_name2 = $r["cat_name"];
			    echo '<div class="radioOptions" id="' . $cat_name . '_ok">
			    <input type="radio" id="' . $cat_name . 'General" name="sub_cat" value="General" checked>
			    <label for="' . $cat_name . 'General">General</label>';
		            $subcategory = mysql_query("SELECT * FROM `users`, `sub_categories` WHERE subcat_parent = '$cat_name2' AND subcat_author = user_name ORDER BY subcat_name");
			    while($r2=mysql_fetch_array($subcategory))
				    {
   			            $subcat_name = $r2["subcat_name"];
				    echo '<input type="radio" id="' . $subcat_name . '" name="sub_cat" value="' . $subcat_name . '">
                                    <label for="' . $subcat_name . '">' . $subcat_name . '</label>';
				    }
			    echo '</div>';
			    }
        	}
  	      echo '</div>
	      <input type="submit" value="Submit" id="submitDoc" />
	    </div>';
	   }
	   else
           {
           if($_SESSION['signed_in'] == false)
             {
             echo '<h2 style="color:#fff; margin-left: 50px; margin-top: 100px">You must <a href="signin.php" class="register" style="color: #5870D1"> sign in</a> to post a new topic.</h2>';
             }
             else
             {
             $errors = array();
             if(empty($_POST['post_title']))
             {
             echo '<h4 style="color:#fff; margin-left: 50px; margin-top: 100px">You must enter the title of your post in the header area. <a href="post.php" class="register" style="color: #5870D1">Try again</a> with all of the fields filled in.</h4>';
             }
             if(empty($_POST['post_content']))
             {
             echo '<h4 style="color:#000; margin-left: 50px; margin-top: 100px">You must fill out the content section. <a href="post.php" class="register" style="color: #5870D1">Try again</a> with all of the fields filled in.</h4>';
             }
             else
	     {
             $sql5 = "INSERT INTO
                                                      post(post_title,
                                                           post_content,
                                                           categories,
                                                           sub_cat,
                                                           post_author)
                     VALUES('" . mysql_real_escape_string($_POST['post_title']) . "',
                                                           '" . mysql_real_escape_string($_POST['post_content']) . "',
                                                           '" . mysql_real_escape_string($_POST['categories']) . "',
                                                           '" . mysql_real_escape_string($_POST['sub_cat']) . "',
                                                           '" . $_SESSION['user_name'] . "')";
	                $result = mysql_query($sql5);
                        if(!$result)
                        {
                        echo '<h4 align="center" style="color:#fff; margin-top: 100px">An error has occured. <a href="post.php" class="register" style="color: #5870D1">Please try again</a></h4>';
                        }
                        else
                        {
                                $post_id = mysql_insert_id();
                                $sql5 = "COMMIT";
                                $result = mysql_query($sql);
                                header('Location: content.php?id='.$post_id);
                        }
                }
	   }
	  }
	  ?>
        </form>
	</div>
  </div>
 </div>
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
