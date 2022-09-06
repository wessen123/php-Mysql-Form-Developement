<?Php
$column_name=$_POST['column_name'];
$id=$_POST['id'];
if(!ctype_alpha($column_name)){
echo " Data error ";
exit;
}
require_once "db.php"; // database connection details stored here
$q=" UPDATE player_registrations SET $column_name = !$column_name WHERE ID=? ";
$stmt = $conn->prepare($q);
if($stmt){
$stmt->bind_param('i',  $id );
$stmt->execute();	
$msg="Data Updated for : $column_name ";
$sql=  "SELECT $column_name FROM player_registrations WHERE ID=? ";
if($stmt1 = mysqli_prepare($conn, $sql)){    
    mysqli_stmt_bind_param($stmt1, "i", $id);
    
    
    if(mysqli_stmt_execute($stmt1)){
         $rs = mysqli_stmt_get_result($stmt1);

            while($teams = mysqli_fetch_assoc($rs))
            {
             $msg1=$teams[$column_name];
                
 
            }	

     }
}	
}else {
$msg="No Data Updated for : $column_name ";		
}
echo "$msg";
echo  ($msg1 =='checked' ? 'Yes': 'No');


	

?>