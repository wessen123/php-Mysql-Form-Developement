<?php ?>
<?php
  require_once "db.php";
  include('includes/header.php');

        $firstname = "";
        $lastname = "";
        $email = "";
        $address ="";
       $error = "";
  

  
    if (isset($_POST['save'])) {

    
        $firstname = mysqli_real_escape_string($conn, $_POST['first_name']);
        $lastname = mysqli_real_escape_string($conn, $_POST['last_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        

        if (empty($firstname)) {  
             $firstname_error = "Please Enter Your First Name";  
        }else if (empty($lastname)) {  
             $lastname_error = "Please Enter Your Last Name";  
        } else if(!preg_match("/^[a-zA-Z ]+$/",$firstname)) {
             $firstname_error = "Name must contain only alphabets and space";
        }else if(!preg_match("/^[a-zA-Z ]+$/",$lastname)) {
             $lastname_error = "Name must contain only alphabets and space";
        }else if (empty($email)) {  
             $address_error = "Please Enter your Email";  
        }else if (empty($address)) {  
             $address_error = "Please Enter your Address";  
        }

        else if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            $email_error = "Please Enter Valid Email ID";
        }
      
       else if ($stmt = $conn->prepare('SELECT uid FROM users WHERE email = ?')) {
           
            $stmt->bind_param('s',  $email);
            $stmt->execute();
            $stmt->store_result();
            // Store the result so we can check if the account exists in the database.
            if ($stmt->num_rows > 0) {
                // email already exists
                $user_found_error='Email exists, please choose another!';
            } else {
               
                if (!$error) {

                    $query = "INSERT INTO users (first_name,last_name, email, address)
                    VALUES(?, ?, ?, ?)";
                   
                  if  ($stmt = mysqli_prepare($conn, $query)){
                        mysqli_stmt_bind_param($stmt, 'ssss', $firstname,  $lastname, $email,$address);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_close($stmt);
                        header("location: user_list.php");
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
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 ">
                <div class="page-header" >
                    <h3> Submission Form  </h3>
                </div>
                <p>Please fill all fields in the form</p>
                <span class="text-danger"><?php if (isset($user_found_error)) echo $user_found_error; ?></span>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="first_name" class="form-control" value="" maxlength="50" required="">
                        <span class="text-danger"><?php if (isset($firstname_error)) echo $firstname_error; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="" maxlength="50" required="">
                        <span class="text-danger"><?php if (isset($lastname_error)) echo $lastname_error; ?></span>
                    </div>
                    <div class="form-group ">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="" maxlength="30" required="">
                        <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" value="" maxlength="50" required="">
                        <span class="text-danger"><?php if (isset($address_error)) echo $address_error; ?></span>
                    </div>
                  

                    <input type="submit" class="btn btn-success btn-block" name="save" value="submit">
                     Go to Users lists?<a href="user_list.php" class="btn btn-default">Users List</a>
                   
                </form>
            </div>
        </div>    
    </div>
</body>
</html>
