<?php

function Get_Country_Code($ip)
{
		$url="https://ipinfo.io/$ip/country";
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
}
function Ncx_Admin_List()
{
require 'Include/Setup.php';
echo "<table id='rounded-corner' summary='Last Payment Alert' style='font-family: &quot;Lucida Sans Unicode&quot;, &quot;Lucida Grande&quot;, Sans-Serif;font-size: 12px;width: 35%;text-align: left;border-collapse: collapse;'>
		<thead>
			<tr>
              <th scope='col' class='rounded-company' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'><center>ID</center></th>
			  <th scope='col' class='rounded-q2' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'><center>Game Type</center></th>
			  <th scope='col' class='rounded-q2' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'><center>IP</center></th>
			  <th scope='col' class='rounded-q2' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'><center>Port</center></th>
			  <th scope='col' class='rounded-q4' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'><center>Management</center></th>
			</tr>
		</thead>
		<tbody>
			<tr>";
			$con = mysqli_connect($Database_Address, $Database_User, $Database_Password, $Database_Name);
			$result = mysqli_query($con,"SELECT * FROM $IP_Table");
			while($row = mysqli_fetch_array($result)) {
			if ( $row['type'] == "callofduty4" )
			{
			$option = "<option selected='selected' value='callofduty4'>Call Of Duty 4</option>
			<option  value='callofduty6'>Call Of Duty MW2</option>";
			}
			else
			{
			$option = "<option value='callofduty4'>Call Of Duty 4</option>
			<option selected='selected' value='callofduty6'>Call Of Duty MW2</option>";
			}
			$count += 1;
			  echo "<tr><form action='' method='post'>
			  <td><input name='id' type='hidden' value='$row[id]' />$count</td>
			  <td>
				<select name='Type'>
				$option
				</select>
			  </td>
			  <td style='text-align:center'><input type='text' name='IP' value='$row[ip]'  size='15' maxlength='255' /> $row[CLoc]</td>
			  <td style='text-align:center'><input type='text' name='PORT' value='$row[port]'  size='5'  maxlength='5'   /></td>
			  <td style='text-align:center'><input type='submit'></td>
			  <td>
			  </td>
			</form></tr>";
			}
			mysqli_close($con);		
	echo"<tr><form action='' method='post'>
          <td><font color='red'>New</font></td>
          <td>
            <select name='Type'>
			<option selected='selected' value='callofduty4'>Call Of Duty 4</option>
		<option  value='callofduty6'>Call Of Duty MW2</option>
            </select>
          </td>
		  <td style='text-align:center'><input type='text' name='IP' value=''  size='15' maxlength='255' /></td>
          <td style='text-align:center'><input type='text' name='PORT' value=''  size='5'  maxlength='5'   /></td>
		  <td style='text-align:center'><input type='submit'></td>
          <td>
          </td>
		</form></tr>
			</tbody>
	</table>";
}

function Ncx_List_()
{

require 'Include/Setup.php';
echo "<table id='rounded-corner' summary='Payment List' style='font-family: &quot;Lucida Sans Unicode&quot;, &quot;Lucida Grande&quot;, Sans-Serif;font-size: 12px;width: 70%;text-align: left;border-collapse: collapse;'>
		<thead>
			<tr>
			<th scope='col' class='rounded-company' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'><center>No.</center></th>
              <th scope='col' class='rounded-company' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'><center>Server Name</center></th>
			  <th scope='col' class='rounded-q2' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'><center>Buyer Name</center></th>
			  <th scope='col' class='rounded-q2' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'><center>IP:Port</center></th>
			  <th scope='col' class='rounded-q2' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'><center>Slots</center></th>
			  <th scope='col' class='rounded-q4' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'><center>Date</center></th>
			  <th scope='col' class='rounded-q4' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'><center>Payment</center></th>
			</tr>
		</thead>
		<tbody>
			<tr>";
			$con = mysqli_connect($Database_Address, $Database_User, $Database_Password, $Database_Name);
			$Billing_Ncx = $Ncx['admin']['SQL'];
			$result = mysqli_query($con,"SELECT * FROM $Billing_Ncx");
			$Total_Slots = mysqli_query($con,"SELECT sum(slots) as totalslots FROM $Billing_Ncx");
			while($row = mysqli_fetch_array($result)) 
			{
				$count += 1;
				
				echo "<tr>";
				echo "<td style='text-align:center'>$count</td>";
				echo "<td style='text-align:center'>$row[server]</td>";
				echo "<td style='text-align:center'>$row[buyer]</td>";
				echo "<td style='text-align:center'>$row[ipport]</td>";
				echo "<td style='text-align:center'>$row[slots]</td>";
				echo "<td style='text-align:center'>$row[date]</td>";
				echo "<td style='text-align:center'>$row[payment]</td>";
				echo "</tr>";

			}
			
			while ($row = mysqli_fetch_assoc($Total_Slots))
			{ 
			   $totalslots = $row['totalslots'];
			}
			$earn = $totalslots*50;
			echo "Total Slots : $totalslots  ||&nbsp;&nbsp;&nbsp;";
			echo "Total Earn : &#8377; $earn";
			
		mysqli_close($con);
			
}

function Ncx_Admin_Billing()
{
require 'Include/Setup.php';
echo "<table id='rounded-corner' summary='Last Payment Alert' style='font-family: &quot;Lucida Sans Unicode&quot;, &quot;Lucida Grande&quot;, Sans-Serif;font-size: 12px;width: 35%;text-align: left;border-collapse: collapse;'>
		<thead>
			<tr>
              <th scope='col' class='rounded-company' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'><center>ID</center></th>
			  <th scope='col' class='rounded-q2' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'><center>Server</center></th>
			  <th scope='col' class='rounded-q2' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'><center>Buyer</center></th>
			  <th scope='col' class='rounded-q2' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'><center>Slots</center></th>
			  <th scope='col' class='rounded-q2' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'><center>Date</center></th>
			  <th scope='col' class='rounded-q2' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'><center>Payment</center></th>
			  <th scope='col' class='rounded-q2' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'><center>IP:Port</center></th>
			  <th scope='col' class='rounded-q4' style='padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #b9c9fe;'><center>Management</center></th>
			</tr>
		</thead>
		<tbody>
			<tr>";
	
			$con = mysqli_connect($Database_Address, $Database_User, $Database_Password, $Database_Name);
			$Billing_Notification = $Ncx['admin']['SQL'];
			$query = "SELECT * FROM $Billing_Notification";
			$result = mysqli_query($con,$query);
			while($row = mysqli_fetch_array($result)) {
			 
			$count += 1;
			  echo "<tr><form action='' method='post'>
			  <td><input name='ID' type='hidden' value='$row[id]' />$count</td>
			  <td style='text-align:center'><input type='text' name='Server' value='$row[server]' size='80' maxlength='255' /></td>
			  <td style='text-align:center'><input type='text' name='Buyer' value='$row[buyer]' size='10' maxlength='50' /></td>
			  <td style='text-align:center'><input type='number' name='Slots' value='$row[slots]' size='2' maxlength='2' /></td>
			  <td style='text-align:center'><input type='text' name='Date' value='$row[date]' size='10' maxlength='50' /></td>
			  <td style='text-align:center'><input type='text' name='Payment' value='$row[payment]'  size='5' maxlength='10' /></td>
			  <td style='text-align:center'><input type='text' name='IPPort' value='$row[ipport]'  size='17'  maxlength='20'   /></td>
			  <td style='text-align:center'><input type='submit'></td>
			  <td>
			  </td>
			</form></tr>";
			}
			mysqli_close($con);		
		echo "<tr><form action='' method='post'>
			  <td><font color='red'>New</font></td>
			  <td style='text-align:center'><input type='text' name='Server' value='' size='80' maxlength='255' /></td>
			  <td style='text-align:center'><input type='text' name='Buyer' value='' size='10' maxlength='50' /></td>
			  <td style='text-align:center'><input type='number' name='Slots' value='' size='2' maxlength='2' /></td>
			  <td style='text-align:center'><input type='text' name='Date' value='' size='10' maxlength='50' /></td>
			  <td style='text-align:center'><input type='text' name='Payment' value=''  size='5' maxlength='10' /></td>
			  <td style='text-align:center'><input type='text' name='IPPort' value=''  size='17'  maxlength='20'   /></td>
			  <td style='text-align:center'><input type='submit'></td>
			  <td>
			  </td>
			</form></tr>
			</tbody>
	</table>";
	}
	function Ncx_Admin_IP_Add($IP,$Port,$Type)
		{
			global $Add_Tracker;
			require 'Include/Setup.php';
			$con = mysqli_connect($Database_Address, $Database_User, $Database_Password, $Database_Name);
			$What_Country = Get_Country_Code($IP);
			$sql="INSERT INTO $IP_Table (ip,port,type,CLoc) VALUES ('$IP','$Port','$Type','$What_Country')";
			mysqli_query($con,$sql);
			mysqli_close($con);
			$Add_Tracker = "<font color='green'>Server Added</font> || IP_Port : $IP:$Port | Type : $Type";
		}
		function Ncx_Admin_IP_Delete($id,$type)
		{
			global $Delete_Tracker;
			require 'Include/Setup.php';
			$con = mysqli_connect($Database_Address, $Database_User, $Database_Password, $Database_Name);
			$Del_Query = "DELETE FROM `$Database_Name`.`$IP_Table` WHERE `$IP_Table`.`id`=$id";
			mysqli_query($con,$Del_Query);
			mysqli_close($con);
			$Delete_Tracker = "<font color='red'>Deleted </font> || ID : $id | Type : $type";
		}
		function Ncx_Admin_IP_Update($ip,$port,$type,$id)
		{
			global $Update_Tracker;
			require 'Include/Setup.php';
			$What_Country = Get_Country_Code($ip);
			$con = mysqli_connect($Database_Address, $Database_User, $Database_Password, $Database_Name);
			$Query="UPDATE $IP_Table SET ip='$ip', port = '$port', type = '$type', CLoc = '$What_Country'  WHERE id = '$id'";
			mysqli_query($con,$Query);
			mysqli_close($con);
			$Update_Tracker = "<font color='yellow'>Updated </font> || ID : $id | Type : $type | IP:Port : $ip:$port";
		}
		function Ncx_Admin_Billing_Update($Server,$Buyer,$ID,$IPP,$Slots,$Date,$Payment)
		{
			global $Update_Billing;
			require 'Include/Setup.php';
			$Billing_Table = $Ncx['admin']['SQL'];
			$con = mysqli_connect($Database_Address, $Database_User, $Database_Password, $Database_Name);
			$Query="UPDATE $Billing_Table SET server='$Server', buyer = '$Buyer', payment = '$Payment', ipport = '$IPP', slots = '$Slots', date = '$Date' WHERE id = '$ID'";
			mysqli_query($con,$Query);
			mysqli_close($con);
			$Update_Billing = "<font color='yellow'>Updated </font> || ID : $ID | Server : $Server | IP:Port : $IPP | Buyer : $Buyer | Payment : $Payment";
		}
		
		function Ncx_Admin_Billing_Remove($IPP,$Buyer,$ID,$Payment) 
		{
			global $Delete_Billing;
			require 'Include/Setup.php';
			$Billing_Table = $Ncx['admin']['SQL'];
			$con = mysqli_connect($Database_Address, $Database_User, $Database_Password, $Database_Name);
			$Query = "DELETE FROM `$Database_Name`.`$Billing_Table` WHERE `$Billing_Table`.`id`=$ID";
			mysqli_query($con,$Query);
			mysqli_close($con);
			$Delete_Billing = "<font color='red'>Deleted</font> || ID : $ID | IP Port : $IPP | Buyer : $Buyer | Payment : $Payment";
		}
		function Ncx_Admin_Billing_Add($Server,$Buyer,$IPP,$Slots,$Date,$Payment)
		{
			global $Add_Billing;
			list($MailDate,$MailMonth,$MailYear) = explode('/', $Date);
			require 'Include/Setup.php';
			$Billing_Table = $Ncx['admin']['SQL'];
			$con = mysqli_connect($Database_Address, $Database_User, $Database_Password, $Database_Name);
			$Query = "INSERT INTO $Billing_Table (server,buyer,slots,ipport,date,payment,maildate) VALUES ('$Server','$Buyer','$Slots','$IPP','$Date','$Payment','$MailDate')";
			mysqli_query($con,$Query);
			mysqli_close($con);
			$Add_Billing = "<font color='green'>Server Added</font> || Server : $Server | Buyer : $Buyer | Payment : $Payment";
		}
function ShowY()
{
echo "<br>";
echo "<center>Created By : <a href='http://fb.com/shirishsaxena'><font color='green'>Mr</font><font color='white'>.</font><font color='red'>S</font><font color='green'>h</font><font color='blue'>o</font><font color='gray'>w</font><font color='green'>O</font><font color='white'>ff</font></a>";
}
	
	?>