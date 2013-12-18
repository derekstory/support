<?php
include 'connect.php';
include 'header.php';
?>
<div id="createNewUser">
    <h1 style="color: #000">Create New User</h1>
<?php
$user_name = $_POST["user_name"];
$q = mysql_query("SELECT user_name FROM users WHERE user_name = '$user_name'");

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
echo '<form method="post" action="">
           User Name<input type="text" name="user_name"style="height:50px;text-align:left; width:100%; font-size:1.3em; background: rgba(255,255,255,.05); color: #000; outline: none"/><br />
           Password<input type="PASSWORD" name="user_pass" style="height:50px;text-align:left; width: 100%; font-size: 1.3em; background: rgba(255,255,255,.05); color: #000; outline: none "/><br />
           Repeat Password<input type="PASSWORD" name="user_pass_check"style="height:50px;text-align:left;width:100%; font-size: 1.3em; background: rgba(255,255,255,.05); color: #000; outline: none"/><br />
           E-mail Address<input type="text" name="user_email" style="height:50px;text-align:left;width:100%; font-size:1.3em;background: rgba(255,255,255,.05); color: #000; outline: none" /><br />
           <input type="submit" value="Register" id="submitNewUser"/></p>
      </form>';
}
else
{
        $errors = array();
        if(isset($_POST['user_name']))
        {
               if(empty($_POST['user_name']))
               {
               $errors[] = die('The username field must not be empty. Please <a href="signup.php">try again</a>.');
               }
               if(!preg_match("/^[a-zA-Z0-9_]./", $user_name))
               {
                        $errors[] = 'The username can only contain letters and digits.';
               }
                if(strlen($_POST['user_name']) > 30)
               {
                        $errors[] = 'The username cannot be longer than 30 characters.';
               }
        }
        if(mysql_num_rows($q) != 0)
        {
                        $errors[] = 'The username already already exist.  Please <a href="signup.php" style="color: #333; text-decoration: underline;">try again</a> with a different username.';
        }
         if(isset($_POST['user_pass']))
        {
               if($_POST['user_pass'] != $_POST['user_pass_check'])
               {
                        $errors[] = 'The two passwords did not match.';
               }
               if(empty($_POST['user_pass']))
               {
                        $errors[] = die('The password field cannot be empty. Please <a href="signup.php">try again</a>.');
               }
        }
        if(isset($_POST['user_email']))
        {
               if(empty($_POST['user_email']))
               {
                        $errors [] = die('The E-Mail Address field must not be empty. Please <a href="signup.php">try again</a>.');
               }
        }
        if(!empty($errors))
        {
                $die;
                echo 'Uh-oh.. a couple of fields are not filled in correctly. Please <a href="signup.php">try again</a>.<br /><br />';
                echo '<ul>';
                foreach($errors as $key => $value)
                {
                        echo '<li>' . $value . '</li>';
                }
                echo '</ul>';
        }
        else

        {
                $sql = "INSERT INTO
                        users(user_name, user_pass, user_email ,user_date, user_level)
                        VALUES('" . ($_POST['user_name']) . "',
                        '" . sha1($_POST['user_pass']) . "',
                        '" . mysql_real_escape_string($_POST['user_email']) . "',
                        NOW(),
                        0)";
                $result = mysql_query($sql);
                if(!$result)
                {
                        echo 'Something terrible just happened! Please <a href="signup.php">try again</a>.';
                }
                else
                {
                 $user_id = mysql_insert_id();
                                $sql = "COMMIT";
                                       $result = mysql_query($sql);
                        echo 'The new user has been created and can now log in.';
                }
         }

}
?>
</div>


<?php
include 'scripts/scripts.php';
?>