<?php
include 'connect.php';
include 'header.php';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
echo '<form method="post" action="">
    <div id="content">
        <div id="newCatTitle">Add Another Subcategory?</div>
	  <h3>Subcategory Title</h3>
          <textarea id="newCatBox" name="subcat_name" maxLength="80" ></textarea>
	  <h3 id="parentTitle">Belongs to which main category?</h3>
          <select id="subcat_parent_dropdown" value="Subcategory" name="subcat_parent">';
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

        echo '<option>' . $cat_name . '</option>';
        }
   }
          echo '</select>
          <input type="submit" value="Submit" name="submit2" id="submitDoc" />
    </div>
</form>';
}
else
{
    $sql = "INSERT INTO
                                                      sub_categories(subcat_name,
						               subcat_parent,
                                                               subcat_author)
            VALUES('" . mysql_real_escape_string($_POST['subcat_name']) . "',
              '" . mysql_real_escape_string($_POST['subcat_parent']) . "',
                                       '" . $_SESSION['user_name'] . "')";
    $result = mysql_query($sql);
    if(!$result)
    {
        echo '<h4 align="center" style="color:#000; margin-top: 100px">An error has occured. <a href="post.php" class="register" style="color: #5870D1">Please try again</a></h4>';
    }
    else
    {
    $post_id = mysql_insert_id();
    $sql = "COMMIT";
    $result = mysql_query($sql);
    header('Location: addsubcat.php');
    }
}

include 'scripts/scripts.php';
?>