
<?php

session_start();
  require_once "db.php";
  include("functions.php");
  $user_data = check_login($conn);


?>
<html>

<head>
<title>plus2net.com: Data Marix to update data table</title>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>

</head>
<body>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>ORHL Player Registration</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="_registration_style.css" />
</head>

<body>


	<div class="Wrapper">
		<div class="Response" style="display:none;">
			<div class="ResponseInner">
				<span id="lblResponse" class="Notification"></span>
				<button id="btnClear" class="ButtonNormal">OK</button>
			</div>
		</div>

		<div class="Header">
			<div class="Logo">
				<img src="https://lirp-cdn.multiscreensite.com/dfb474a2/dms3rep/multi/opt/ORHL_Logo_M-1920w.png" class="ImgLogo" />
			</div>
			<div class="Banner">
				<h1>ORHL Player &amp; Coach Registration<br />2022-23 Season</h1>
			</div>
			<div class="ClearAll100"></div>
		</div>
		<div class="MainBody">
			<div class="Title">
				<h2>Players list</h2>
			
			</div>

you want to add Users?<a href="player-registration.php" class="mt-3">Click Here</a><br><br>
<div id=msg_display></div><div id=msg_display></div>

<table class="Wrapper">
	<tr>
		<th>&nbsp;</th>
		<th>Update Ins Stat</th>
		<th>Update Approval</th>
		<th>Reg Date</th>
		<th>Player</th>
		<th>Team Name</th>
		<th>Position</th>
		<th>Division</th>
		<th>DOB</th>
		<th>Jersey</th>
		<th>Insur Status</th>
		<th>Apprv</th>
		<th>&nbsp;</th>
	</tr>

	<?php
          $query = "SELECT *, if( ForwardedToInsurance='1','checked','') as ForwardedToInsurance,if( Approved='1','checked','') as Approved FROM player_registrations";
          $result_tasks = mysqli_query($conn, $query);    

          while($row = mysqli_fetch_assoc($result_tasks)) { 
			
         echo " <tr>
			<td><a href=player-registration_edit.php?id=$row[ID] >Edit</a></td>
			<td><input type=checkbox  data-column_name='ForwardedToInsurance' data-id='$row[ID]' $row[ForwardedToInsurance]></td>
			
			<td><input type=checkbox  data-column_name='Approved' data-id='$row[ID]' $row[Approved]></td>"?>
			
			<td><?php echo $row['Created']; ?></td>
            <td><?php echo $row['FirstName'].' '.$row['LastName']; ?></td>
			<td><?php echo $row['Team']; ?></td>
			<td><?php echo $row['PlayerPosition']; ?></td>
			<td><?php echo $row['Division']; ?></td>
            <td><?php echo $row['DOB']; ?></td>
            <td><?php echo $row['JerseyNumber']; ?></td>
			
			<td> <?php $var= $row['ForwardedToInsurance'];
			 echo  ($var =='checked' ? 'Yes': 'No');?> </td>
			 <td> <?php $var= $row['Approved'];
			 echo  ($var =='checked' ? 'Yes': 'No');?> </td>
            
			<td><a href="player-registration_delete.php?idd=<?php echo $row["ID"]; ?>" class="link"><span name="delete" id="delete" title="Delete" onclick="return confirm('Are you sure you want to delete?')" src="icon/delete.png">Delete</span></a></td>
		
		
		
       
    
          </tr>
          <?php } ?>
	
</table>
</div>
<script>

function DeleteConfirm() {
                    confirm("Are you sure to delete the record");
                  }
$(document).ready(function() {
////////////////////	
$('input[type="checkbox"]').change(function(){
var column_name=$(this).data('column_name');
var id=$(this).data('id');
$.post( "data-matrixck.php", {"column_name":$(this).data('column_name'),"id":$(this).data('id')},function(return_data,status){
$("#msg_display").html(return_data);
$("#msg_display").show();
$("#msg_displa").html(return_data);
setTimeout(function() { $("#msg_display").fadeOut('slow'); }, 5000);
$("#msg_display").html(return_data);
$("#divid").load(" #divid");


location.reload();

 $(document).ajaxStop(function() {
        setInterval(function() {
            location.reload();
        }, 3000);
    });
});
});
//////////////////////////
});
</script>


</body>

</html>