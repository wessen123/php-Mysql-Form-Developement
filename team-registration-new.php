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
/*
1) save each row of table into player_registrations table
2) for field 'Email' in this table use the ManagerEmail for all inserts
3) I gave each text box a different name such as FirstName_1, FirstName_2, FirstName_3 etc etc. Is this the correct way to save multiple rows of input?
	This way, each text box can hold different date??
4) INSERT a new recordd for each row in the table
5) negative responses should be returned in $error variable
	example:
	return 	$error = "Please Enter Your First Name";
			$ClassChoice = "WarningPopUp";
			
			or both variables should = "" if there is no error

*/

$firstname_error="";
$lastname_error = "";
if (isset($_POST['save'])) {

	
	
	$bDivision = mysqli_real_escape_string($conn, $_POST['bDivision']);
	$team= @mysqli_real_escape_string($conn, $_POST['aDivision']);

	
	$ManagerName = mysqli_real_escape_string($conn, $_POST['ManagerName']);
	$ManagerPhone = mysqli_real_escape_string($conn, $_POST['ManagerPhone']);
	$ManagerEmail = mysqli_real_escape_string($conn, $_POST['ManagerEmail']);
	

	$HeadCoachName = mysqli_real_escape_string($conn, $_POST['HeadCoachName']);
	$HeadCoachPhone = mysqli_real_escape_string($conn, $_POST['HeadCoachPhone']);
	$HeadCoachEmail = mysqli_real_escape_string($conn, $_POST['HeadCoachEmail']);
	
	$Insurance = mysqli_real_escape_string($conn, $_POST['Insurance']);
	$lConduct = mysqli_real_escape_string($conn, $_POST['lConduct']);
	

	$FirstName= $_POST['FirstName'];
	$LastName = $_POST['LastName'];
	$JerseyNumber = $_POST['JerseyNumber'];
	$month = $_POST['month'];
	$day = $_POST['day'];
	$year = $_POST['year'];
	$PlayerPosition= $_POST['PlayerPosition'];
	
	if (empty($bDivision)) {  
		 $division_error = "Please Enter Player's  Devision ";  
	}if (empty($team)) {  
		$team_error = "Please Enter  Player's Team ";  
	}
	elseif (empty($ManagerName)) {  
		 $managername_error = "Please Enter Manager's  name";  
	} else if(!preg_match("/^[a-zA-Z ]+$/",$ManagerName)) {
		$managername_error = "Name must contain only alphabets and space";
	}elseif (empty($ManagerPhone)) {  
		 $managername_error = "Please Enter Manager's phone number";  
	}
	elseif (empty($ManagerEmail)) {  
		 $managername_error = "Please Enter your Email";  
	}
	else if(!filter_var($ManagerEmail,FILTER_VALIDATE_EMAIL)) {
		 $managername_error = "Please Enter Valid Email ID for manager";
	}
	elseif (empty($HeadCoachName)) {  
		$managername_error = "Please HeadCoach your name";  
	} else if(!preg_match("/^[a-zA-Z ]+$/",$HeadCoachName)) {
		$managername_error = "Name must contain only alphabets and space";
	}elseif (empty($HeadCoachPhone)) {  
		 $managername_error = "Please Enter HeadCoachphone number";  
	}
	elseif (empty($HeadCoachEmail)) {  
		 $managername_error = "Please Enter HeadCoach Email";  
	}
	else if(!filter_var($HeadCoachEmail,FILTER_VALIDATE_EMAIL)) {
		  $managername_error = "Please Enter Valid Email ID for HeadCoachName";
	}elseif($ManagerEmail== $HeadCoachEmail) {
		$managername_error = "Email should be different for different user";  
	 }elseif (empty($Insurance)) {  
		$insurance_error = "Please Enter Insurance number ";  
	  }else if (empty(  $FirstName[0])) {  
		$firstname_error = "Please Enter First Name for player One";  
		
	}else if (empty(  $FirstName[1])) {  
		 $firstname_error= "Please Enter First Name for player Two";  
		
	}else if (empty(  $FirstName[2])) {  
		$firstname_error= "Please Enter First Name for player Three";  
		
	}else if (empty(  $FirstName[3])) {  
		 $firstname_error = "Please Enter First Name for player Four";  
		
	}else if (empty(  $FirstName[4])) {  
		 $firstname_error = "Please Enter First Name for player Five";  
	}
	
	else if (empty($LastName[0])) {  
		 $lastname_error = "Please Enter last Name for player One";  
		
	}else if (empty(  $LastName[1])) {  
		 $lastname_error = "Please Enter Last Name for player Two";  
		
	}else if (empty(  $LastName[2])) {  
		$lastname_error = "Please Enter Last Name for player Three";  
		
	}else if (empty(  $LastName[3])) {  
		 $lastname_error = "Please Enter Last Name for player Four";  
		
	}else if (empty(  $LastName[4])) {  
	     $firstname_error = "Please Enter last Name for player Five";  	
	}
	else if (empty($JerseyNumber[0])) {  
		$lastname_error = "Please Enter JerseyNumber for player One";  
		
	}else if (empty(  $JerseyNumber[1])) {  
		$lastname_error = "Please Enter JerseyNumbere for player Two";  
		
	}else if (empty(  $JerseyNumber[2])) {  
		 $lastname_error = "Please Enter JerseyNumber for player Three";  
		
	}else if (empty(  $JerseyNumber[3])) {  
		 $lastname_error = "Please Enter JerseyNumber for player Four";  
		
	}else if (empty(  $JerseyNumber[4])) {  
		 $firstname_error = "Please Enter JerseyNumber for player Five";  	
	}else if (empty($month[0])) {  
		 $lastname_error = "Please Enter date of birth  for player One";  
		
	}else if (empty(  $month[1])) {  
		 $lastname_error = "Please Enter date of birth for player Two";  
		
	}else if (empty(  $month[2])) {  
		 $lastname_error = "Please Enter date of birth for player Three";  
		
	}else if (empty(  $month[3])) {  
		 $lastname_error = "Please Enter date of birth  for player Four";  
		
	}else if (empty(  $month[4])) {  
		 $firstname_error = "Please Enter date of birth  for player Five";  	
	}
	
	else if (empty($day[0])) {  
		 $lastname_error = "Please Enter date of birth  for player One";  
		
	}else if (empty(  $day[1])) {  
		 $lastname_error = "Please Enter date of birth  for player Two";  
		
	}else if (empty(  $day[2])) {  
		 $lastname_error = "Please Enter date of birth  for player Three";  
		
	}else if (empty(  $day[3])) {  
		 $lastname_error = "Please Enter date of birth  for player Four";  
		
	}else if (empty(  $day[4])) {  
		 $firstname_error = "Please Enter date of birth for player Five";  	
	}

	else if (empty($year[0])) {  
		 $lastname_error = "Please Enter date of birth  for player One";  
		
	}else if (empty(  $year[1])) {  
		 $lastname_error = "Please Enter date of birth  for player Two";  
		
	}else if (empty(  $year[2])) {  
		 $lastname_error = "Please Enter date of birth  for player Three";  
		
	}else if (empty(  $year[3])) {  
		$lastname_error = "Please Enter date of birth for player Four";  
		
	}else if (empty(  $year[4])) {  
		 $firstname_error = "Please Enter date of birth for player Five";  	
	}

	else if (empty($PlayerPosition[0])) {  
		 $lastname_error = "Please Enter  Position for player One";  
		
	}else if (empty( $PlayerPosition[1])) {  
		$lastname_error = "Please Enter Position for player Two";  
		
	}else if (empty(  $PlayerPosition[2])) {  
		 $lastname_error = "Please Enter Position for player Three";  
		
	}else if (empty( $PlayerPosition[3])) {  
		$lastname_error = "Please Enter Position for player Four";  
		
	}else if (empty(  $PlayerPosition[4])) {  
		 $firstname_error = "Please Enter Position for player Five";  	
	}

	else if ($stmt = $conn->prepare('SELECT ID FROM player_registrations WHERE ParentOneEmail = ?')) {
           
		$stmt->bind_param('s',  $ManagerEmail);
		$stmt->execute();
		$stmt->store_result();

		if ($stmt->num_rows > 0) {
		
		 @$user_found_error='Email exists, please choose another!';
		}else{

			foreach($FirstName as $index=> $FirstNames){
	
			$ManagerEmail=mysqli_real_escape_string($conn, $_POST['ManagerEmail']);
			 $FirstNames = mysqli_real_escape_string($conn, $FirstName[$index]);
			 $LastNames = mysqli_real_escape_string($conn, $LastName[$index]);
			 $months = mysqli_real_escape_string($conn, $month[$index]);
			 $days = mysqli_real_escape_string($conn, $day[$index]);
			 $years = mysqli_real_escape_string($conn, $year[$index]);
			 $JerseyNumbers = mysqli_real_escape_string($conn, $JerseyNumber[$index]);
			 $PlayerPositions = mysqli_real_escape_string($conn, $PlayerPosition[$index]);
			 $dob = $years . "-" . str_pad($months, 2, "0", STR_PAD_LEFT) . "-" . str_pad($days, 2, "0", STR_PAD_LEFT);
			$stmt = $conn->prepare('INSERT into player_registrations (FirstName,LastName,DOB,ParentOneName,ParentOnePhoneOne,
			ParentOneEmail,ParentTwoName,ParentTwoPhoneOne,ParentTwoEmail,Division,Team,PlayerPosition,ForwardedToInsurance,JerseyNumber,CodeOfConduct)
			 values (?, ?, ?, ?,?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?)');
			 $stmt->bind_param('sssssssssssssis', $FirstNames, $LastNames,$dob,$ManagerName,$ManagerPhone,$ManagerEmail,$HeadCoachName,
			 $HeadCoachPhone,$HeadCoachEmail, $bDivision,$team,$PlayerPositions,$Insurance, $JerseyNumbers,$lConduct  );  
					  $stmt->execute();
					  $stmt->close(); 

			 //echo $ManagerEmail.'---'. $FirstNames.'---'.$LastNames.'---'.$JerseyNumbers.'---'. $PlayerPositions.'---'.$dob.'</br>';
		
				
			}
			$mail = new PHPMailer();

						               
							$mail->isSMTP();                                            
							$mail->Host       = 'smtp.gmail.com';                    
							$mail->SMTPAuth   = true;                                  
							$mail->Username   = 'wondwessenh41@gmail.com';                    
							$mail->Password   = '5675673453453';                               
							$mail->SMTPSecure = 'tls';            
							$mail->Port = 587;                                    
						
							//Recipients
							$mail->setFrom('wondwessenh41@gmail.com');
							$mail->addAddress($ManagerEmail);    
							
							$mail->isHTML(true);                               
							$mail->Subject = "ORHL Player Registration  $ManagerName Confirmation";

					
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
                        header("location:player-registration-manage.php");
                         exit();
		}
		
	}else{

	


}
}
?>

<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<title>Team Registration</title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="_registration_style-new.css" media="all" />

</head>
<body id="bodyMain">

<div id="imgWait" style="display:none; width:40%; height:auto; padding:5% 0 5% 0; position:fixed; top:10%; left:30%; text-align:center; background:#FFFFFF;">
	<img src="images/CircleProgress.gif" style="margin:0 auto;" />
</div>
<span id="lblPageError" runat="server" class="Notification"></span>
			
				


	<div class="Wrapper">
		<div class="Header">
			<div class="Logo">
				<img src="" class="ImgLogo" />
			</div>
			<div class="Banner">
				<h1>ORHL Team Registration<br />2022-23 Season</h1>
			</div>
			<div class="ClearAll100"></div>
		</div>
		
		<div class="MainBody">
			<div class="Title">
				<h2>All areas are mandatory unless shown as optional</h2>
				<div id="divConfirmation" class="<?php if (isset($ClassChoice)) echo $ClassChoice ?>"><?php if (isset($error)) echo $error ?></div>
				<span class="text-danger"><?php if (isset($firstname_error)) echo $firstname_error; ?></span></br>
				<span class="text-danger"><?php if (isset($lastname_error)) echo $lastname_error; ?></span>
				<span class="text-danger"><?php if (isset($division_error)) echo $division_error; ?></span>
				<span class="text-danger"><?php if (isset($team_error)) echo $team_error; ?></span>
				<span class="text-danger"><?php if (isset($managername_error)) echo $managername_error; ?></span>
				<span class="text-danger"><?php if (isset($insurance_error)) echo $insurance_error; ?></span>
				<span class="text-danger"><?php if (isset($user_found_error)) echo $user_found_error; ?></span>
			
			</div>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
			<div class="ColLeft">
			Division (Select Before Team)
				<select id="ddlDivision" name="bDivision" runat="server" class="DropNormal" AutoPostBack="true" minilength="1" onchange="fetch_select(this.value);" >
				<option value="">Select Division...</option>
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

			
			   <select id="ddlTeams" name="aDivision" runat="server" class="DropNormal">
                  
			
			  </select>
				Manager Full Name
				<input type="text" id="txtManagerName" name="ManagerName" class="TextBoxNormal" tabindex="" />
				Manager Phone
				<input type="text" id="txtManagerPhone" name="ManagerPhone" class="TextBoxNormal" tabindex="" />
				Manager Email
				<input type="text" id="txtManagerEmail" name="ManagerEmail" class="TextBoxNormal" tabindex="" />
			</div>
			<div class="ColRight">
				Head Coach Name
				<input type="text" id="txtHeadCoachName" name="HeadCoachName" class="TextBoxNormal" tabindex="" />
				Head Coach Phone
				<input type="text" id="txtHeadCoachPhoe" name="HeadCoachPhone" class="TextBoxNormal" tabindex="" />
				Head Coach Email
				<input type="text" id="txtHeadCoachEmail" name="HeadCoachEmail" class="TextBoxNormal" tabindex="" />
				Insurance Co &amp; Pol#
				<input type="text" id="txtInsurance" name="Insurance" class="TextBoxNormal" tabindex="" />
			</div>
			<div class="ClearAll100"></div>
			<div class="Title" style="background-color:#CCCCCC;">
				<h2>Payment</h2>
				<p>
					Deposit (non-refundable) $500.00 due upon registration per event.
					Balance due 45 days prior to event
				</p>
				<p>
					Payments can be made:<br />
					Etransfer to: diane@orhl.net<br />
					For payments by cheque please contact Diane directly.
				</p>
			</div>
			<div class="ColFullWidth">
				<h3>Code of Conduct</h3>
				<div class="TextAreaInfo">
					Please click on the link below and read the ORHL Code of Conduct. 
					Then acknowledge below that you have read it.<br /><br />
					It is also in a printable format.
				</div>
				<a href="pdf/Code-Of-Conduct-ORHL-175.pdf" class="LinkBlock" target="_blank">Full Screen Code of Conduct (PDF) - Here</a>
				<select id="ddlConduct" name="lConduct" class="DropNormal" tabindex="22">
					<option value="">Acknowledge Conduct...</option>
					<option value="Accept" <?php echo (isset($lConduct) && ($lConduct == "Accept" || $lConduct == "1") ? "selected=selected" : '') ?>>I Accept the Code of Conduct</option>
				</select>
				<h3>Ontario Rep Hockey League Waiver</h3>
				<div class="TextAreaInfo">
					<p>
						The undersigned is responsible for the conduct of the player while participating in this program.  
						The player shall be governed by the rules established by the Ontario Rep Hockey League.  
						It is understood that the undersigned person of legal age or legal guardian shall not hold the League or their Administrators, 
						Officials or the facility used liable in the event of injury or loss in any manner whatsoever.
					</p>
					<p>
						I specifically waive, give up and release the Ontario Rep Hockey League, its related companies and their staff from all liability for any 
						claim for damages which I may have relating to injuries or illness that my child may sustain.
					</p>
					<p>
						By agreeing to this waiver, I also certify that my child is in good health, with no chronic illness or abnormal tendencies.  
						The player listed on this registration is registered under the care of the approving party and assumes all risks through enrollment in this program which 
						consists of physical interaction capable of injury. 
						The player must wear all CSA Approved hockey equipment including helmet, full face mask, shin pads, elbow pads, hockey gloves, 
						hockey pants, shoulder pads, neck guard, mouth guard and hockey shirt.
					</p>
					<p>
						The undersigned is responsible for reviewing the &quot;Concussion Recognition, Management and Awareness Protocol&quot; and the &quot;Rowan&rsquo;s Law &ndash; 
						Concussion in Sport Update&quot; as posted on the ORHL website under the League Tab.
					</p>
					<p>
						I have read and understand all items on this player form.
					</p>
					<p>
						I the undersigned agree to allow the Ontario Rep Hockey League and&frasl;or it&rsquo;s related companies to use the participants&rsquo; name 
						and&frasl;or pictures for advertising purposes.
					</p>
					<p>
						I understand that I am permitting the Ontario Rep Hockey League to use my email address for company-related communications.
					</p>
				</div>
				<a href="pdf/ORHL-Waiver-2019.pdf" class="LinkBlock" target="_blank">Full Screen Waiver (PDF) - Here</a>
				
				<select id="ddlWaiver" name ="Waiver" class="DropNormal" tabindex="24">
					<option value="">Acknowledge Waiver...</option>
					<option value="Accept" <?php echo (isset($Waiver) && ($Waiver == "Accept" || $Waiver == "1") ? "selected=selected" : '') ?>>I Accept Release & Waiver</option>
				</select>
			</div> <!-- ends conduct and waiver -->
			<div class="Title">
				<h2>NOTE: Only players with full information will be saved</h2>
			</div>
			<div class="ColFullWidth">
				<table class="TableFull">
					<tr>
						<th>Player<br />First Name</th>
						<th>Player<br />Last Name</th>
						<th class="TextCenter">Jersey Num</th>
						<th>Date of Birth<br />(MM/DD/YYYY)</th>
						<th>Position</th>
					</tr>
					<tr>
						<td class="A"><input type="text" id="txtFirstName_1" name="FirstName[]" class="TextBoxAuto" tabindex="" /></td>
						<td class="A"><input type="text" id="txtLastName_1" name="LastName[]" class="TextBoxAuto" tabindex="" /></td>
						<td class="B"><input type="text" id="txtJerseyNumber_1" name="JerseyNumber[]" class="TextBoxAuto TextCenter" tabindex="" /></td>
						<td class="C" style="width:20%; text-align:left;">
					<select id="ddlMonth" name="month[]" runat="server" class="DropInline" >
						<option value="">Month...</option>
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
					<select id="ddlDay" name="day[]" runat="server" class="DropInline" >
						<option value="">Day...</option>
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
					<select id="ddlYear"name="year[]" runat="server" class="DropInline" >
						<option value="">Year...</option>
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
					    </td>
						<td class="C">
							<select id="ddlPlayerPosition_1" name="PlayerPosition[]" class="DropNormal" tabindex="21">
								<option value="">Select...</option>
								<option value="Goal" <?php echo (isset($PlayerPosition) && $PlayerPosition == "Goal" ? "selected=selected" : '') ?>>Player: Goal</option>
								<option value="Forward/Defence" <?php echo (isset($PlayerPosition) && $PlayerPosition == "Forward/Defence" ? "selected=selected" : '') ?>>Player: Forward/Defence</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="A"><input type="text" id="txtFirstName_2" name="FirstName[]" class="TextBoxAuto" tabindex="" /></td>
						<td class="A"><input type="text" id="txtLastName_2" name="LastName[]" class="TextBoxAuto" tabindex="" /></td>
						<td class="B"><input type="text" id="txtJerseyNumber_2" name="JerseyNumber[]" class="TextBoxAuto TextCenter" tabindex="" /></td>
						<<td class="C" style="width:20%; text-align:left;">
					<select id="ddlMonth" name="month[]" runat="server" class="DropInline" >
						<option value="">Month...</option>
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
					<select id="ddlDay" name="day[]" runat="server" class="DropInline" >
						<option value="">Day...</option>
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
					<select id="ddlYear"name="year[]" runat="server" class="DropInline" >
						<option value="">Year...</option>
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
					    </td>
						<td class="C">
							<select id="ddlPlayerPosition_2" name="PlayerPosition[]" class="DropNormal" tabindex="21">
								<option value="">Select...</option>
								<option value="Goal" <?php echo (isset($PlayerPosition) && $PlayerPosition == "Goal" ? "selected=selected" : '') ?>>Player: Goal</option>
								<option value="Forward/Defence" <?php echo (isset($PlayerPosition) && $PlayerPosition == "Forward/Defence" ? "selected=selected" : '') ?>>Player: Forward/Defence</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="A"><input type="text" id="txtFirstName_3" name="FirstName[]" class="TextBoxAuto" tabindex="" /></td>
						<td class="A"><input type="text" id="txtLastName_3" name="LastName[]" class="TextBoxAuto" tabindex="" /></td>
						<td class="B"><input type="text" id="txtJerseyNumber_3" name="JerseyNumber[]" class="TextBoxAuto TextCenter" tabindex="" /></td>
						<td class="C" style="width:20%; text-align:left;">
					<select id="ddlMonth" name="month[]" runat="server" class="DropInline" >
						<option value="">Month...</option>
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
					<select id="ddlDay" name="day[]" runat="server" class="DropInline" >
						<option value="">Day...</option>
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
					<select id="ddlYear"name="year[]" runat="server" class="DropInline" >
						<option value="">Year...</option>
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
					    </td>
						<td class="C">
							<select id="ddlPlayerPosition_3" name="PlayerPosition[]" class="DropNormal" tabindex="21">
								<option value="">Select...</option>
								<option value="Goal" <?php echo (isset($PlayerPosition) && $PlayerPosition == "Goal" ? "selected=selected" : '') ?>>Player: Goal</option>
								<option value="Forward/Defence" <?php echo (isset($PlayerPosition) && $PlayerPosition == "Forward/Defence" ? "selected=selected" : '') ?>>Player: Forward/Defence</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="A"><input type="text" id="txtFirstName_4" name="FirstName[]" class="TextBoxAuto" tabindex="" /></td>
						<td class="A"><input type="text" id="txtLastName_4" name="LastName[]" class="TextBoxAuto" tabindex="" /></td>
						<td class="B"><input type="text" id="txtJerseyNumber_4" name="JerseyNumber[]" class="TextBoxAuto TextCenter" tabindex="" /></td>
						<td class="C" style="width:20%; text-align:left;">
					<select id="ddlMonth" name="month[]" runat="server" class="DropInline" >
						<option value="">Month...</option>
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
					<select id="ddlDay" name="day[]" runat="server" class="DropInline" >
						<option value="">Day...</option>
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
					<select id="ddlYear"name="year[]" runat="server" class="DropInline" >
						<option value="">Year...</option>
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
					    </td>
						<td class="C">
							<select id="ddlPlayerPosition_4" name="PlayerPosition[]" class="DropNormal" tabindex="21">
								<option value="">Select...</option>
								<option value="Goal" <?php echo (isset($PlayerPosition) && $PlayerPosition == "Goal" ? "selected=selected" : '') ?>>Player: Goal</option>
								<option value="Forward/Defence" <?php echo (isset($PlayerPosition) && $PlayerPosition == "Forward/Defence" ? "selected=selected" : '') ?>>Player: Forward/Defence</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="A"><input type="text" id="txtFirstName_5" name="FirstName[]" class="TextBoxAuto" tabindex="" /></td>
						<td class="A"><input type="text" id="txtLastName_5" name="LastName[]" class="TextBoxAuto" tabindex="" /></td>
						<td class="B"><input type="text" id="txtJerseyNumber_5" name="JerseyNumber[]" class="TextBoxAuto TextCenter" tabindex="" /></td>
						<td class="C" style="width:20%; text-align:left;">
					<select id="ddlMonth" name="month[]" runat="server" class="DropInline" >
						<option value="">Month...</option>
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
					<select id="ddlDay" name="day[]" runat="server" class="DropInline" >
						<option value="">Day...</option>
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
					<select id="ddlYear"name="year[]" runat="server" class="DropInline" >
						<option value="">Year...</option>
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
					    </td>
						<td class="C">
							<select id="ddlPlayerPosition_5" name="PlayerPosition[]"  class="DropNormal" tabindex="21">
								<option value="">Select...</option>
								<option value="Goal" <?php echo (isset($PlayerPosition) && $PlayerPosition == "Goal" ? "selected=selected" : '') ?>>Player: Goal</option>
								<option value="Forward/Defence" <?php echo (isset($PlayerPosition) && $PlayerPosition == "Forward/Defence" ? "selected=selected" : '') ?>>Player: Forward/Defence</option>
							</select>
						</td>
					</tr>
				</table>
				<div class="Title">
					<input type="submit" id="btnSubmit" class="ButtonNormal" name="save" value="Save Registration" tabindex="26" onClick="ShowProgress();" />
				</div>
			</div><!-- closes full width column -->
			
		</div><!-- ends main body -->
	</div><!-- ends wrapper-->
	
</form>

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
