<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Other/html.html to edit this template
-->

<?php

if (isset($_GET['id'])) { // comment it to test
 $connection= mysqli_connect("localhost", "root", "root","decorativeBox");
    if(mysqli_connect_error()){
    die("unable to connect".mysqli_connect_error());}
  
        
        $id=$_GET['id'];
        
 //test using reqID
    
 $sql = "SELECT client.firstName, 
               client.lastName, 
               roomtype.type AS roomType, 
               designconsultationrequest.roomWidth, 
               designconsultationrequest.roomLength, 
               designcategory.category AS designCategory, 
               designconsultationrequest.colorPreferences, 
               designconsultationrequest.date
        FROM designconsultationrequest
        INNER JOIN roomtype ON designconsultationrequest.roomTypeID = roomtype.id
        INNER JOIN designcategory ON designconsultationrequest.designCategoryID = designcategory.id
        INNER JOIN client ON designconsultationrequest.clientID = client.id
        WHERE designconsultationrequest.id = '$id'";



$result = mysqli_query($connection, $sql);
   

    
    






 }
?>
<html >
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Design Consultation</title>
<link rel="stylesheet" href="DesignConsultation.css">

</head>
<body>

  <div id="logout">
                <a href="logout.php" id="btn">Log-out</a>
            </div>
<div class="background-container">
   
    <div class="div1">
   
        <h1>Design Consultation</h1>
        
        <div class="request-info">
            <strong>Request Information</strong>
            
            <?php     
        //fetching and display the request info from db to provide consultation
             
while($row = mysqli_fetch_assoc($result)){
    echo "<p>Client: " . $row['firstName'] . " " . $row['lastName'] . "</p>"; 
    echo "<p>Room: " . $row['roomType'] . "</p>"; 
    echo "<p>Dimensions: " . $row['roomWidth'] . " x " . $row['roomLength'] . "m"."</p>"; 
    echo "<p>Design Category: " . $row['designCategory'] . "</p>"; 
    echo "<p>Color Preferences: " . $row['colorPreferences'] . "</p>"; 
    echo "<p>Date: " . $row['date'] . "</p>"; 
}
         
        
     ?>
           
     
        </div>
        
        <form action="submitDesignConsultation.php" method="POST" enctype="multipart/form-data" >
            <div class="form-section">
                <label for="consultation">Consultation:</label>
                <textarea id="consultation" name="consultation" rows="3" required></textarea>
            </div>
            
            <div class="form-section">
                <label for="image">Upload Image:</label>
                <input type="file" id="image" name="file">
            </div>
            <input type="hidden" name="requestID" value="<?php echo  $id; ?>">
            <input type="submit" value="Send" name="submit">
        </form>
    </div>
</div>

</body>
</html>
