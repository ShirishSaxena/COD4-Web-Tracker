<?php

ini_set('max_execution_time', 300); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set("Asia/Kolkata");


$start_time = microtime(TRUE);

error_reporting(E_ALL);
// Check connection

function COD_Replace($main)
{
$main = str_replace("^0","",$main);
$main = str_replace("^1","",$main);
$main = str_replace("^2","",$main);
$main = str_replace("^3","",$main);
$main = str_replace("^4","",$main);
$main = str_replace("^5","",$main);
$main = str_replace("^6","",$main);
$main = str_replace("^7","",$main);
$main = str_replace("^8","",$main);
$main = str_replace("^9","",$main);
$main = str_replace("'","",$main);
return $main;
}

function GetServerStatus($site, $ipport)
{
require 'Setup.php';
$ipp = "$site:$ipport";
$port = $ipport;
$con = mysqli_connect($Database_Address, $Database_User, $Database_Password, $Database_Name);
$fp = @fsockopen($site, $port, $errno, $errstr, 2);
	if (!$fp) {
	// Offline
	$Del = "DELETE FROM $Table_Name WHERE ipport='$ipp'";
	mysqli_query($con, $Del);
	echo "<br>Main Server Offline : $ipp";
	}
}
function print_results($results) {

    foreach ($results as $id => $data) 
	{
        print_table($data);
    }

}

function print_table($data) {

    $gqs = array('gq_online', 'gq_address', 'gq_port', 'gq_prot', 'gq_type');


    if (!$data['gq_online']) {
        printf("<p>The server did not respond within the specified time.</p>\n");
        return;
    }

    echo '<table cellspacing=0><tr><th>Variable</th><th>Value</th></tr>';

    foreach ($data as $key => $val) 
	{
        if (is_array($val)) continue;
		$key = str_replace("gq","<font color=red>Ncx</font>",$key);
		$val = COD_Replace($val);
        printf("<tr><td>%s</td><td>%s</td></tr>\n", $key, $val);
    }

    print("</tbody></table>\n");

}

function OnlinePlayers($OnlinePlayers,$IPPORT)
{
	require 'Setup.php';
	$con = mysqli_connect($Database_Address, $Database_User, $Database_Password, $Database_Name);
	echo '<table cellspacing=0><tr><th>Player Name</th><th>Score</th><th>Ping</th></tr>';
	rsort($OnlinePlayers);
	foreach ($OnlinePlayers as $row) 
	{
		$Player_Name = COD_Replace($row['nick']);
		$Check_PlayerStatus=mysqli_query($con,"SELECT * FROM $PlayerInfo_Table WHERE pname ='$Player_Name'");
		$time=time();
		$mtime=date("c", $time);
		if(mysqli_num_rows($Check_PlayerStatus) > 0)
		{
			$query="UPDATE $PlayerInfo_Table SET lastseen='$IPPORT', lastupdated = '$mtime', tscore = tscore+$row[frags] WHERE pname = '$Player_Name'";
			mysqli_query($con, $query);
		}
		else
		{
			$query="INSERT INTO $PlayerInfo_Table(pname,lastseen,lastupdated,tscore) VALUES( '$Player_Name', '$IPPORT', '$mtime','$row[frags]' )";
			mysqli_query($con, $query);
		}
		
		echo "<tr class=even><td>$Player_Name</td><td>$row[frags]</td><td>$row[ping] ms</td></tr>";
	}
echo '</table>';
}

require_once 'Main.php';

function Get_Data($ip,$port)
{
	
	require 'Setup.php';
	$con = mysqli_connect($Database_Address, $Database_User, $Database_Password, $Database_Name);

	$servers[$ip] = array('quake3', $ip,$port);

	// Initialize the class
	$gq = new GameQ;

	// Add the servers we just defined
	$gq->addServers($servers);

	// these will be applied to the results obtained.
	$gq->setFilter('normalise');
	$gq->setFilter('sortplayers', 'gq_ping');

	// You can optionally specify some settings
	$gq->setOption('timeout', 500);

	// Request the data, and display it
	try {
		$data = $gq->requestData();
		$Status=$data[ $ip ]['gq_online'];
		$Filtered_IP =  $data[ $ip ][ 'gq_address' ] ;		
		$Filtered_Port =  $data[ $ip ][ 'gq_port' ] ;
		$ipp = "$Filtered_IP:$Filtered_Port";
		require 'Setup.php';
		if ( $Status != 0 )
		{
			$host =  $data[ $ip ][ 'sv_hostname' ] ;
			$clients= $data[ $ip ][ 'gq_numplayers' ];
			$slots = $data[ $ip ][ 'sv_maxclients' ];
			
			$result = mysqli_query($con,"SELECT * FROM $Table_Name WHERE ipport ='$ipp'");
					$Players= "$clients/$slots";
					$Mapname= $data[ $ip ]['mapname'];
					$GameType= $data[ $ip ]['g_gametype'];

					$HostName = COD_Replace($host);
					
			////////////////////////////////////////////////////////////////////////////
			
					$time=time();
					$mtime=date("c", $time);
			
			
				    $OnlinePlayers=$data[ $ip ]['players'];
					if (empty($OnlinePlayers))
					{
					$Get_Online_Players="<table cellspacing=0><tr class=even><td>No Players</td><td>----</td><td>----</td></tr></table>";
					}
					else
					{
					ob_start();
					OnlinePlayers($OnlinePlayers,$ipp);
					$Get_Online_Players = ob_get_contents();
					ob_end_clean();
					}
			////////////////////////////////////////////////////////////////////////////
			
			
			$Uptime_Server = mysqli_query($con,"SELECT * FROM $Uptime_Table WHERE ipport ='$ipp'");
			if(mysqli_num_rows($Uptime_Server) > 0)
			{
			
			}
			else {
				$query="INSERT INTO $Uptime_Table(up_date,ipport) VALUES( '$mtime', '$ipp' )";
				 mysqli_query($con, $query);
						echo "<br>";
						echo "New Uptime Created : $ipp";
			}
			
			
			/* Array List 
			
						Pass/Version/Flood/Anonymous/ClientConsole/MaxPing/MinPing/MaxRate/PrivateClients/PB/Pure/Voice/ui_maxclients/Uptime/ComPassShowEnemies/Mod/fs_game
						
			*/
					$Version=$data[ $ip ][ 'shortversion' ];
					if (empty($data[ $ip ]['pswrd'])) { $Pass=0;} else { $Pass=$data[ $ip ]['pswrd']; }
					$Flood=$data[ $ip ]['sv_floodprotect'];
					if (empty($data[ $ip ]['sv_allowAnonymous'])){ $Anonymous = 0; }else{ $Anonymous=$data[ $ip ]['sv_allowAnonymous']; }
					
					$ClientConsole=$data[ $ip ]['sv_disableClientConsole'];
					$MaxPing=$data[ $ip ]['sv_maxPing'];
					$MaxRate=$data[ $ip ]['sv_maxRate'];
					$MinPing=$data[ $ip ]['sv_minPing'];
					if (empty($data[ $ip ]['sv_privateClients'])){ $PrivateClients = 0; }else{ $PrivateClients=$data[ $ip ]['sv_privateClients']; }
					
					if (empty($data[$ip]['sv_punkbuster'])) { $PB=0;} else {$PB=$data[ $ip ]['sv_punkbuster'];}
					
					$Pure=$data[ $ip ]['sv_pure'];
					$Voice=$data[ $ip ]['sv_voice'];
					
					if (empty($data[ $ip ]['ui_maxclients'])){ $ui_maxclients = 0; }else{ $ui_maxclients=$data[ $ip ]['ui_maxclients']; }
					$ComPassShowEnemies=$data[ $ip ]['g_compassShowEnemies'];
					if(empty($data[ $ip ]['mod'])) { $Mod = 0; } else { $Mod=$data[ $ip ]['mod'];}
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					if (empty($PrivateClients)){$PrivateClients='0';}
					if (empty($Uptime)){$Uptime=0;}
					if (empty($ui_maxclients)){$ui_maxclients="32";}
					if (empty($Anonymous)){$Anonymous='0';}
					if ($Mod == 1 ){$fs_game=$data[ $ip ]['fs_game'];}else{$fs_game='No Mod';}
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					// Password / Version /
					$Array1= "$Pass/$Version/$Flood/$Anonymous/$ClientConsole/$MaxPing/$MinPing/$MaxRate/$PrivateClients/$PB/$Pure/$Voice/$ui_maxclients/$Uptime/$ComPassShowEnemies/$Mod/$fs_game";
		
					
			ob_start();
			print_results($data);
			$Advance_Var = ob_get_contents();
			ob_end_clean();

			if (empty($host) && empty($slots) )
				{
				echo "<br>";
				echo "Empty Hostname Or Slots Found : $ipp";
				}
			else
			{
				if ( strlen($host) >= 3 && $port != 0 )
			{
			if(mysqli_num_rows($result) > 0)
			{
					$query="UPDATE $Table_Name SET server='$HostName', players = '$Players', mapname = '$Mapname', gametype = '$GameType', status = '$Status', array1 = '$Array1', list_players = '$Get_Online_Players', time = '$mtime', advance = '$Advance_Var', online_players = '$clients', max_slots = '$slots' WHERE ipport = '$ipp'";
					mysqli_query($con, $query);
					echo "<br>";
					echo "Updated : $ipp { $HostName }";
			}
			else
				{
			$query="INSERT INTO $Table_Name(server, players, mapname, gametype, ipport, status, array1, list_players, time, advance, online_players, max_slots) VALUES( '$HostName', '$Players', '$Mapname', '$GameType', '$ipp', '$Status', '$Array1', '$Get_Online_Players', '$mtime', '$Advance_Var', '$clients', '$slots' )";
			 mysqli_query($con, $query);
					echo "<br>";
					echo "New Table Created : $ipp";
			 }
					
					}
				  }
					}
			elseif ( $Status == 0 )
			{
			$result = mysqli_query($con,"SELECT * FROM $Table_Name WHERE ipport ='$ipp'");
			if(mysqli_num_rows($result) > 0)
			{
			$query="UPDATE $Table_Name SET players = '0/0', status = '$Status', time = '$mtime' WHERE ipport = '$ipp'";
			mysqli_query($con, $query);
			echo "<br>";
			echo "Status Updated : $ipp";
			}
			$Del_Uptime = "DELETE FROM $Uptime_Table WHERE ipport='$ipp'";
			mysqli_query($con, $Del_Uptime);
			}
				}
	

	// Catch any errors that might have occurred
	catch (GameQ_Exception $e) {
		echo 'An error occurred.';
	}
}

require 'Setup.php';
$con = mysqli_connect($Database_Address, $Database_User, $Database_Password, $Database_Name);
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM $IP_Table");
while($row = mysqli_fetch_array($result)) {
		Get_Data($row['ip'],$row['port']);	
		GetServerStatus($row['ip'],$row['port']);
}
	mysqli_close($con);
?>
</tbody>
</table>
  


 
 <?php
$end_time = microtime(TRUE);

$time_taken = $end_time - $start_time;

$time_taken = round($time_taken,5);

echo '<br><br><br><center>Page generated in '.$time_taken.' seconds.</center>';
?>
   </body>