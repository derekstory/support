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
<div id="modalBack" class="modal"></div>
<div id="modalWrap" class="modal">
  <div id="newPostModal">
    <h4 id="modalClose">-Close-</h4>
    <form method="post" action="">
        <h1 class="formHeader">New Documentation</h1>
        <div class="headerarea">
          <?php
	  if($_SERVER['REQUEST_METHOD'] != 'POST')
	  {
          echo '<form>
            <h3 class="formNames">Title</h3>
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
		<select id="categories_select" name="categories">
		  <option value="Printers">Printers</option>		  
		  <option value="Credit">Credit</option>		  
		  <option value="Configurator">Configurator</option>		  
		</select>
	      </div>
	      <div id="subcatWrap">
                <h1 class="formNames">Sub-Category</h1>
		<div id="printers_ok">
		<select value="Printers" name="sub_cat">
		  <option>General</option>
		  <option>printers 1</option>
		  <option>Printers 2</option>
		  <option>Printers 3</option>
		  <option>Printers 4</option>
		</select>
		</div>
		<div id="credit_ok">
		<select value="credit" name="sub_cat">
		  <option>General</option>
		  <option>credit 1</option>
		  <option>credit 2</option>
		  <option>credit 3</option>
		  <option>credit 4</option>
		</select>
		</div>
		<div id="configurator_ok">
		<select value="Printers" name="sub_cat">
		  <option>General</option>
		  <option>config 1</option>
		  <option>config 2</option>
		  <option>config 3</option>
		  <option>config 4</option>
		</select>
		</div>
	      </div>
	      <input type="submit" value="Submit" id="submitDoc" />
	    </div>
	   </form>';
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
             $errors[] = die;
             }
             if(empty($_POST['post_content']))
             {
             echo '<h4 style="color:#000; margin-left: 50px; margin-top: 100px">You must fill out the content section. <a href="post.php" class="register" style="color: #5870D1">Try again</a> with all of the fields filled in.</h4>';
             $errors[] = die;
             }
             else
	     {
             $sql = "INSERT INTO
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
	                $result = mysql_query($sql);
                        if(!$result)
                        {
                        echo '<h4 align="center" style="color:#fff; margin-top: 100px">An error has occured. <a href="post.php" class="register" style="color: #5870D1">Please try again</a></h4>';
                        }
                        else
                        {
                                $post_id = mysql_insert_id();
                                $sql = "COMMIT";
                                $result = mysql_query($sql);
                                header('Location: content.php?id='.$post_id);
                        }
                 }
	  
             }
          }
	  ?>
	</div>
     </form>
  </div>
 </div>
 <div id="header">
    <div id="optionBar">
      <a href="index.php"><div class="headOptionLeft" id="head1">Home</div></a>
      <div id="head2" class="headOptionLeft">New Entry</div>
      <a href="signup.php"><div class="headOptionLeft" id="head3">Admin</div></a>
      <form>
	<input id="submit" type="submit" value="Search" />
	<input id="search" type="text" placeholder="search for document"/>
      </form>
        <?php
        $sql = "SELECT
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
        header("Location: http://localhost/signin.php");
        }
	?>      
    </div>
 </div>
<div id="sideWrap">
 <div id="sidebar">
   <h3 id="sideTitle">Categories</h3>
   <a href="#"><h4 class="sideCat">-Printers-</h4></a>
   <a href="#"><h4 class="sideCat">-Credit-</h4></a>
   <a href="#"><h4 class="sideCat">-Configurator-</h4></a>
   <a href="#"><h4 class="sideCat">-Printers-</h4></a>
   <a href="#"><h4 class="sideCat">-Credit-</h4></a>
   <a href="#"><h4 class="sideCat">-Configurator-</h4></a>
   <a href="#"><h4 class="sideCat">-Printers-</h4></a>
   <a href="#"><h4 class="sideCat">-Credit-</h4></a>
   <a href="#"><h4 class="sideCat">-Configurator-</h4></a>
   <a href="#"><h4 class="sideCat">-Printers-</h4></a>
   <a href="#"><h4 class="sideCat">-Credit-</h4></a>
   <a href="#"><h4 class="sideCat">-Configurator-</h4></a>
   <a href="#"><h4 class="sideCat">-Printers-</h4></a>
   <a href="#"><h4 class="sideCat">-Credit-</h4></a>
   <a href="#"><h4 class="sideCat">-Printers-</h4></a>
   <a href="#"><h4 class="sideCat">-Credit-</h4></a>
   <a href="#"><h4 class="sideCat">-Configurator-</h4></a>
   <a href="#"><h4 class="sideCat">-Printers-</h4></a>
   <a href="#"><h4 class="sideCat">-Credit-</h4></a>
   <a href="#"><h4 class="sideCat">-Configurator-</h4></a>
   <a href="#"><h4 class="sideCat">-Printers-</h4></a>
   <a href="#"><h4 class="sideCat">-Credit-</h4></a>
   <a href="#"><h4 class="sideCat">-Configurator-</h4></a>
   <a href="#"><h4 class="sideCat">-Printers-</h4></a>
   <a href="#"><h4 class="sideCat">-Credit-</h4></a>
   <a href="#"><h4 class="sideCat">-Configurator-</h4></a>
   <a href="#"><h4 class="sideCat">-Printers-</h4></a>
   <a href="#"><h4 class="sideCat">-Credit-</h4></a>
 </div>
</div>
