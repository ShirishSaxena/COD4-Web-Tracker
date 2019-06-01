<?php
$start_time = microtime(TRUE);
?>
<div class="table-title">
<h3>NcxHost Server List</h3>
</div>
<table class="table-fill">
<thead>
<tr>
<th class="text-left"><a href='?s=server'>Server Name</a></th>
<th class="text-left"><a href='?s=players'>Players</a></th>
<th class="text-left"><a href='?s=map'>Server Map</a></th>
<th class="text-left"><a href='?s=gt'>Gametype</a></th>
<th class="text-left"><a href='?s=ip'>IP:Port</a></th>

</tr>
</thead>
<tbody class="table-hover">
<?php
ini_set('display_errors','Off');
function Get($SortBy,$DecInc)
{
	$sql = "";  
	require_once 'Include/Setup.php';
	$con = mysqli_connect($Database_Address, $Database_User, $Database_Password, $Database_Name);
// Check connection
	if (mysqli_connect_errno()) 
	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$query="select id from $Table_Name order by id asc";
	$res    = mysqli_query($con,$query);
	$count  = mysqli_num_rows($res);

	$Total_Server = "select id from $IP_Table order by id asc";
	$Total_Server = mysqli_query($con,$Total_Server);
	$Total_Server = mysqli_num_rows($Total_Server);

	$Image = mysqli_query($con,"SELECT * FROM $Table_Name WHERE status ='1'");
	$Server_Online = mysqli_num_rows($Image);
	
	while($row = mysqli_fetch_array($Image)) 
	{
					$Total_Slots += $row['max_slots'];
					$Online_Players += $row['online_players'];
	}
	$page = (int) (!isset($_REQUEST['pageId']) ? 1 :$_REQUEST['pageId']);
	$page = ($page == 0 ? 1 : $page);
	$recordsPerPage = 9;
	$start = ($page-1) * $recordsPerPage;
	$adjacents = "2";

	$prev = $page - 1;
	$next = $page + 1;
	$lastpage = ceil($count/$recordsPerPage);
	$lpm1 = $lastpage - 1;   
	$pagination = "";

	if($lastpage > 1)
		{   
			$pagination .= "<div class='pagination'>";
			if ($page > 1)
				$pagination.= "<a href=\"#Page=".($prev)."\" onClick='changePagination(".($prev).");'>&laquo; Previous&nbsp;&nbsp;</a>";
			else
				$pagination.= "<span class='disabled'>&laquo; Previous&nbsp;&nbsp;</span>";   
			if ($lastpage < 7 + ($adjacents * 2))
			{   
				for ($counter = 1; $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class='current'>$counter</span>";
					else
						$pagination.= "<a href=\"#Page=".($counter)."\" onClick='changePagination(".($counter).");'>$counter</a>";     
	 
				}
			}   
 
	elseif($lastpage > 5 + ($adjacents * 2))
        {
            if($page < 1 + ($adjacents * 2))
            {
                for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                {
                    if($counter == $page)
                        $pagination.= "<span class='current'>$counter</span>";
                    else
                        $pagination.= "<a href=\"#Page=".($counter)."\" onClick='changePagination(".($counter).");'>$counter</a>";     
                }
                $pagination.= "...";
                $pagination.= "<a href=\"#Page=".($lpm1)."\" onClick='changePagination(".($lpm1).");'>$lpm1</a>";
                $pagination.= "<a href=\"#Page=".($lastpage)."\" onClick='changePagination(".($lastpage).");'>$lastpage</a>";   
 
           }
	elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
           {
               $pagination.= "<a href=\"#Page=\"1\"\" onClick='changePagination(1);'>1</a>";
               $pagination.= "<a href=\"#Page=\"2\"\" onClick='changePagination(2);'>2</a>";
               $pagination.= "...";
               for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
               {
                   if($counter == $page)
                       $pagination.= "<span class='current'>$counter</span>";
                   else
                       $pagination.= "<a href=\"#Page=".($counter)."\" onClick='changePagination(".($counter).");'>$counter</a>";     
               }
               $pagination.= "..";
               $pagination.= "<a href=\"#Page=".($lpm1)."\" onClick='changePagination(".($lpm1).");'>$lpm1</a>";
               $pagination.= "<a href=\"#Page=".($lastpage)."\" onClick='changePagination(".($lastpage).");'>$lastpage</a>";   
           }
	else
           {
               $pagination.= "<a href=\"#Page=\"1\"\" onClick='changePagination(1);'>1</a>";
               $pagination.= "<a href=\"#Page=\"2\"\" onClick='changePagination(2);'>2</a>";
               $pagination.= "..";
               for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
               {
                   if($counter == $page)
                        $pagination.= "<span class='current'>$counter</span>";
                   else
                        $pagination.= "<a href=\"#Page=".($counter)."\" onClick='changePagination(".($counter).");'>$counter</a>";     
               }
           }
        }
        if($page < $counter - 1)
            $pagination.= "<a href=\"#Page=".($next)."\" onClick='changePagination(".($next).");'>Next &raquo;</a>";
        else
            $pagination.= "<span class='disabled'>Next &raquo;</span>";
 
        $pagination.= "</div>";       
    }
	if(isset($_POST['pageId']) && !empty($_POST['pageId']))
	{
		$id=$_POST['pageId'];
	}
	else
	{
		$id='0';
	}
	
	
	$query="select * from $Table_Name order by $SortBy $DecInc limit ".mysqli_real_escape_string($con,$start).",$recordsPerPage";
	//echo $query;
	$res    =   mysqli_query($con,$query);
	$count  =   mysqli_num_rows($res);
	$HTML='';
	if($count > 0)
	{
		$con_country = mysqli_connect($Database_Address, $Database_User, $Database_Password, $Database_Name);
		while($row=mysqli_fetch_array($res))
		{
			$Array1 = $row['array1'];
			list($Pass, $Version, $Flood, $Anonymous, $ClientConsole, $MaxPing, $MinPing, $MaxRate, $PrivateClients, $PB, $Pure, $Voice, $ui_maxclients, $Uptime, $ComPassShowEnemies, $Mod, $fs, $_game) = explode('/', $Array1);
			if ($Pass == 1){ $Pass = "<img src='Include/server_style/img/lock.gif'>"; }else {$Pass = ""; }
			if ($PB == 1) { $PB = "<img height=15px width=15px src='Include/server_style/img/pb.png'>";}else{$PB = "";}
			$Max_Slots = $row['max_slots']+$PrivateClients;
			
			/////////////////////////
			
			$IPPORT = explode(":", $row[ipport]);
			
			$result_coun = mysqli_query($con,"SELECT * FROM $IP_Table WHERE ip ='$IPPORT[0]'");
			while( $row_country = mysqli_fetch_array($result_coun) )
			{
				$IPPORT_Flag = $row_country[CLoc];
			}

			
			$IPPORT_Flag = "<img height=10px width=15px src='Include/server_style/flags/$IPPORT_Flag.png' title='$IPPORT_Flag'>";
			echo "<tr>
		<td class='text-left'><a href='server/$row[ipport]'>$row[server]</a> $IPPORT_Flag</td>
				  <td class='text-left'>$row[online_players]/$Max_Slots $Pass $PB</td>
				  <td class='text-left'>$row[mapname]</td>
				  <td class='text-left'>$row[gametype]</td>
				  <td class='text-left'>$row[ipport]</td>
				  </tr>";
		}
	}
	else
	{
		$HTML='<center>No Data Found</center>';
	}

	
	$Offline = $Total_Server - $Server_Online;
	$Offline = str_replace("-","",$Offline);

	echo "</tbody>
	</table>";
	echo $pagination;
	echo $HTML;
	echo "<br><center>";
	echo "<font color=white> Total Servers   : $Total_Server<br> Servers Online  : $Server_Online<br> Servers Offline : $Offline<br> Online Players  : $Online_Players<br> Total Slots     : $Total_Slots</font>";
	echo "</center>";
}

if(empty($_GET[s]))
{
Get('online_players','desc');
}
elseif ( $_GET[s] == 'server' )
{ Get('server','asc'); }
elseif ( $_GET[s] == 'players' )
{ Get('online_players','desc'); }
elseif ( $_GET[s] == 'gt' )
{ Get('gametype','asc'); }
elseif ( $_GET[s] == 'map' )
{ Get('mapname','asc'); }
elseif ( $_GET[s] == 'ip' )
{ Get('ipport','asc'); }
?>
<?php
$end_time = microtime(TRUE);

$time_taken = $end_time - $start_time;

$time_taken = round($time_taken,5);

if ( $time_taken >= 1 )
{
	echo '<br><center>Page generated in '.$time_taken.' seconds.</center>';
}
?>