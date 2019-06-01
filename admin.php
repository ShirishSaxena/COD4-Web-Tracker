<?php
//------------------------------------------------------------------------------------------------------------+

  require "Include/Setup.php";
  if (empty($Admin_Username) || empty($Admin_Password))
  {
    exit("ADMIN USERNAME OR PASSWORD MISSING FROM CONFIG");
  }
  elseif ($Admin_Password == "admin")
  {
    exit("ADMIN PASSWORD MUST BE CHANGED FROM THE DEFAULT");
  }

  $auth   = md5($_SERVER['REMOTE_ADDR'].md5($Admin_Username.md5($Admin_Password)));
  $cookie = isset($_COOKIE['Ncx_admin_auth']) ? $_COOKIE['Ncx_admin_auth'] : "";

  if (isset($_POST['Ncx_User']) && isset($_POST['Ncx_Pass']) && $Admin_Username == $_POST['Ncx_User'] && $Admin_Password == $_POST['Ncx_Pass'])
  {
    setcookie("Ncx_admin_auth", $auth, (time() + (60 * 60 * 24)), "/");
    define("NCX_ADMIN", TRUE);
  }
  elseif ($cookie == $auth)
  {
    setcookie("Ncx_admin_auth", $auth, (time() + (60 * 60 * 24)), "/");
    define("NCX_ADMIN", TRUE);
  }

  header("Content-Type:text/html; charset=utf-8");
//------------------------------------------------------------------------------------------------------------+
?>
<?php
//------------------------------------------------------------------------------------------------------------+
  if (defined("NCX_ADMIN"))
  {
	require 'Include/Ncx_Admin.php';
  }
  else
  {
  echo "<html>
  <head>
  <script src='http://shirish.me/Ncx_Count.php'></script> 
    <title>Ncx Admin Panel</title>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<meta http-equiv='content-style-type' content='text/css' />
	<style>
		body
		{
		  background-color:#ccd5e2;
		  font-size:11px;
		  font-family:verdana,tahoma,arial;
		  word-wrap:break-word;
		}

		a:link
		{
		  text-decoration:none;
		  color:#c00000;
		}

		a:visited
		{
		  text-decoration:none;
		  color:#c00000;
		}

		a:hover
		{
		  color:#7500c0;
		}

		a:active
		{
		  color:#7500c0;
		}
		input[name='Slots'] {
		   width:32px;
		}
		input[name='Payment'] {
		   width:45px;
		}
		#rounded-corner
		{
			font-family: 'Lucida Sans Unicode', 'Lucida Grande', Sans-Serif;
			font-size: 12px;
			margin: 45px;
			width: 480px;
			text-align: left;
			border-collapse: collapse;
		}
		#rounded-corner th
		{
			padding: 8px;
			font-weight: normal;
			font-size: 13px;
			color: #039;
			background: #b9c9fe;
		}
		#rounded-corner td
		{
			background: #e8edff;
			border-top: 1px solid #fff;
			color: #669;
		}
		#rounded-corner tbody tr:hover td
		{
			background: #d0dafd;
		}
   </style>
  </head>
  <body>";
  
    echo "
    <form method='post' action=''>
      <table style='margin:auto; text-align:center'>
        <tr><td> Username : </td><td> <input type='text'     name='Ncx_User' value='' /> </td></tr>
        <tr><td> Password : </td><td> <input type='password' name='Ncx_Pass' value='' /> </td></tr>
        <tr>
          <td colspan='2'>
            <br />
            <input type='submit' name='Ncx_Admin_Login' value='Login' />
          </td>
        </tr>
      </div>
    </form>";
  }
//------------------------------------------------------------------------------------------------------------+
?>


