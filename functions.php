<?php

function check_login($conn)
{

	if(isset($_SESSION['user_id']))
	{

		$id = $_SESSION['user_id'];
		$query = "select * from users where user_id = ? limit 1";
		$stmt = mysqli_prepare($conn, $query) ;  
			mysqli_stmt_bind_param($stmt, "i", $id);
			$id = trim(mysqli_real_escape_string($conn,$_SESSION['user_id']));
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
		//$result = mysqli_query($con,$query);
		if($result && mysqli_num_rows($result) > 0)
		{

			$user_data = mysqli_fetch_assoc($result);
			return $user_data;
		}
	}

	//redirect to login
	header("Location: login.php");
	die;

}

function random_num($length)
{

	$text = "";
	if($length < 5)
	{
		$length = 5;
	}

	$len = rand(4,$length);

	for ($i=0; $i < $len; $i++) { 
		# code...

		$text .= rand(0,9);
	}

	return $text;
}