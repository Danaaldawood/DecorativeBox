<?php

$connection=mysqli_connect("localhost", "root", "root", "decorativebox");
$error=mysqli_connect_error();
if($error){
    $output="<p>Couldn't connect to the database</p>";
    exit($output);
}

?>

