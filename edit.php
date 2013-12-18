<?php
include 'connect.php';
include 'editHeader.php';

echo '<div id="editWrap">';
echo '<div id="editContent">';
$post_title = $_POST["post_title"];
$sql = "SELECT * FROM `post` WHERE post_id = " . mysql_real_escape_string($_GET['id']). "";
$q = mysql_query($sql);

    if($_SERVER['REQUEST_METHOD'] != 'POST' && $_SESSION['signed_in'] == true)
    while($row = mysql_fetch_assoc($q))
    {
    echo '<form method="post" name="newContent" action="content.php">';
          echo '<h3 class="editFormNames">Title</h3>
	    <textarea name="post_title" maxLength="80" >' . $row['post_title'] . '</textarea>
            <h3 class="editFormNames">Content</h3>
	    <p>
               <textarea id="editContentText" name="post_content">' . $row['post_content'] . '&lt;p&gt;&lt;/p&gt;</textarea>
               <script>
               CKEDITOR.replace( "post_content" );
	       </script>
            </p>
	    <div id="categories">
	      <div id="categoryWrap">
                <h3 class="editFormNames">Category</h3>
		<select id="categories_select" name="categories">';
	        $q = mysql_query("SELECT * FROM `categories`,`users` WHERE cat_author = user_name ORDER BY cat_name");
		$total = mysql_num_rows($q);
		{
		if($total < 1)
			    {
			    echo '<h5 style="color:#000">There are no categories yet.</h5>';
			    }
			    else
			    while($r=mysql_fetch_assoc($q))
			    {
                            $cat_name = $r["cat_name"];
			    $cat_name2 = str_replace(' ', '', $r["cat_name"]);
                            
			    echo '<option value="' . $cat_name2 . '">' . $cat_name . '</option>';
			    }
		}		  
              echo '</select>
	      </div>
	      <div id="subcatWrap">
                <h3 class="editFormNames">Sub-Category</h3>
                <div class="editFormNames">Will default to "General" if no selection</div>';

		$q = mysql_query("SELECT * FROM `categories`,`users` WHERE cat_author = user_name ORDER BY cat_name");

		$total = mysql_num_rows($q);
		{
		if($total < 1)
			    {
			    echo '<h5 style="color:#000">There are no subcategories yet.</h5>';
			    }
			    else
			    while($r=mysql_fetch_assoc($q))
			    {
			    $cat_name = str_replace(' ', '', $r["cat_name"]);
			    $cat_name2 = $r["cat_name"];
			    echo '<div class="editRadioOptions" id="' . $cat_name . '_ok">
			    <input type="radio" id="' . $cat_name . 'General" name="sub_cat" value="General" checked>
			    <label for="' . $cat_name . 'General">General</label>';
		            $subcategory = mysql_query("SELECT * FROM `users`, `sub_categories` WHERE subcat_parent = '$cat_name2' AND subcat_author = user_name ORDER BY subcat_name");
			    while($r2=mysql_fetch_assoc($subcategory))
				    {
   			            $subcat_name = $r2["subcat_name"];
				    echo '<input type="radio" id="' . $subcat_name . '" name="sub_cat" value="' . $subcat_name . '">
                                    <label for="' . $subcat_name . '">' . $subcat_name . '</label>';
				    }
			    echo '</div>';

			    }
        	}
           echo '<input type="submit" value="Submit" id="submitDoc" />';

           echo '</div>
           </div>';
           echo '</form>';	
	   }

else
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
			$editsql = "UPDATE
						           post
                                    SET
                                                           post_title ='" . mysql_real_escape_string($_POST['post_title']) . "',
                                                           post_content = '" . mysql_real_escape_string($_POST['post_content']) . "',
							   categories = '" . mysql_real_escape_string($_POST['categories']) . "',
							   sub_cat = '" . mysql_real_escape_string($_POST['sub_cat']) . "',
                                                           post_author = '" . $_SESSION['user_name'] . "'

                                    WHERE
                                                           post_id = " . mysql_real_escape_string($_GET['id']). "";

			$editresult = mysql_query($editsql);
			if(!$editresult)
			{
                                echo '<h4 align="center" style="color:#fff">An error has occured. <a href="post.php">Please try again</a></h4>';
			}
                        else
                        {
                                $post_id = mysql_insert_id();
                                $editsql = "COMMIT";
		               	$editresult = mysql_query($editsql);

				echo '<h4 align="center" style="color:#fff">You have succesfully edited <a href="content.php?id=' . mysql_real_escape_string($_GET['id']). '">your topic.</a></h4>.';
			}
              }
        }



include 'scripts/scripts.php';
?>


