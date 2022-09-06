<?php
session_start();
require_once "db.php";
include("functions.php");
$user_data = check_login($conn);

  include('includes/header.php');
  require 'phpmailer/PHPMailer.php';
  require 'phpmailer/SMTP.php';
   require 'phpmailer/Exception.php';
   
   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\SMTP;
   use PHPMailer\PHPMailer\Exception;

  


// Define variables and initialize with empty values


	   $firstname = "";
	   $lastname = "";
	   $firstname_error = "";
       $lastname_error = "";
	   $JerseyNumber_err="";
	   $month = "";
	   $day = "";
	   $year = "";
	   $bDivision = "";
	   $aDivision = "";
	   $PlayerPosition = "";
	
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
	$firstname = mysqli_real_escape_string($conn, $_POST['first_name']);
	$lastname = mysqli_real_escape_string($conn, $_POST['last_name']);
	$start_m = mysqli_real_escape_string($conn, $_POST['month']);
	$start_d = mysqli_real_escape_string($conn, $_POST['day']);
	$start_y = mysqli_real_escape_string($conn, $_POST['year']);
 
	$dob = $start_y . "-" . str_pad($start_m, 2, "0", STR_PAD_LEFT) . "-" . str_pad($start_d, 2, "0", STR_PAD_LEFT);
	$dob1 = $start_y . "-" . str_pad($start_m, 2, "0", STR_PAD_LEFT) . "-" . str_pad($start_d, 2, "0", STR_PAD_LEFT);
	$dob= strtotime($dob1);
   
	$bDivision = mysqli_real_escape_string($conn, $_POST['bDivision']);
	$aDivision = mysqli_real_escape_string($conn, $_POST['aDivision']);
	$PlayerPosition = mysqli_real_escape_string($conn, $_POST['PlayerPosition']);

    // Validate name
    $firstname = mysqli_real_escape_string($conn, $_POST['first_name']);
    if(empty($firstname)){
		$firstname_error= "Please enter a name.";
    } elseif(!filter_var($firstname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $firstname_error = "Please enter a valid name.";
    } else{
        $firstname = $firstname;
    }

	 $lastname = mysqli_real_escape_string($conn, $_POST['last_name']);
    if(empty($lastname)){
		$lastname_error= "Please enter a name.";
    } elseif(!filter_var($lastname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $lastname_error = "Please enter a valid name.";
    } else{
        $lastname= $lastname;
    }
    // Validate address address
	$JerseyNumber = mysqli_real_escape_string($conn, $_POST['JerseyNumber']);
    if(empty($JerseyNumber)){
  
        $JerseyNumber_err = "Please enter the Jersey Number.";     
    } elseif(!ctype_digit($JerseyNumber)){
		$JerseyNumber_err = "Please enter a positive integer value.";
    } else{
		$JerseyNumber = $JerseyNumber;
    }
    // Check input errors before inserting in database
    if(empty($firstname_error ) && empty($lastname_error) && empty($JerseyNumber_err)){
        // Prepare an update statement
        $sql = "UPDATE player_registrations SET FirstName=?, LastName=?,DOB=?, Division=?,Team=?,PlayerPosition=?,JerseyNumber=? WHERE id=?";
         
		
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssi", $param_firstname, $param_lastname, $param_dob, $param_bDivision,$param_aDivision,$param_PlayerPosition ,$param_JerseyNumber,$param_id);
            
            // Set parameters
             $param_firstname = $firstname;
			 $param_lastname = $lastname;
             $param_dob = $dob1;
			 $param_JerseyNumber=$JerseyNumber;
			 $param_PlayerPosition =$PlayerPosition; 
			 $param_bDivision = $bDivision; 
			 $param_aDivision  = $aDivision; 
			 $param_id = $id;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: player-registration-manage.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($conn);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM player_registrations WHERE ID = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                     $firstname = $row['FirstName'];
                     $lastname = $row['LastName'];
                     $dob= strtotime($row['DOB']);
				     $JerseyNumber=$row['JerseyNumber'];
				     $PlayerPosition =$row['PlayerPosition']; 
				     $bDivision = $row['Division']; 
				     $aDivision  = $row['Team']; 
				  
					
					  
					
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($conn);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}




  
   /*  if (isset($_POST['save'])) {

    
        $firstname = mysqli_real_escape_string($conn, $_POST['first_name']);
        $lastname = mysqli_real_escape_string($conn, $_POST['last_name']);
		$start_m = mysqli_real_escape_string($conn, $_POST['month']);
		$start_d = mysqli_real_escape_string($conn, $_POST['day']);
		$start_y = mysqli_real_escape_string($conn, $_POST['year']);
		$address= mysqli_real_escape_string($conn, $_POST['address']);
		$address2= mysqli_real_escape_string($conn, $_POST['address2']);
		
		
		$dob = $start_y . "-" . str_pad($start_m, 2, "0", STR_PAD_LEFT) . "-" . str_pad($start_d, 2, "0", STR_PAD_LEFT);

        $email = mysqli_real_escape_string($conn, $_POST['ParentOneEmail']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);
		$province = mysqli_real_escape_string($conn, $_POST['province']);
		$Postal_Code = mysqli_real_escape_string($conn, $_POST['Postal_Code']);
		$ParentOneName = mysqli_real_escape_string($conn, $_POST['ParentOneName']);

		$ParentOnePhoneOne = mysqli_real_escape_string($conn, $_POST['ParentOnePhoneOne']);
		$ParentOnePhoneTwo = mysqli_real_escape_string($conn, $_POST['ParentOnePhoneTwo']);
		
		$ParentTwoName = mysqli_real_escape_string($conn, $_POST['ParentTwoName']);

		$ParentTwoPhoneOne = mysqli_real_escape_string($conn, $_POST['ParentTwoPhoneOne']);
		$ParentTwoPhoneTwo = mysqli_real_escape_string($conn, $_POST['ParentTwoPhoneTwo']);
	
		$ParentTwoEmail = mysqli_real_escape_string($conn, $_POST['ParentTwoEmail']);
		$bDivision = mysqli_real_escape_string($conn, $_POST['bDivision']);
		$aDivision = mysqli_real_escape_string($conn, $_POST['aDivision']);
		$PlayerPosition = mysqli_real_escape_string($conn, $_POST['PlayerPosition']);
		$lConduct = mysqli_real_escape_string($conn, $_POST['lConduct']);
		$RowansLaw = mysqli_real_escape_string($conn, $_POST['RowansLaw']);
		$Waiver = mysqli_real_escape_string($conn, $_POST['Waiver']);

		

        if (empty($firstname)) {  
             $firstname_error = "Please Enter Your First Name";  
        }else if (empty($lastname)) {  
             $lastname_error = "Please Enter Your Last Name";  
        } else if(!preg_match("/^[a-zA-Z ]+$/",$firstname)) {
             $firstname_error = "Name must contain only alphabets and space";
        }else if(!preg_match("/^[a-zA-Z ]+$/",$lastname)) {
             $lastname_error = "Name must contain only alphabets and space";
        }else if (empty($email)) {  
             $email_error = "Please Enter your Email";  
        }else if (empty($address)) {  
             $address_error = "Please Enter your Address";  
        }
		else if (empty( $city)) {  
			$city_error = "Please Enter your city";  
	   }else if (empty( $ParentOneName)) {  
		    $ParentOneName_error = "Please Enter your parent Name";  
        }else if (empty( $Postal_Code)) {  
			$Postal_Code_error = "Please Enter your Postal Code";  
        }else if (empty( $ParentOnePhoneOne)) {  
			$ParentOnePhoneOne_error = "Please Enter your parrent name";  
        }else if($ParentOnePhoneOne== $ParentTwoPhoneOne) {
			$Phone_match_error = "phone number should be different for different user";  
		 }else if($email== $ParentTwoEmail) {
			$email_parrent_match_error = "Email should be different for different user";  
		 }
		 
        else if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            $email_error = "Please Enter Valid Email ID";
        } else if(!filter_var($ParentTwoEmail,FILTER_VALIDATE_EMAIL)) {
            $email_error = "Please Enter Valid Email ID";
        }
      
       else if ($stmt = $conn->prepare('SELECT ID FROM player_registrations WHERE ParentOneEmail = ?')) {
           
            $stmt->bind_param('s',  $email);
            $stmt->execute();
            $stmt->store_result();
            // Store the result so we can check if the account exists in the database.
            if ($stmt->num_rows > 0) {
                // email already exists
               @$user_found_error='Email exists, please choose another!';
            } else {
               
                if (!$error) {

                    $query = "INSERT INTO player_registrations (FirstName,LastName,DOB,Address,Address2,City,Province,PostalCode,ParentOneName,ParentOnePhoneOne,ParentOnePhoneTwo,
					ParentOneEmail,ParentTwoName,ParentTwoPhoneOne,ParentTwoPhoneTwo,ParentTwoEmail,Division,Team,PlayerPosition,CodeOfConduct,Waiver,RowansLaw)
                    VALUES(?, ?, ?, ?,?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";
                   
                  if  ($stmt = mysqli_prepare($conn, $query)){
                        mysqli_stmt_bind_param($stmt, 'ssssssssssssssssssssss', $firstname,$lastname,$dob,$address, $address2, $city, $province,$Postal_Code, $ParentOneName, $ParentOnePhoneOne, $ParentOnePhoneTwo,
					   $email,$ParentTwoName,$ParentTwoPhoneOne, $ParentTwoPhoneTwo,$ParentTwoEmail,$bDivision, $aDivision, $PlayerPosition, $lConduct, $Waiver,  $RowansLaw);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_close($stmt);


						$mail = new PHPMailer();

						
							//Server settings
							//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                  
							$mail->isSMTP();                                            
							$mail->Host       = 'smtp.gmail.com';                    
							$mail->SMTPAuth   = true;                                  
							$mail->Username   = 'wondwesssdfsfenh41@gmail.com';                    
							$mail->Password   = 'sdfsdf';                               
							$mail->SMTPSecure = 'tls';            
							$mail->Port = 587;                                    
						
							//Recipients
							$mail->setFrom('wondwessesdfdsfnh41@gmail.com');
							$mail->addAddress($email);    
							
							$mail->isHTML(true);                               
							$mail->Subject = "ORHL Player Registration  $lastname  Confirmation";

					
							$mail->Body    = "<body><html> 
							<table style=width:90%; height:auto; border-collapse:collapse; border:solid 2pt #DA251D;'>
								<tr><td style='border:solid 2pt #DA251D; padding:3%;'>
									<img src='https://lirp-cdn.multiscreensite.com/dfb474a2/dms3rep/multi/opt/ORHL_Logo_M-1920w.png' alt='ORHL' />
								</td></tr>
								<tr><td style='border:solid 2pt #DA251D; padding:2%;'>
									Thank you for registering with the Ontario Rep Hockey League<br /><br />
									Following are the details of your registration. Please contact us if there is something that needs to be adjusted.<br /><br />
								</td></tr>
								<tr><td style='border:solid 2pt #DA251D; padding:2%;'>
									Name:  $firstname    $lastname   <br />
									Date of Birth: $dob <br />
									Address: $address <br />
									$address2  <br /> 
									City:  $city  <br /> 
									Province:  $province  <br />
									Postal Code: $Postal_Code  <br /> 
									Season:     <br /> 
									Division:  $bDivision  <br /> 
									Team:  $aDivision 
								</td></tr> 
								<tr><td style='border:solid 2pt #DA251D; padding:2%;'> 
									In addition to the above you acknowledged the Code of Conduct, Rowan's Law and the Liability Waiver, available here:<br />
									<a href='https://orhl.net/PDF/Code-Of-Conduct-ORHL-175.pdf'>ORHL Code of Conduct</a><br /> 
									<a href='https://orhl.net/PDF/ORHL-Waiver-2019.pdf'>ORHL Liability Waiver</a><br /> 
									<a href='https://orhl.net/PDF/2019-2020-Rowans-Law-Concussion-Awareness-Acknowledgement.pdf'>Rowan's Law Concussion Protocol</a><br /><br /> 
									ORHL - Ontario Rep Hockey League<br />
									Administration Phone: 905.407.1213<br /> 
									Website: https://orhl.net 
								</td></tr> 
							</table> 
							</html></body>";
							
						
							if($mail->send()){
								$email_error = 'Message has been sent';
							}
						  else {
							$email_error= "Message could not be sent.";
						 }
                           $mail->smtpClose();
                        header("location:players_list.php");
                         exit();
                
                  }
    
                  else {
                   echo "Error: " . $sql . "" . mysqli_error($conn);
                   } 
                
            }
            $stmt->close();
        }


     }
        
        mysqli_close($conn);
    } */
?>



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
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

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
				<h2>All areas are mandatory unless shown as optional</h2>
				<span id="lblPageError" runat="server" class="Notification"></span>
				
				
			</div>
			<div class="ColLeft">
			
				PLAYER OR STAFF First Name
				<input type="text" id="txtFirstName" name="first_name" runat="server" class="TextBoxNormal" maxlength="50"  value="<?php echo $firstname; ?>" />
				<span class="WarningPopUp"   ><?php if (isset($firstname_error)) echo $firstname_error; ?></span>
				
				PLAYER OR STAFF Last Name
				<input type="text" id="txtLastName" name="last_name" runat="server" class="TextBoxNormal" maxlength="50" value="<?php echo $lastname; ?>"   />
				<span class="WarningPopUp" ><?php if (isset($lastname_error)) echo $lastname_error; ?></span>
				PLAYER OR STAFF Date of Birth
				<div style="width:100%; text-align:left;">
					<select id="ddlMonth" name="month" runat="server" class="DropInline" >
						 <?php echo  '<option value="'.date('m',$dob).'">'.date('M',$dob).'</option>'; ?>
					
						<option value="01">Jan</option>
						<option value="02">Feb</option>
						<option value="03">Mar</option>
						<option value="04">Apr</option>
						<option value="05">May</option>
						<option value="06">Jun</option>
						<option value="07">Jul</option>
						<option value="08">Aug</option>
						<option value="09">Sep</option>
						<option value="10">Oct</option>
						<option value="11">Nov</option>
						<option value="12">Dec</option>
					</select>
					<select id="ddlDay" name="day" runat="server" class="DropInline" >
					<?php echo  '<option value="'.date('d',$dob).'">'.date('d',$dob).'</option>'; ?>
						<option value="01">01</option>
						<option value="02">02</option>
						<option value="03">03</option>
						<option value="04">04</option>
						<option value="05">05</option>
						<option value="06">06</option>
						<option value="07">07</option>
						<option value="08">08</option>
						<option value="09">09</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
						<option value="13">13</option>
						<option value="14">14</option>
						<option value="15">15</option>
						<option value="16">16</option>
						<option value="17">17</option>
						<option value="18">18</option>
						<option value="19">19</option>
						<option value="20">20</option>
						<option value="21">21</option>
						<option value="22">22</option>
						<option value="23">23</option>
						<option value="24">24</option>
						<option value="25">25</option>
						<option value="26">26</option>
						<option value="27">27</option>
						<option value="28">28</option>
						<option value="29">29</option>
						<option value="30">30</option>
						<option value="31">31</option>
					</select>
					<select id="ddlYear"name="year" runat="server" class="DropInline" >
					<?php echo '<option value="'.date('Y',$dob).'">'.date('Y',$dob).'</option>'; ?>
						<option value="2016">2016</option>
						<option value="2015">2015</option>
						<option value="2014">2014</option>
						<option value="2013">2013</option>
						<option value="2012">2012</option>
						<option value="2011">2011</option>
						<option value="2010">2010</option>
						<option value="2009">2009</option>
						<option value="2008">2008</option>
						<option value="2007">2007</option>
						<option value="2006">2006</option>
						<option value="2005">2005</option>
						<option value="2004">2004</option>
						<option value="2003">2003</option>
						<option value="2002">2002</option>
						<option value="2001">2001</option>
						<option value="2000">2000</option>
						<option value="1999">1999</option>
						<option value="1998">1998</option>
						<option value="1997">1997</option>
						<option value="1996">1996</option>
						<option value="1995">1995</option>
						<option value="1994">1994</option>
						<option value="1993">1993</option>
						<option value="1992">1992</option>
						<option value="1991">1991</option>
						<option value="1990">1990</option>
						<option value="1989">1989</option>
						<option value="1988">1988</option>
						<option value="1987">1987</option>
						<option value="1986">1986</option>
						<option value="1985">1985</option>
						<option value="1984">1984</option>
						<option value="1983">1983</option>
						<option value="1982">1982</option>
						<option value="1981">1981</option>
						<option value="1980">1980</option>
						<option value="1979">1979</option>
						<option value="1978">1978</option>
						<option value="1977">1977</option>
						<option value="1976">1976</option>
						<option value="1975">1975</option>
						<option value="1974">1974</option>
						<option value="1973">1973</option>
						<option value="1972">1972</option>
						<option value="1971">1971</option>
						<option value="1970">1970</option>
						<option value="1969">1969</option>
						<option value="1968">1968</option>
						<option value="1967">1967</option>
						<option value="1966">1966</option>
						<option value="1965">1965</option>
						<option value="1964">1964</option>
						<option value="1963">1963</option>
						<option value="1962">1962</option>
						<option value="1961">1961</option>
						<option value="1960">1960</option>
						<option value="1959">1959</option>
						<option value="1958">1958</option>
						<option value="1957">1957</option>
						<option value="1956">1956</option>
						<option value="1955">1955</option>
						<option value="1954">1954</option>
						<option value="1953">1953</option>
						<option value="1952">1952</option>
						<option value="1951">1951</option>
						<option value="1950">1950</option>
					</select>
				
					</div>
			
			</div>
			<div class="ColRight">
				<!--
				Medical Conditions (if any)
				<input type="text" id="txtMedical" runat="server" TextMode="MultiLine" class="TextArea" />
				-->
				
				Division (Select Before Team)
				<select id="ddlDivision" name="bDivision" runat="server" class="DropNormal" AutoPostBack="true" minilength="1" onchange="fetch_select(this.value);" value="<?php echo  $bDivision ; ?>" >
				<?php echo  '<option value="'.$bDivision.'">'.$bDivision.'</option>'; ?>
				<option value="Novice (U9)">Novice (U9)</option>
				<option value="Atom (U11)">Atom (U11)</option>
				<option value="Peewee (U13)">Peewee (U13)</option>
				<option value="Bantam (U15)">Bantam (U15)</option>
				<option value="Minor Midget (U17)">Minor Midget (U17)</option>
				<option value="Major Midget (U18)">Major Midget (U18)</option>
				</select>
				<!-- updating div -->
				<img src="img/ajax-loader.gif" id="loader" >
				<!-- <img src="images/CircleProgress2.gif" width="60" height="60" border="0" style="display:none;" /> -->
				<!-- ends updating div -->
				
				Team (Select After Division)

			
			   <select id="ddlTeams" name="aDivision" runat="server" class="DropNormal"  >
			  
			   <?php echo  '<option value="'.$aDivision.'">'.$aDivision.'</option>'; ?>
			  </select>

			   <!-- 
				<select id="ddlTeams" name="aDivision" runat="server" class="DropNormal" >
				    <option value="AB">Alberta</option>
					<option value="BA">British Columbia</option>
					<option value="MB">Manitoba</option>
					<option value="NB">New Brunswick</option>
					<option value="NL">Newfoundland Labrador</option>
				</select> -->
				Player or Staff Position
				<select id="ddlPlayerPosition" name="PlayerPosition" runat="server" class="DropNormal" minilength="1" >
				<?php echo  '<option value="'.$PlayerPosition.'">'.$PlayerPosition.'</option>'; ?>
					<option value="Goal">Player: Goal</option>
					<option value="Forward/Defence">Player: Forward/Defence</option>
					<option value="Head Coach">Staff: Head Coach</option>
					<option value="Asst Coach">Staff: Asst Coach(es)</option>
					<option value="Trainer">Staff: Trainer</option>
				</select>
				
				Jersey # (optional - numbers only)
				<input type="text" id="txtJerseyNumber" name="JerseyNumber" runat="server" class="TextBoxNormal" Visible="false"  value="<?php echo $JerseyNumber; ?>" />
				<span class="WarningPopUp"   ><?php if (isset($JerseyNumber_err)) echo $JerseyNumber_err; ?></span>
				
				<input type="hidden" name="id" value="<?php echo $id; ?>"/>
				
				
				<!-- <button id="btnSubmit" name="save" class="ButtonNormal" onclick="save_registration();">Submit Registration</button>-->
				<input type="submit"  class="ButtonNormal" class="btn btn-success btn-block" name="save" value="submit">
				Go to Users lists?<a href="player-registration-manage.php" class="btn btn-default">Players List</a>
			</div>
			<div class="Footer">
				
			</div>
		</div><!-- closes main body -->
	</div>

</form>

	<?php
	
		function save_registration(){
		
			//	error_reporting(E_ALL);
			//	ini_set('display_errors', '1');
				
				$servername = "localhost";
				$username = "root";
				$password = "1219John57a";
				$dbname = "orhl";
				
				
				
				exit();
				
				
				$strFirstName = trim($_POST["txtFirstName"]);
				$strLastName = trim($_POST["txtLastName"]);
			//	$strMonth = ddlMonth.SelectedItem]);
			//	$strDay = ddlDay.SelectedItem]);
			//	$strYear = ddlYear.SelectedItem]);
				$strAddress = trim($_POST["txtAddress"]);
				$strAddress2 = trim($_POST["txtAddress2"]);
				$strCity = trim($_POST["txtCity"]);
			//	$strProvince = ddlProvince.SelectedItem.Value.Trim()
				$strPostalCode = trim($_POST["txtPostalCode"]);
				$strParentOneName = trim($_POST["txtParentOneName"]);
				$strParentOnePhoneOne = trim($_POST["txtParentOnePhoneOne"]);
				$strParentOnePhoneTwo = trim($_POST["txtParentOnePhoneTwo"]);
				$strParentOneEmail = trim($_POST["txtParentOneEmail"]);
				$strParentTwoName = trim($_POST["txtParentTwoName"]);
				$strParentTwoPhoneOne = trim($_POST["txtParentTwoPhoneOne"]);
				$strParentTwoPhoneTwo = trim($_POST["txtParentTwoPhoneTwo"]);
				$strParentTwoEmail = trim($_POST["txtParentTwoEmail"]);
			//	$strMedical = trim($_POST["txtMedical]);
				$strTeam;
			//	$strDivision = "test"	'ddlDivision.SelectedItem.Value.Trim();
			//	$strDOB,strAllEmails;
			//	$strPlayerPosition = ddlPlayerPosition.SelectedItem.Value.Trim();
			//	$strJerseyNumber = 0 //trim($_POST["txtJerseyNumber]);
			//	$strConduct = ddlConduct.SelectedItem.Value.Trim();
			//	$strWaiver = ddlWaiver.SelectedItem.Value.Trim();
			//	$strRowansLaw = ddlRowansLaw.SelectedItem.Value.Trim();
			//	$intConduct,intWaiver,intMonth,intDay,intYear,intJerseyNumber;
			//	$dteDOB As DateTime;
			//	$strResponse,strMessage,strSubject;
				$strSeason = "2022-23";
			//	$regexCheckEmail As New Regex("^.+@[^\.].*\.[a-zA-Z]{2,}$")
			//	$boolSaved,boolDelinquent As Boolean
			//	$strSendToDiane = ConfigurationSettings.AppSettings("constantSendEmailToDiane")
				
				// Create connection
			//	$conn = mysqli_connect($servername, $username, $password, $dbname);
				// Check connection
			//	if (!$conn) {
			//	  die("Connection failed: " . mysqli_connect_error());
			//	}
				
			//	$preparedStatement = $db->prepare('INSERT INTO table (column) VALUES (:column)');
			//	$preparedStatement->execute([ 'column' => $unsafeValue ]);
				
				$sql = "INSERT INTO player_registrations(FirstName,LastName,DOB,Address,Address2,City,Province,PostalCode,ParentOneName,ParentOnePhoneOne,ParentOnePhoneTwo,
					ParentOneEmail,ParentTwoName,ParentTwoPhoneOne,ParentTwoPhoneTwo,ParentTwoEmail,MedicalConditions,Division,Team,PlayerPosition,
					JerseyNumber,CodeOfConduct,Waiver,RowansLaw,Season)
					VALUES(:Fir,:Las,:DOB,:Adr,:Adr2,:Cit,:Pro,:Pos,:ParOne,:ParPh,:ParPh2,:ParEm,:ParTwo,:ParTwoPh,:ParTwoPh2,:ParTwoEm,:Med,:Div,:Tem,:Ply,:Jer,:COC,:Wav,:RL,:Sea)";
				
				
			//	$stmt = $conn->prepare($sql);
			//	$stmt->bindValue(':id', $id);
			//	:Fir,:Las,:DOB,:Adr,:Adr2,:Cit,:Pro,:Pos,:ParOne,:ParPh,:ParPh2,:ParEm,:ParTwo,:ParTwoPh,:ParTwoPh2,:ParTwoEm,:Med,:Div,:Tem,:Ply,:Jer,:COC,:Wav,:RL,:Sea
			
			
			//	$stmt->bindValue(':Fir', $name);
			//	$stmt->execute();
		
		};
	


	
	?>

<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity "sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

<script type="text/javascript">
function fetch_select(val)
{
	var getDivisionID = val;
			
			if(getDivisionID !='')
			{
				$("#loader").show();
			
			$.ajax({
			type: 'post',
			url: 'ajax_request.php',
			data: {
			get_option:val
			},
			success: function (response) {
				$("#loader").hide();
			document.getElementById("ddlTeams").innerHTML=response; 
			}
			});
		}
}

</script>

</body>
</html>
