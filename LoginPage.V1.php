<?php

###############################################################
#                     Page Password Protect 1.16              #
###############################################################
#           Visit www.facebook.com/mrrb.net for updates       #
############################################################### 

// Add login/password pairs below, like described above
// NOTE: all rows except last must have comma "," at the end of line
$LOGIN_INFORMATION = array(
  'SPY-X' => 'SPY-X',
  'admin' => 'admin',
  'User' => 'User'
);

// request login? true - show login and password boxes, false - password box only
define('USE_USERNAME', true);

// User will be redirected to this page after logout
define('LOGOUT_URL', 'http://www.example.com/');

// time out after NN minutes of inactivity. Set to 0 to not timeout
define('TIMEOUT_MINUTES', 30);

// This parameter is only useful when TIMEOUT_MINUTES is not zero
// true - timeout time from last activity, false - timeout time from login
define('TIMEOUT_CHECK_ACTIVITY', true);

##################################################################
#  SETTINGS END
##################################################################


///////////////////////////////////////////////////////
// do not change code below
///////////////////////////////////////////////////////

// show usage example
if(isset($_GET['help'])) {
  die('Include following code into every page you would like to protect, at the very beginning (first line):<br>&lt;?php include("' . str_replace('\\','\\\\',__FILE__) . '"); ?&gt;');
}

// timeout in seconds
$timeout = (TIMEOUT_MINUTES == 0 ? 0 : time() + TIMEOUT_MINUTES * 60);

// logout?
if(isset($_GET['logout'])) {
  setcookie("verify", '', $timeout, '/'); // clear password;
  header('Location: ' . LOGOUT_URL);
  exit();
}

if(!function_exists('showLoginPasswordProtect')) {

// show login form
function showLoginPasswordProtect($error_msg) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset=UTF-8>
<meta name="author" content="Omar Rbiai SPY-X">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href='https://imgur.com/68lJfSo.png' rel='icon' type='image/x-icon'/>
<body background="https://wallpaperscraft.com/image/tom_and_jerry_cheese_mouse_minimalism_94065_1920x1080.jpg">
<title>Please Enter Password To Access This Page</title>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<iframe width="0" height="0" src="https://www.youtube.com/embed/jELDIPJug4g?rel=0&autoplay=1&loop=1&watch?v=QdIYVXCfrQM" frameborder="0" allowfullscreen></iframe>
</head>
<body>
<center><img src="https://imgur.com/0nE6Ro2.gif" alt="404"" alt="404" height="200" width="200"></center>

  <style>
    input { border: 1px solid White; }
	.flash {
   animation-name: flash;
    animation-duration: 0.4s;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
    animation-direction: alternate;
    animation-play-state: running;
}

@keyframes flash {
    from {color: #FF0000;}
    to {color: #FFFF00;}
}
h1 {
    color: Red;
    text-shadow: 1px 1px 2px Yellow, 0 0 25px Yellow, 0 0 5px Blue;
}
h2 {
    color: Blue;
    text-shadow: 1px 1px 2px white, 0 0 10px Yellow, 0 0 5px white;
	
	p {
    color: Yellow;
    text-shadow: 1px 1px 2px Yellow, 0 0 10px Yellow, 0 0 5px Yellow;
	  }
a:link, a:visited { 
    color: Red;
    text-decoration: underline;
    cursor: auto;
}

a:link:active, a:visited:active { 
    color: RED;
}


.buttonstyle 
{ 
background: Red; 
background-position: 10px 10px; 
border: solid 1px #000000; 
color: #ffffff;
height: 35px;
margin-top: -1px;
padding-bottom: 5px;
}
.buttonstyle:hover {background: white;background-position: 100px 100px;color: #000000; }

.button:hover {
    box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
}


}
.btn-group .button:not(:last-child) {
    border-right: none; /* Prevent double borders */
}
.btn-group .button:hover {
    background-color: #3e8e41;
}

input[type=text] {
    padding:15px; 
    border:10px solid #ccc; 
    -webkit-border-radius: 10px;
    border-radius: 10px;
}

input[type=text]:focus {
    border-color:#333;
}

input[type=submit] {
    padding:10px 20px; 
    background:#Res; 
    border:0 none;
    cursor:pointer;
    -webkit-border-radius: 10 px;
    border-radius: 7px; 
}

.buttonstyle 
{ 
background: Red; 
background-position: 0px -401px; 
border: solid 1px #000000; 
color: #ffffff;
height: 35px;
margin-top: -1px;
padding-bottom: 10px;
}
.buttonstyle:hover {background: white;background-position: 0px -501px;color: #000000; }

  </style>
  <div style="width:500px; margin-left:auto; margin-right:auto; text-align:center">
  <form method="post">
     <center> <font color="Red"> <h1>SPY-X </h1></font><font color="White"><h2>Password Protect V.1</h2></font></center>
   <center> <font color="Yellow"> <p>Please Enter Password To Access This Page</p></font></center>
    <font color="red"><?php echo $error_msg; ?></font><br/>
<?php if (USE_USERNAME) echo '<font color="#00FF00">Login:<br><input type="input" name="access_login" /><br>Password:</font><br>'; ?>
    <input type="password" name="access_password" /><p></p><input class="buttonstyle"  type="submit" name="Submit" value="Login" />
  </form>
  <br />
  <a target="_blank" style="font-size:9px; color: #B0B0B0; font-family: Verdana, Arial;" href="https://www.facebook.com/omarrbiai.org" title="Download Password Protector">Powered By SPY-X </a>
  </div>
</body>
</html>

<?php
  // stop at this point
  die();
}
}

// user provided password
if (isset($_POST['access_password'])) {

  $login = isset($_POST['access_login']) ? $_POST['access_login'] : '';
  $pass = $_POST['access_password'];
  if (!USE_USERNAME && !in_array($pass, $LOGIN_INFORMATION)
  || (USE_USERNAME && ( !array_key_exists($login, $LOGIN_INFORMATION) || $LOGIN_INFORMATION[$login] != $pass ) ) 
  ) {
    showLoginPasswordProtect("Incorrect PASSWORD !!");
  }
  else {
    // set cookie if password was validated
    setcookie("verify", md5($login.'%'.$pass), $timeout, '/');
    
    // Some programs (like Form1 Bilder) check $_POST array to see if parameters passed
    // So need to clear password protector variables
    unset($_POST['access_login']);
    unset($_POST['access_password']);
    unset($_POST['Submit']);
  }

}

else {

  // check if password cookie is set
  if (!isset($_COOKIE['verify'])) {
    showLoginPasswordProtect("");
  }

  // check if cookie is good
  $found = false;
  foreach($LOGIN_INFORMATION as $key=>$val) {
    $lp = (USE_USERNAME ? $key : '') .'%'.$val;
    if ($_COOKIE['verify'] == md5($lp)) {
      $found = true;
      // prolong timeout
      if (TIMEOUT_CHECK_ACTIVITY) {
        setcookie("verify", md5($lp), $timeout, '/');
      }
      break;
    }
  }
  if (!$found) {
    showLoginPasswordProtect("");
  }

}

?>
###############################################################
#                     ADD Your Page Here                      #
###############################################################
<html>
<head>
<meta charset=UTF-8>
<meta name="author" content="Omar Rbiai SPY-X">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href='https://i.imgur.com/0zto1k6.png' rel='icon' type='image/x-icon'/>
<title>Your Page Bro</title></head>
<iframe width="0" height="0" src="https://www.youtube.com/embed/UyAUkHOCroQ?rel=0&autoplay=1&loop=1&watch?v=QdIYVXCfrQM" frameborder="0" allowfullscreen></iframe>
<style>
</style>
</head>
<body>
</body>
</html>