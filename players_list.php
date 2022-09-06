<?php


session_start();
  require_once "db.php";
  include("functions.php");
  $user_data = check_login($conn);

include('includes/header.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List of Items</title>
     <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header" style= "background-color: green; margin-top:10px; color:white ; text-align: center;padding:2px;">
                    <h2>Player's Info</h2>
                </div>
               
               

               you want to add Players?<a href="player-registration.php" class="mt-3">Click Here</a><br><br>
               
                <table class="table table-bordered">
        <thead>
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>date of birth</th>
            <th>Address</th>
            <th>Address two</th>
            <th>City</th>
            <th>Province</th>
            <th>Postal Code</th>
            <th>Division</th>
            <th>Team</th>
        
          
          </tr>
        </thead>
        <tbody>

          <?php
          $query = "SELECT * FROM player_registrations";
          $result_tasks = mysqli_query($conn, $query);    

          while($row = mysqli_fetch_assoc($result_tasks)) { ?>
          <tr>
          
            <td><?php echo $row['FirstName']; ?></td>
            <td><?php echo $row['LastName']; ?></td>
            <td><?php echo $row['DOB']; ?></td>
            <td><?php echo $row['Address']; ?></td>
            <td><?php echo $row['Address2']; ?></td>
            <td><?php echo $row['City']; ?></td>
            <td><?php echo $row['Province']; ?></td>
            <td><?php echo $row['PostalCode']; ?></td>
            <td><?php echo $row['Division']; ?></td>
            <td><?php echo $row['Team']; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <div class="page-header" style= "background-color: green; margin-top:10px; color:white ; text-align: center;padding:2px;">
                    <h2>Parent's Info</h2>
                </div>
                <br>
      <table class="table table-bordered">
        <thead>
          <tr>
          
            <th> Parent One Name</th>
            <th>Parent One Phone One</th>
            <th>Parent One Phone Two</th>
            <th>Parent One Email</th>
            <th> Parent Two Name</th>
            <th>Parent Two Phone One</th>
            <th>Parent Two Phone Two</th>
            <th>Parent Two Email</th>
           
            
        
          
          </tr>
        </thead>
        <tbody>

          <?php
          $query = "SELECT * FROM player_registrations";
          $result_tasks = mysqli_query($conn, $query);    

          while($row = mysqli_fetch_assoc($result_tasks)) { ?>
          <tr>
         
            <td><?php echo $row['ParentOneName']; ?></td>
            <td><?php echo $row['ParentOnePhoneOne']; ?></td>
            <td><?php echo $row['ParentOnePhoneTwo']; ?></td>
            <td><?php echo $row['ParentOneEmail']; ?></td>
            <td><?php echo $row['ParentTwoName']; ?></td>
            <td><?php echo $row['ParentTwoPhoneOne']; ?></td>
            <td><?php echo $row['ParentTwoPhoneTwo']; ?></td>
            <td><?php echo $row['ParentTwoEmail']; ?></td>
      

          
          </tr>
          <?php } ?>
        </tbody>
      </table>
            </div>
        </div>     
    </div>
</body>
</html>

