<?php

//Database connection
include_once 'Database_Connect.php';

if(isset($_GET['id'])){
  $projectID= mysqli_real_escape_string($connection, $_GET['id']);
  $sql="DELETE FROM designprotofiloproject WHERE id='$projectID'";
  $result= mysqli_query($connection, $sql);
  if($result){
  echo json_encode("1");
  }
  else{
      echo json_encode("0");
  }
}
?>

