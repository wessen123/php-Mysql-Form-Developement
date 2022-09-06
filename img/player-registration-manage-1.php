
<?php
require_once "db.php";
?>
	
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>ORHL Player Registration</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="css/_registration_style.css" />
<link rel="stylesheet" type="text/css" href="css/_style_2022.css" media="all" />

<script language="javascript">

function ShowHideMenu(strID){
	///show one selected
	var strCurrent = document.getElementById(strID).style.display;
	//hide all first
	document.getElementById("menuSubPlayers").style.display = "none";
	document.getElementById("menuSubTeams").style.display = "none";
	document.getElementById("menuSubGames").style.display = "none";
	
	if (!strCurrent || strCurrent == "none" || strCurrent == ""){
		document.getElementById(strID).style.display = "block";
	}
	else if(strCurrent == "block"){
		document.getElementById(strID).style.display = "none";
	}
	else{
		//hide if none are selected
		document.getElementById("menuSubPlayers").style.display = "none";
		document.getElementById("menuSubTeams").style.display = "none";
		document.getElementById("menuSubGames").style.display = "none";
	}
	
}

</script>

</head>

<body>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	

		<?php include '_main_menu.php';?>
			
		<div class="AdminMainBody">
			<div class="AdminTitle">
				<h2>Players list</h2>
				<div style="float:right; width:50%; margin:10pt 0 10pt 0; clear:both;">
					<strong>Select team or leave blank for all teams</strong>
					
					<!--
						#####################################
						1) set up the follow select list (name="TeamName") from database with following SQL statement
						
						SELECT TeamName FROM teams GROUP BY TeamName ORDER BY TeamName ASC 
						
						2) then loop through dataset and build the options as usual
						3) this list should only be created on original page load and be retained on each POST afterwards
						######################################
					-->
					
					<select id="ddlTeam" name="TeamName" class="AdminDropNormal">
						<option value="All">All...</option>
					</select>
					<input type="submit" value="Review" id="btnReview" name="review" class="ButtonNormal" />
				</div>
			</div>

			<table class="PlayerList">
				<tr>
					<th>&nbsp;</th>
					<th class="TextCenter">Update Ins Stat</th>
					<th class="TextCenter">Update Approval</th>
					<th>Reg Date</th>
					<th>Player</th>
					<th>Team Name</th>
					<th>Position</th>
					<th>Division</th>
					<th>DOB</th>
					<th class="TextCenter">Jersey</th>
					<th class="TextCenter">Insur Status</th>
					<th class="TextCenter">Apprv</th>
					<th>&nbsp;</th>
				</tr>

			<?php
			
				if (isset($_POST['review'])) {
					// get selected value as parameter
					$TeamName = mysqli_real_escape_string($_POST['TeamName']);
					
					// on POST
					if($TeamName = "All"){
						$query = "SELECT *, IF( ForwardedToInsurance='Y','checked','') AS ForwardedToInsurance,IF( Approved='Y','checked','') AS Approved 
								FROM player_registrations 
								ORDER BY Team ASC,PlayerPosition ASC";
					}
					// for original page load
					else{
						$query = "SELECT *, IF( ForwardedToInsurance='Y','checked','') AS ForwardedToInsurance,IF( Approved='Y','checked','') AS Approved 
								FROM player_registrations 
								WHERE Team = ?  
								ORDER BY PlayerPosition ASC";
					}
					
					
				}
				else{
					$query = "SELECT *, IF( ForwardedToInsurance='Y','checked','') AS ForwardedToInsurance,IF( Approved='Y','checked','') AS Approved 
								FROM player_registrations 
								ORDER BY Team ASC,PlayerPosition ASC";
				}
					/////////////////////////////////////
					// #################################
					// 1) can you set this up with a parameter
					//		a. if the page is POSTED
					//		b. on original page load, no parameter is required
					// 2) data set is created as normal below for the loop
					
					// #################################
					//////////////////////////////////////
					
					$result_tasks = mysqli_query($conn, $query);    
					
					while($row = mysqli_fetch_assoc($result_tasks)) { 
					
					echo 
						"<tr>
							<td><a href='player-registration_edit.php?id=$row[ID]' class='LinkEdit'>Edit</a></td>
							<td class='TextCenter'><input type=checkbox class='CheckNormal'  data-column_name='ForwardedToInsurance' data-id='$row[ID]' $row[ForwardedToInsurance] /></td>
							<td  class='TextCenter'><input type=checkbox class='CheckNormal'  data-column_name='Approved' data-id='$row[ID]' $row[Approved]></td>"
							?>
							
							<td><?php echo $row['Created']; ?></td>
							<td><?php echo $row['FirstName'].' '.$row['LastName']; ?></td>
							<td><?php echo $row['Team']; ?></td>
							<td><?php echo $row['PlayerPosition']; ?></td>
							<td><?php echo $row['Division']; ?></td>
							<td><?php echo $row['DOB']; ?></td>
							<td class="TextCenter"><?php echo $row['JerseyNumber']; ?></td>
							
							<td class="TextCenter"> <?php $var= $row['ForwardedToInsurance'];
								echo  ($var =='Y' ? 'Yes': 'No');?> </td>
							<td class="TextCenter"> <?php $var= $row['Approved'];
								echo  ($var =='Y' ? 'Yes': 'No');?> </td>
							
							<td><a href="player-registration_delete.php?idd=<?php echo $row["ID"]; ?>" class="LinkEdit"><span name="delete" id="delete" style="background:none;" onClick="return confirm('Are you sure you want to delete?')">Delete</span></a></td>
							
						</tr>
			<?php 
				}
			?>
			
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

<div class="Footer">
	......
</div>

</form>
</body>

</html>