<?php 
       require_once "db.php";
	   $param_id ='';
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$divisionID = $_POST['get_option'];
	
		$sql=  "SELECT TeamName FROM teams WHERE Season = '2022-23' AND Division = ?";
		if($stmt = mysqli_prepare($conn, $sql)){    
			mysqli_stmt_bind_param($stmt, "s", $param_id);
			$param_id = trim(mysqli_real_escape_string($conn,$_POST["get_option"]));
			
			if(mysqli_stmt_execute($stmt)){
				 $rs = mysqli_stmt_get_result($stmt);
		
					while($teams = mysqli_fetch_assoc($rs))
					{
						echo '<option value="'.$teams['TeamName'].'">'.$teams['TeamName'].'</option>';
					}	
	         }
        }
	}

?>