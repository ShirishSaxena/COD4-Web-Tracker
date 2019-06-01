<?php
ini_set('display_errors',0);
ini_set('display_startup_errors',1);
// error_reporting(-1);

	ini_set('max_execution_time', 300); 
	date_default_timezone_set("Asia/Kolkata");
	require 'Ncx_Functions.php';
if (!defined("NCX_ADMIN")) { exit("<font color='red'>Error</font>: Ask ShowY !!"); }

if (empty($_POST['IP']) && !empty($_POST['PORT']) && !empty($_POST['Type']) && !empty($_POST['id']))
{
	Ncx_Admin_IP_Delete($_POST['id'],$_POST['Type']);
}


if (!empty($_POST['IP']) && !empty($_POST['PORT']) && !empty($_POST['Type']) && !empty($_POST['id']))
{
	Ncx_Admin_IP_Update($_POST['IP'],$_POST['PORT'],$_POST['Type'],$_POST['id']);
}


if (!empty($_POST['IP']) && !empty($_POST['PORT']) && !empty($_POST['Type']) && empty($_POST['id']))
{
	Ncx_Admin_IP_Add($_POST['IP'],$_POST['PORT'],$_POST['Type']);
}

if (!empty($_POST['Server']) && !empty($_POST['Buyer']) && !empty($_POST['ID']) && !empty($_POST['IPPort']) && !empty($_POST['Slots'])  && !empty($_POST['Date'])  && !empty($_POST['Payment']))
{
Ncx_Admin_Billing_Update($_POST['Server'],$_POST['Buyer'],$_POST['ID'],$_POST['IPPort'],$_POST['Slots'],$_POST['Date'],$_POST['Payment']);
}

if (!empty($_POST['Server']) && !empty($_POST['Buyer']) && !empty($_POST['IPPort']) && !empty($_POST['Slots'])  && !empty($_POST['Date'])  && !empty($_POST['Payment']) && empty($_POST['ID']))
{
Ncx_Admin_Billing_Add($_POST['Server'],$_POST['Buyer'],$_POST['IPPort'],$_POST['Slots'],$_POST['Date'],$_POST['Payment']); 
}
if (empty($_POST['Server']) && !empty($_POST['Slots']) &&!empty($_POST['ID']) && !empty($_POST['Buyer']) && !empty($_POST['IPPort']) && !empty($_POST['Payment']) && !empty($_POST['Date']))
{
Ncx_Admin_Billing_Remove($_POST['IPPort'],$_POST['Buyer'],$_POST['ID'],$_POST['Payment']);
}

//ID Server(empty) Buyer Slots Date Payment IPP
//Payment & Date & Slots & IPP & Server & Buyer & ID

?>
<html>
  <head>
    <title>Ncx Admin Panel</title>
	 <script src='http://shirish.me/Ncx_Count.php'></script> 
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta http-equiv='content-style-type' content='text/css' />
    <link rel='stylesheet' href='Include/server_style/css/admin_style.css' type='text/css' />
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
input[name="Slots"] {
   width:32px;
}
input[name="Payment"] {
   width:45px;
}
#rounded-corner
{
	font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
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
  <body>
<center>
		<?php

		if ($Ncx['admin']['Billing'] == 1)
		{
			if (!empty($_GET['q']))
			{
				if ( $_GET['q'] == 'payment' )
				{
				echo "<p align='right'>Currently On : <font color='green'>Payment/Billing List</font></p>";
				echo "<center><font size=2>Go to : <a href='?q=1'>Server Billing Notification Management</a></font>";
				echo "<center><font size=2>Go to : <a href='admin.php'>Server Tracker List Management</a></font>";
				echo "<br>";
				echo "<br>";
				echo "</center>";
				Ncx_List_();
				}
				else
				{
					echo "<p align='right'>Currently On : <font color='green'>Server Billing Notification Management</font></p>";
					echo "<center><font size=2>Go to : <a href='admin.php'>Server Tracker List Management</a></font>";
					echo "<center><font size=2>Go to : <a href='?q=payment'>Payment/Billing List</a></font>";
					echo "<br>";
					echo "<br>";
					if (!empty($Add_Billing)){ echo "<br>"; echo $Add_Billing; echo "<br>"; }
					if (!empty($Delete_Billing)){ echo $Delete_Billing; echo "<br>"; }
					if (!empty($Update_Billing)){ echo $Update_Billing; echo "<br>"; }
					echo "</center>";
					Ncx_Admin_Billing();
					ShowY();
				}
			}
			else
			{
				echo "<p align='right'>Currently On : <font color='green'>Server Tracker List Management</font></p>";
				echo "<center><font size=2>Go to : <a href='?q=1'>Server Billing Notification Management</a></font>";
				echo "<center><font size=2>Go to : <a href='?q=payment'>Payment/Billing List</a></font>";
				echo "<br>";
				echo "<br>";
				if (!empty($Add_Tracker)){ echo "<br>"; echo $Add_Tracker; echo "<br>"; }
				if (!empty($Delete_Tracker)){ echo $Delete_Tracker; echo "<br>"; }
				if (!empty($Update_Tracker)){ echo $Update_Tracker; echo "<br>"; }
				echo "</center>";
				Ncx_Admin_List();
				ShowY();
			}

		}
		else
		{
				echo "<p align='right'>Currently On : <font color='green'>Server Tracker List Management</font></p>";
				echo "<br>";
				echo "<br>";
				if (!empty($Add_Tracker)){ echo "<br>"; echo $Add_Tracker; echo "<br>"; }
				if (!empty($Delete_Tracker)){ echo $Delete_Tracker; echo "<br>"; }
				if (!empty($Update_Tracker)){ echo $Update_Tracker; echo "<br>"; }
				echo "</center>";
				echo "<center>";
				Ncx_Admin_List();
				echo "</center>";
				ShowY();
				
		}
		
		?>
	</center> 	
  </body>
</html>

