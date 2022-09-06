<?php 
session_start();

require_once "db.php";
	include("functions.php");
	include('includes/header.php');
	$user_data = check_login($conn);
	$email="";
	$password="";
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		//$email = $_POST['email'];
		$password = $_POST['password'];
		$password = md5($password);
		//$firstname = mysqli_real_escape_string($con, $_POST['first_name']);
		
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		//$password  = mysqli_real_escape_string($con, $password);
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            $email_error = "Please Enter Valid Email ID";
        }
		
	else if(!empty($email) && !empty($password) && !is_numeric($email))
		{
			 if ($stmt = $conn->prepare('SELECT id FROM users WHERE email = ?')) {
           
				$stmt->bind_param('s',  $email);
				$stmt->execute();
				$stmt->store_result();
				// Store the result so we can check if the account exists in the database.
				if ($stmt->num_rows > 0) {
					// email already exists
					$email_error='Email exists, please choose another!';
				}else{
				//save to database
				$user_id = random_num(20);
				//$user_id = random_num(20);
				$query = "INSERT INTO users (user_id,email,password) values (?,?,?)";
				if  ($stmt = mysqli_prepare($conn, $query)){
					mysqli_stmt_bind_param($stmt, 'iss', $user_id,$email,$password);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_close($stmt);

					
					$user_added='User Added Successfully';
				//header("Location: reg.php");
				//die;
				}
				}}
			
		}else
		{
			echo "Please enter some valid information!";
		}
	}
?>




	<style type="text/css">
	
	#text{

		height: 25px;
		border-radius: 5px;
		padding: 4px;
		border: solid thin #aaa;
		width: 100%;
	}

	#button{

		padding: 10px;
		width: 100px;
		color: white;
		background-color: lightblue;
		border: none;
	}

	#box{

		background-color: grey;
		margin: auto;
		width: 300px;
		padding: 20px;
	}

	body {
    color: #000;
    overflow-x: hidden;
    height: 100%;
    background-color: #B0BEC5;
    background-repeat: no-repeat;
}

.card0 {
    box-shadow: 0px 4px 8px 0px #757575;
    border-radius: 0px;
}

.card2 {
    margin: 0px 40px;
}

.logo {
    width: 200px;
    height: 100px;
    margin-top: 20px;
    margin-left: 35px;
}

.image {
    width: 360px;
    height: 280px;
}

.border-line {
    border-right: 1px solid #EEEEEE;
}

.facebook {
    background-color: #3b5998;
    color: #fff;
    font-size: 18px;
    padding-top: 5px;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    cursor: pointer;
}

.twitter {
    background-color: #1DA1F2;
    color: #fff;
    font-size: 18px;
    padding-top: 5px;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    cursor: pointer;
}

.linkedin {
    background-color: #2867B2;
    color: #fff;
    font-size: 18px;
    padding-top: 5px;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    cursor: pointer;
}

.line {
    height: 1px;
    width: 45%;
    background-color: #E0E0E0;
    margin-top: 10px;
}

.or {
    width: 10%;
    font-weight: bold;
}

.text-sm {
    font-size: 14px !important;
}

::placeholder {
    color: #BDBDBD;
    opacity: 1;
    font-weight: 300
}

:-ms-input-placeholder {
    color: #BDBDBD;
    font-weight: 300
}

::-ms-input-placeholder {
    color: #BDBDBD;
    font-weight: 300
}

input, textarea {
    padding: 10px 12px 10px 12px;
    border: 1px solid lightgrey;
    border-radius: 2px;
    margin-bottom: 5px;
    margin-top: 2px;
    width: 100%;
    box-sizing: border-box;
    color: #2C3E50;
    font-size: 14px;
    letter-spacing: 1px;
}

input:focus, textarea:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    border: 1px solid #304FFE;
    outline-width: 0;
}

button:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    outline-width: 0;
}

a {
    color: inherit;
    cursor: pointer;
}

.btn-blue {
    background-color: #1A237E;
    width: 150px;
    color: #fff;
    border-radius: 2px;
}

.btn-blue:hover {
    background-color: #000;
    cursor: pointer;
}

.bg-blue {
    color: #fff;
    background-color: #1A237E;
}

@media screen and (max-width: 991px) {
    .logo {
        margin-left: 0px;
    }

    .image {
        width: 300px;
        height: 220px;
    }

    .border-line {
        border-right: none;
    }

    .card2 {
        border-top: 1px solid #EEEEEE !important;
        margin: 0px 15px;
    }
}
	</style>




<div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
    <div class="card card0 border-0">
        <div class="row d-flex">
            <div class="col-lg-6">
                <div class="card1 pb-5">
                    <div class="row row px-3 justify-content-center">
                       
					
					</div>
                    <div class="row px-3 justify-content-center mt-4 mb-5 border-line">
                        <img src="https://lirp-cdn.multiscreensite.com/dfb474a2/dms3rep/multi/opt/ORHL_Logo_M-1920w.png" class="image">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
			<form method="post">
                <div class="card2 card border-0 px-4 py-5">
                    <div class="row mb-4 px-3">
					
                    </div>
                    <div class="row px-3 mb-4">
                        <div class="line"></div>
                        <small class="or text-center">Add Users</small>
						
                        <div class="line"></div>
						<span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
						<span class="text-success"><?php if (isset($user_added)) echo $user_added; ?> </span>
						
                    </div>
                    <div class="row px-3">
                        <label class="mb-1"><h6 class="mb-0 text-sm">Email Address</h6></label>
                        <input class="mb-4" type="text" name="email" placeholder="Enter a valid email address">
                    </div>
                    <div class="row px-3">
                        <label class="mb-1"><h6 class="mb-0 text-sm">Password</h6></label>
                        <input type="password" name="password" placeholder="Enter password">
                    </div>
                    <div class="row px-3 mb-4">
                        <div class="custom-control custom-checkbox custom-control-inline">
                       
                        </div>
                    
                    </div>
                    <div class="row mb-3 px-3">
                        <button type="submit" class="btn btn-blue text-center">Add User</button>
                    </div>
                   
                </div>
</Form>
            </div>
        </div>
    
    </div>
</div>