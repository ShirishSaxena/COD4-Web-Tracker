<?php

ini_set('display_errors','Off');
$start_time = microtime(TRUE);

function Advanced($main)
{
	echo "<font color=black>$main : </font>";
}

function Human_Time($time,$ID)
{
	$LT = "<script type='text/javascript'>new CountUp('$time','$ID');</script>";
	return $LT;
}

if (empty($_GET[ip]) ) 
{
	echo "Error : Can't Parse IP Address";
}
else
{
	$IPPORT=$_GET['ip'];
	
	
	$b="<font color=black>";
	$B="</font>";	
	
	list($ip, $port) = explode(':', $IPPORT);
	require_once '../Include/Setup.php';
	$con = mysqli_connect($Database_Address, $Database_User, $Database_Password, $Database_Name);
	$result = mysqli_query($con,"SELECT * FROM $Table_Name WHERE ipport ='$ip:$port'");
	if(mysqli_num_rows($result) > 0)
	{
		$TotalSeen_PInfo = mysqli_query($con,"SELECT * FROM $PlayerInfo_Table WHERE lastseen ='$ip:$port'");
		$TotalPLSeen =  mysqli_num_rows($TotalSeen_PInfo);
		 
		 
		$Get_Uptime = mysqli_query($con,"SELECT * FROM $Uptime_Table WHERE ipport ='$ip:$port'");
		$Get_Uptime = mysqli_fetch_array($Get_Uptime);
		$row = mysqli_fetch_array($result);
		// MySQL Connection Closing	
		mysqli_close($con);
		// Connection Closed
		$UPTIME = $Get_Uptime['up_date'];

		$Array1 = $row['array1'];
		$list_Players = $row['list_players'];
		$Status = $row['status'];
		$Advance_Info = $row['advance'];
		$mtime = $row['time'];

		list($Pass, $Version, $Flood, $Anonymous, $ClientConsole, $MaxPing, $MinPing, $MaxRate, $PrivateClients, $PB, $Pure, $Voice, $ui_maxclients, $Uptime, $ComPassShowEnemies, $Mod, $fs, $_game) = explode('/', $Array1);
		$fs_game = "$fs/$_game";
		$Private=$PrivateClients;
		/////////////////////////////////////
			if ($PB == 1) 
			{ 
				$PB = "<font color=green>Enable</font>";
			}
			else
			{
				$PB = "<font color=red>Disable</font>";
			}
		/////////////////////////////////////	
			if ($PrivateClients == 0)
			{ 
				$PrivateClients = ""; 
			}
			else 
			{ 
				$Private_Show = "$b Private Clients :$B <font color='red'>$PrivateClients</font> <br>";
				$PrivateClients=$Private; 
			}
		/////////////////////////////////////
			if ($Version == "v1.7a") 
			{ 
				$Version == "v1.7a ( Anti-Block )"; 
			}
		/////////////////////////////////////
			if ($Pass == 1)
			{ 
				$Pass = "<font color='red'>Yes</font>"; 
			}
			else
			{
				$Pass = "<font color='green'>No</font>"; 
			}
		/////////////////////////////////////
			if ( $Status == 1 )
			{ 
				$Status = "<font color=green>Online</font>"; 
			}
			else 
			{ 
				$Status = "<font color=red>Offline</font>";
			}
		/////////////////////////////////////


			$time = strtotime($mtime);
			$Time_Scanned = Human_Time($mtime,'Time_Scanned');
			$Time_Uptime = Human_Time($UPTIME,'Time_Uptime');
			$Time_Scanned1 = Human_Time($mtime,'Time_Scanned1');
			$Time_Uptime1 = Human_Time($UPTIME,'Time_Uptime1');
			$Time_Scanned2 = Human_Time($mtime,'Time_Scanned2');
			$Time_Uptime2 = Human_Time($UPTIME,'Time_Uptime2');
			
			$Players = $row['online_players'];
			$Max_Slots = $row['max_slots'] + $PrivateClients ;
			$Players = "$Players/$Max_Slots";
echo "
<!doctype html>
<html lang='en'>
<head>
	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>

	<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
	<link rel='stylesheet' href='../Include/server_style/css/reset.css'> <!-- CSS reset -->
	<link rel='stylesheet' href='../Include/server_style/css/style.css'> <!-- Resource style -->
			<style>
				.timeee 
				{ 
					color:red;
					font-size: 13px;
					font-family: Avant Garde,Avantgarde,Century Gothic,CenturyGothic,AppleGothic,sans-serif; 
				}
				.ago 
				{ 
					color:black;
					font-size: 13px;
					font-family: Avant Garde,Avantgarde,Century Gothic,CenturyGothic,AppleGothic,sans-serif; 
				}
				.time_uptime
				{ 
					color:gray;
					font-size: 13px;
					font-family: Avant Garde,Avantgarde,Century Gothic,CenturyGothic,AppleGothic,sans-serif; 
				}
			</style>
			<script type='text/javascript' src='../Include/server_style/js/jquery.min.js'></script>
			<script type='text/javascript' src='../Include/server_style/js/null_check.js'></script>
			<script type='text/javascript' src='../Include/server_style/js/jquery.timeago.js'></script>
			<script>
				jQuery(document).ready(function() {
				jQuery('.demo_class').timeago();
				});
			</script>
			<script>
    $(document).ready(function() {
        // SET AUTOMATIC PAGE RELOAD TIME TO 5000 MILISECONDS (5 SECONDS).
        setInterval('refreshPage()', 90000);
    });

    function refreshPage() { 
        location.reload(); 
    }
</script>
	
	<script src='../Include/server_style/js/modernizr.js'></script> <!-- Modernizr -->
		<title>Server Details : $ip:$port</title>
</head>
<body>
<div class='cd-tabs'>
	<nav>
		<ul class='cd-tabs-navigation'>
			<li><a data-content='Main' class='selected' href='#Server_Info'>Server Info</a></li>
			<li><a data-content='Advanced' href='#Advanced_Info'>Advanced Info</a></li>
			<li><a data-content='PlayersInfo' href='#Player_Info'>Players Info</a></li>
		</ul> <!-- cd-tabs-navigation -->
	</nav>
<ul class='cd-tabs-content'>
	<li data-content='Main' class='selected'>
	<p align='right'>
	$b Last Scanned :$B <a id='Time_Scanned' class='timeee'><font color=red>Unknown</font></a> <a class='ago'>ago</a><br>
	$b Uptime :$B <a id='Time_Uptime' class='time_uptime'><font color=red>Unknown</font></a><br>
	$b Status :$B $Status
	</p>
	<p>
	$b Server Name :$B $row[server] <br>
	$b Players :$B $Players <br>
	$Private_Show
	$b Map :$B $row[mapname] <br>
	$b Gametype :$B $row[gametype] <br>
	$b PunkBuster :$B $PB <br>
	$b Version :$B $Version <br>
	$b Password :$B $Pass <br> <br>
	$b Total Players Last Played :$B $TotalPLSeen <br>
	</p>
	</li>
<li data-content='Advanced'>
	<p align='right'>
	$b Last Scanned :$B <a id='Time_Scanned1' class='timeee'><font color=red>Unknown</font></a> <a class='ago'>ago</a><br>
	$b Uptime :$B <a id='Time_Uptime1' class='time_uptime'><font color=red>Unknown</font></a><br>
	$b Status :$B $Status
	</p>
	<center> $Advance_Info </center>
</li>
<li data-content='PlayersInfo'>
	<p align='right'>
	$b Last Scanned :$B <a id='Time_Scanned2' class='timeee'><font color=red>Unknown</font></a> <a class='ago'>ago</a><br>
	$b Uptime :$B <a id='Time_Uptime2' class='time_uptime'><font color=red>Unknown</font></a><br>
	$b Status :$B $Status
	</p>
<center> $list_Players </center>
</li>
</ul> 
</div> 

<script src='../Include/server_style/js/main.js'></script> <!-- Resource jQuery -->"; 
		echo $Time_Scanned;
		echo $Time_Uptime;
		echo $Time_Scanned1;
		echo $Time_Uptime1;
		echo $Time_Scanned2;
		echo $Time_Uptime2;
}	
	else 
	{
		echo "<center><font color='red'>Err.. </font> IP Not in Database !!</center>";
	}

}
?>
<?php
$end_time = microtime(TRUE);

$time_taken = $end_time - $start_time;

$time_taken = round($time_taken,5);

if ( $time_taken >= 1 )
{
	echo '<center>Page generated in '.$time_taken.' seconds.</center>';
}
	echo "<center><a href='../'>Back to Server List</a></center>";
?>
</body>
</html>