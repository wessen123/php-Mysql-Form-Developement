

<?php
// Process delete operation after confirmation

    // Include config file
    session_start();
    require_once "db.php";
    include("functions.php");
    $user_data = check_login($conn);
    

    $sql=  "SELECT * FROM player_registrations WHERE ID = ?";
   $stmt = mysqli_prepare($conn, $sql);   
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = trim($_GET["idd"]);
        
        if(mysqli_stmt_execute($stmt)){
             $rs = mysqli_stmt_get_result($stmt);
    
                while($teams = mysqli_fetch_assoc($rs))
                {
               $file=  $teams['FileName'];
                }	
                unlink('documents/' . $file);
         }
    
     


    // Prepare a delete statement
    $sql = "DELETE FROM player_registrations WHERE ID = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["idd"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to landing page
            header("location: player-registration-manage.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($conn);


?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Delete Record</h2>
                    <form action="" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="idd" value="<?php echo trim($_GET["idd"]); ?>"/>
                            <p>Are you sure you want to delete this player record?</p>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="index.php" class="btn btn-secondary">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html> -->