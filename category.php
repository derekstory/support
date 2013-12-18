<?php
include 'connect.php';
include 'header.php';
?>
<div id="content">
    <div id="categoryContent">
       <?php
              $sqlCatname = "SELECT * FROM `categories`, `users` WHERE cat_id = " . mysql_real_escape_string($_GET['id']). " AND cat_author = user_name";

	$resultCat = mysql_query($sqlCatname);
        {
        while($rowCat = mysql_fetch_assoc($resultCat))

        if(!$resultCat)
     	    {
            echo '<h1 style="color:#000, margin-top: 600px">The topic could not be displayed, please try again later.</h1>';
     	    }
     	    else
     	    {
     	    echo '<h1 id="categoryTitle">' . $rowCat["cat_name"] . '</h1>';
     	    }
	}
        ?>


        <?php
        $sqlGeneral = mysql_query("SELECT * FROM `categories`, `post`,`users` WHERE cat_id = " . mysql_real_escape_string($_GET['id']). " AND categories = cat_name AND sub_cat = 'General' AND cat_author = user_name ORDER BY post_title");

              $countGeneral = mysql_num_rows($sqlGeneral);
                 echo '<h2>General</h2>';
              {
              if($countGeneral < 1)
                 {
                 echo '<h4 class="postName">There is no documentation for this subcategory yet.</h4>';    
              	 }
     	  	 else

          	 while($row3=mysql_fetch_array($sqlGeneral))

          	 {
          	 echo '<h4 class="postName"><a href="content.php?id=' . $row3["post_id"] . '">' . $row3["post_title"] . '</a></h4>';
          	 }
              }
?>
    <?php
    $sql = mysql_query("SELECT * FROM `categories`,`users`, `sub_categories` WHERE cat_id = " . mysql_real_escape_string($_GET['id']). " AND subcat_parent = cat_name AND user_name = cat_author ORDER BY subcat_name");

     $count = mysql_num_rows($sql);
     {
         if($count < 1) {} else
         while($row=mysql_fetch_array($sql))
         {
         $subcat_name = $row["subcat_name"];	
         echo '<h2>' . $subcat_name . '</h2>';

              $sql2 = mysql_query("SELECT * FROM `post`,`users`, `sub_categories` WHERE sub_cat = '$subcat_name' AND sub_cat = subcat_name AND post_author = user_name ORDER BY post_title");

              $count2 = mysql_num_rows($sql2);
              {
              if($count2 < 1)
                 {
                 echo '<h4 class="postName">There is no documentation for this subcategory yet.</h4>';    
              	 }
     	  	 else
          	 while($row2=mysql_fetch_array($sql2))
          	 {
          	 echo '<h4 class="postName"><a href="content.php?id=' . $row2["post_id"] . '">' . $row2["post_title"] . '</a></h4>';
          	 }
              }
          }
       }
       ?>
   </div>
</div>

<?php
include 'scripts/scripts.php';
?>