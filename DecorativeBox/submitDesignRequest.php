<?php

//DB connection

$connection = mysqli_connect("localhost", "root", "root", "decorativeBox");

if (mysqli_connect_error()) {
    die("unable to connect" . mysqli_connect_error());
} else {

    //fetching 
    session_start();
    
    $designerId = mysqli_escape_string($connection, $_POST['designerId']);
    $clientID =$_SESSION['user_id'];

    $roomType = mysqli_real_escape_string($connection, $_POST['roomType']);
    $sql = "SELECT id FROM roomtype WHERE type='$roomType'";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $roomTypeID = $row['id'];
    } else {
        echo "<p>Error retrieving roomType id</p>";
    }


    $width = $_POST['width'];

    $length = $_POST['length'];

    $designCategory = mysqli_real_escape_string($connection, $_POST['designCategory']);
    $sql = "SELECT id FROM designcategory WHERE category='$designCategory'";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $categoryID = $row['id'];
    } else {
        echo "<p>Error retrieving category id</p>";
    }

    $colorPreferences = $_POST['colorPreferences'];

    $mydate = date("Y-m-d");

    // insert fetched values into . DB and change status to pending


    $sql = "INSERT INTO designconsultationrequest (clientID,designerID, roomTypeID, designCategoryID,roomWidth, roomLength, colorPreferences,Date ,statusID) VALUES ($clientID,'$designerId',' $roomTypeID','$categoryID','$width ','$length','$colorPreferences','$mydate' ,1)";

    $result = mysqli_query($connection, $sql);

    if ($result) {
        header("Location: ClientHomepage.php");
    } else {
        echo "<p>Error: Not all form data was submitted.</p>";
    }
}
?>
