<?php
include 'connect.php';
include 'header.php';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
echo '<form method="post" action="">
    <div id="content">
        <div id="newCatTitle">New Category</div>
          <textarea id="newCatBox" name="cat_name" maxLength="80" ></textarea>
          <input type="submit" value="Submit" name="submit2" id="submitDoc" />
    </div>
</form>';
}
else
{
    $sql = "INSERT INTO
                                                      categories(cat_name,
                                                               cat_author)
            VALUES('" . mysql_real_escape_string($_POST['cat_name']) . "',
                                       '" . $_SESSION['user_name'] . "')";

 
    $result = mysql_query($sql);
    if(!result)
    {
        echo '<h4 align="center" style="color:#000; margin-top: 100px">An error has occured. <a href="post.php" class="register" style="color: #5870D1">Please try again</a></h4>';
    }
    else
    {
    $sql = "COMMIT";
    header('Location: addcategory.php');
    }
}

include 'scripts/scripts.php';
?>