<?php 

// cp1 : 50000
error_reporting(E_ALL);

function Send( $servername, $data, $mail, $buyer, $id ) {
	$subject = "Payment Alert : $buyer [ ID : $id ] "; // Subject of your email
	$to = "$mail";  //Recipient's E-mail

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= "From: Payment Alert [NcxHost] <tracker@ncxhost.com> \r\n"; // Sender's E-mail
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	
	$message .= $data;

	if (@mail($to, $subject, $message, $headers))
	{
		// Transfer the value 'sent' to ajax function for showing success message.
		echo '<br>';
		echo "<center>Mail Sent : $mail</center>";
		echo '<br>';
		echo "<center>For Server : $servername</server></center>";
	}
	else
	{
		// Transfer the value 'failed' to ajax function for showing error message.
		echo '<br>';
		echo "<center>Sending Mail Failed : $mail</center>";
		echo '<br>';
		echo "<center>For Server : $servername</server></center>";
	}
}
$css='/* ------------------
 styling for the tables 
   ------------------   */


body
{
	line-height: 1.6em;
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
	padding: 8px;
	background: #e8edff;
	border-top: 1px solid #fff;
	color: #669;
}
#rounded-corner tbody tr:hover td
{
	background: #d0dafd;
}';
// Check connection
require_once 'Setup.php';
$con = mysqli_connect($Database_Address, $Database_User, $Database_Password, $Database_Name);
$today=date('d'); //Day of the month, 2 digits with leading zeros
$tomorrow=$today+1;
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM $Ncx['admin']['SQL']");

while($row = mysqli_fetch_array($result)) {
	if ( $today == $row['maildate'] )
	{
	$buyer=$row['buyer'];
	$data="<html>
	<head>
	<style type='text/css'>
	$css
	</style>
	</head>
	<body>
	Hello,
	This is automatic generated email. Please do not reply.
	<br>
	This is an alert to tell you that Today is Last date for Payment of : <font color='red'>$row[server]</font> <br>
	<br>
	Below you'll find all details you need to examine server
	<br>
	<br>
	<center>
<table id='rounded-corner' summary='Last Payment Alert' style='font-family: &quot;Lucida Sans Unicode&quot;, &quot;Lucida Grande&quot;, Sans-Serif;font-size: 12px;margin: 45px;width: 480px;text-align: left;border-collapse: collapse;'>
		<thead>
			<tr>
                 <th scope='col' class='rounded-company' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'>ID</th>
				 <th scope='col' class='rounded-q2' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'>Server name</th>
				<th scope='col' class='rounded-q2' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'>Buyer Name</th>
				<th scope='col' class='rounded-q2' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'>Slots</th>
				<th scope='col' class='rounded-q2' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'>IP:Port</th>
				<th scope='col' class='rounded-q2' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'>Date</th>
				<th scope='col' class='rounded-q4' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'>Payment</th>
			</tr>
		</thead>
		<tbody>
			<tr>
			<td style='padding: 8px;background: #e8edff;border-top: 1px solid #fff;color: #669;'>$row[id]</td>
			<td style='padding: 8px;background: #e8edff;border-top: 1px solid #fff;color: #669;'>$row[server]</td>
			<td style='padding: 8px;background: #e8edff;border-top: 1px solid #fff;color: #669;'>$buyer</td>
			<td style='padding: 8px;background: #e8edff;border-top: 1px solid #fff;color: #669;'>$row[slots]</td>
			<td style='padding: 8px;background: #e8edff;border-top: 1px solid #fff;color: #669;'>$row[ipport]</td>
			<td style='padding: 8px;background: #e8edff;border-top: 1px solid #fff;color: #669;'>$row[date]</td>
			<td style='padding: 8px;background: #e8edff;border-top: 1px solid #fff;color: #669;'>$row[payment]</td>
			</tr></tbody>
	</table>
	</center> 	
	Please make the payment as soon as possible !!<br>
	If <font color='red'>$buyer</font> doesn't make payment today then You should remove his Server by <a href='http://shirish.me/Me/ncxhost/remove.php'>Clicking Here</a>
		<br>
	For Your Information Tables not supported in Gmail<br>
	Thank You !	";
    $server="$row[server] | ID : $row[id]";
	Send( $server, $data, 'shirish1997@gmail.com',$buyer, $row['id'] );  

	}
	if ( $row['maildate'] != $today )
	{ echo "Today is not the Date : $row[server] || $row[id]<br>";}
}
mysqli_close($con);
?>