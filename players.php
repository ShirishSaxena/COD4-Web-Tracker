<html lang="en">
<head>
	<script type='text/javascript' src='Include/server_style/js/jquery.min.js'></script>
	<script type='text/javascript' src='Include/server_style/js/null_check.js'></script>
<link rel="stylesheet" href="Include/server_style/css/look.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style type='text/css'>
	a {
    text-decoration: none;
}
a:link, a:visited {
    color: gray;
}
a:hover {
    color: red;
}
div.pagination {
padding: 3px;
margin: 3px;
text-align:center;
}
 
div.pagination a {
padding: 2px 5px 2px 5px;
margin: 2px;
border: 1px solid #AAAADD;
 
text-decoration: none; /* no underline */
color: #000099;
}
div.pagination a:hover, div.digg a:active {
border: 1px solid #000099;
 
color: #000;
}
div.pagination span.current {
padding: 2px 5px 2px 5px;
margin: 2px;
border: 1px solid #000099;
 
font-weight: bold;
background-color: #000099;
color: #FFF;
}
div.pagination span.disabled {
padding: 2px 5px 2px 5px;
margin: 2px;
border: 1px solid #EEE;
 
color: #DDD;
}
	</style>
	<meta charset="utf-8" />
	<title>Player ListEE</title>
	<meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; width=device-width;">
</head>

<body>
<div class="table-title">
<h3>NcX Players ListEE</h3>
</div>
<center> <h2>Sort By ? : <a href="?sortby=asc">Ascending</a> | <a href="?sortby=desc">Decending</a></h2></center>
<table class="table-fill">
<thead>
<tr>
<th class="text-left"><a href="?order=pname">Player Name</a></th>
<th class="text-left"><a href="?order=tscore">Total Score</a></th>
<th class="text-left"><a href="?order=lastupdated">Last Updated</a></th>
<th class="text-left"><a href="?order=lastseen">Seen On</a></th>
</tr>
</thead>
<tbody class="table-hover">
<?php 
 

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}


if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$order = 'tscore';
if (isset($_GET['order'])) {
    $order = $_GET['order'];
}
$sortit = 'desc';

if (isset($_GET['sortby'])) {
    $sortit = $_GET['sortby'];
}

$no_of_records_per_page = 30;
$offset = ($pageno-1) * $no_of_records_per_page;

	require_once 'Include/Setup.php';
	$con = mysqli_connect($Database_Address, $Database_User, $Database_Password, $Database_Name);
// Check connection
	if (mysqli_connect_errno()) 
	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$total_pages_sql = "SELECT COUNT(*) FROM $PlayerInfo_Table";
	$result = mysqli_query($con,$total_pages_sql);
	$total_rows = mysqli_fetch_array($result)[0];
	$total_pages = ceil($total_rows / $no_of_records_per_page);
	
	
	$query="select * from $PlayerInfo_Table order by $order $sortit LIMIT $offset, $no_of_records_per_page";
	$res    = mysqli_query($con,$query);
	
	while($row = mysqli_fetch_array($res)) 
	{
		
		echo " <tr> <td class='text-left'> $row[pname] </td> ";
		echo " <td class='text-left'> $row[tscore] </td> ";
		echo " <td class='text-left'><font color=red>";echo time_elapsed_string($row[lastupdated]); echo "</font></a><br></td> ";
		echo " <td class='text-left'> $row[lastseen] </td> </tr>";
		
	}
?>

</tbody>
</table>
<center>
  <ul class="pagination">
    <h2 ><a href="?pageno=1"><font color=black>First</font></a></h2>
    <h2 class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
        <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>"><font color=black>Prev</font></a>
    </h2>
    <h2 class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
        <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>"><font color=black>Next</font></a>
    </h2>
    <h2><a href="?pageno=<?php echo $total_pages; ?>"><font color=black>Last</font></a></h2>
</ul>
</center>
<?php

$query1="select * from $PlayerInfo_Table order by id asc";
$res1    = mysqli_query($con,$query1);
$count  = mysqli_num_rows($res1);


echo "<center>Total Players : $count</center>";
?>
  </body>