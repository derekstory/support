<?php
include 'connect.php';
include 'header.php';

$sql = "SELECT *

         FROM
                   `post`,`users`
         WHERE
                   post_id = " . mysql_real_escape_string($_GET['id']). "
         AND
                   post_author = user_name";

$result = mysql_query($sql);
{
        while($row = mysql_fetch_assoc($result))

        if(!$result)
     {
        echo '<h1 style="color:#000, margin-top: 600px">The topic could not be displayed, please try again later.</h1>';
     }
     else
     {
     echo ' <div id="content">
       <h1 id="contentTitle">' . $row["post_title"] . '</h1>
       <div id="contentBody">' . $row["post_content"] . '</div>
       <h6>Last edited by: ' . $row["post_author"] . ' on ' . $row["post_date"] . '</h6>
</div>';
     }
}
include 'scripts/scripts.php';
?>