<?php
//Database connection
include_once 'Database_Connect.php';

if (!$connection) {
    die("Database connection error: " . mysqli_connect_error());
}

//Session Variable
session_start();
$designerID= $_SESSION['user_id'];

?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Other/html.html to edit this template
-->
<html>
    <head>
        <title>Designer Homepage</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link rel="stylesheet" href="DesignerHomePage.css">
    <style>
        .Modern{
          background-color:#E4D8DC;
          color:#C3A4A8;
          padding:0.3em;
          border-radius:1em;
          text-align:center;
       }

        .Bohemian{
          background-color:#FFE3E3;
          color:#FFA3A0;
          padding:0.3em;
          border-radius:1em;
          text-align:center;
       }

        .Coastal{
          background-color:#C9CCD5;
          color:#94969D;
          padding:0.3em;
          border-radius:1em;
          text-align:center;
       }

        .Country{
          background-color:#93B5C6;
          color:#69818E;
          padding:0.3em;
          border-radius:1em;
          text-align:center;
       }
       
         #linkOut{
               padding:1px 10px;
               background-color:#C9CCD5;
               color: #333333; 
               font-weight: bold;
               margin-right:1em;
               letter-spacing: 1px;
               border:1px solid black;
               line-height:30px;
               transition: .5s ease;
               box-shadow:3px 3px 1px 1px #C9CCD5, 3px 3px 1px 2px black; 
               position:absolute;
               right:5px;
               top:20px;
             }
  
           #linkOut:hover{
             color:white;
             background-color:#93B5C6;
             border:1px solid black;
            }  
    </style>
    </head>
    <body>
            
        <header>
             <div class="logo">
            <img src="images/logo.png" alt="Logo">
        </div>
            
          <div id="logout">
         <a href="logout.php" id='linkOut'>Log-out</a>
       </div>
            
        </header>
        <main>
        <section>
       <div class="Designer-info">
           <?php
           $sql1="SELECT * FROM designer WHERE id='$designerID'";
           $result1= mysqli_query($connection, $sql1);
           if($result1){
               $row= mysqli_fetch_assoc($result1);
           echo "<h1>Welcome, ".$row["firstName"]."</h1>";
           echo "<div class='welcome-box'><pre>".$row["firstName"]."'s Information:"."<br>";
           echo $row["firstName"]." ".$row["lastName"]."<br>";
           echo $row["emailAddress"]."<br>";
           $sql2 ="SELECT designcategory.category FROM designerspeciality
            INNER JOIN designcategory ON designerspeciality.designCategoryID = designcategory.id
            WHERE designerspeciality.designerID = '$designerID'";
$result2 = mysqli_query($connection, $sql2);
if ($result2) {
    $speciality = "";
    $numOfRows = 0;
    while ($row2 = mysqli_fetch_assoc($result2)) {
        $speciality .= $row2['category'];
        $numOfRows++;
        if ($numOfRows < mysqli_num_rows($result2)) {
            $speciality .= ",";
        }
    }
} else {
    echo "<p>Couldn't retrieve Specialty</p>";
}

           
           echo "Specialty: ".$speciality."<br>";
           echo "Brand's Name: ".$row["brandName"]."<br>";
           echo "<img height='150' width='150' src='imagesUploads/".$row['logoImgFileName']."' alt='".$row['logoImgFileName']."'>";
           }
           else{
               echo "<p> Couldn't retrieve designer's id";
           }
           ?>
       </div>
 <h2>Designer Portfolio</h2>
  <a href="ProjectAddition.php" id='special'>Add new project</a>
  
  <?php
  $table="<table>";
  $table .="<thead><tr><th>Project Name</th><th>Image</th><th>Design Category</th><th>Description</th><th colspan='2' class='colorChange'></th></tr></thead>";
  $table .="<tbody>";
  $sql3="SELECT * FROM designprotofiloproject WHERE designerID='$designerID'";
  $result3= mysqli_query($connection, $sql3);
  if($result3){
   while($row= mysqli_fetch_assoc($result3)){
      $table .="<tr id='P".$row['id']."'><td>" .$row['projectName']."</td>";
      $categoryID=$row['designCategoryID']; 
      $sql2="SELECT category FROM designcategory WHERE id='$categoryID'";
      $result2= mysqli_query($connection, $sql2);
      if($result2){
         $row2= mysqli_fetch_assoc($result2);
         $category=$row2['category'];
         
      }
      else{
       echo "<p>Error retrieving category</p>";
     }
      $table .="<td>"."<img src='imagesUploads/".$row['projectImgFileName']."'". "alt='".$row['projectImgFileName']."'>"."</td>";
      $table .="<td><p class='".$category."'>".$category."</p></td>";
      $table .="<td>".$row['description']."</td>";
      $table .="<td><a href='projectUpdate.php?id=".$row['id']."'>"."Edit</a></td>"; 
      $table .="<td><a href='#' onclick='deleteRow(".$row['id'].");return false;'>"."Delete</a></td></tr>";
   }   
   $table .="</tbody></table>";
   echo $table;
  }
  else{
      echo "<p>Couldn't retrieve designer protofolio</p>";
  }
  ?>
        
        </section>
            
        <section>
        <!-- Design Consultation Requests -->
         <h2>Consultation Requests</h2>
             <?php

$sql = "SELECT designconsultationrequest.id, client.firstName, client.lastName, roomtype.type, 
        designconsultationrequest.roomWidth, designconsultationrequest.roomLength, 
        designcategory.category, designconsultationrequest.colorPreferences, 
        designconsultationrequest.date
        FROM designconsultationrequest
        INNER JOIN client ON designconsultationrequest.clientID = client.id
        INNER JOIN roomtype ON designconsultationrequest.roomTypeID = roomtype.id
        INNER JOIN designcategory ON designconsultationrequest.designCategoryID = designcategory.id
        WHERE designconsultationrequest.statusID = (SELECT id FROM requeststatus WHERE status = 'pending consultation')
        AND designconsultationrequest.designerID = $designerID";

$result = mysqli_query($connection, $sql);
if ($result) {
    echo "<table>";
    echo "<thead><tr><th>Client Name</th><th>Room Type</th><th>Room dimensions</th>
          <th>Design Category</th><th>Color Preferences</th><th>Date</th>
          <th colspan='2' class='colorChange'></th></tr></thead>";
    echo "<tbody>";
    while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr id='R" . $row['id'] . "'>";
    echo "<td>".$row['firstName']." ".$row['lastName']."</td>";
    echo "<td>".$row['type']."</td>";
    echo "<td>".$row['roomWidth']."*".$row['roomLength']." m"."</td>";
    echo "<td>".$row['category']."</td>";
    echo "<td>".$row['colorPreferences']."</td>";
    echo "<td>".$row['date']."</td>";
    echo "<td><a href='DesignConsultation.php?id=".$row['id']."'>Provide Consultation</a></td>";
    echo "<td><a href='#' onclick=\"declineConsultation(" . $row['id'] . "); return false;\">Decline Consultation</a></td>";
    echo "</tr>";
}
    echo "</tbody></table>";
} else {
    echo "<p>Ther is No pending consultation requests for you</p>";
}
?>
        </section>
        </main>
    </body>
    <script>
       
            function deleteRow(rowID){
        $.ajax({
            type:"GET",
            url:"deleteProject.php?id="+rowID,
            success:function(response){
                var deleteResonse = JSON.parse(response);
            if(deleteResonse=="1"){
                document.getElementById("P"+rowID).remove();
            }
            else{
                alert("An error occurred!! couldn't delete the row");
             }
            }
        });
    }
    
    function declineConsultation(requestID) {
        //send an ajax GET request to declineConsultation.php with the requestID
        $.ajax({
            type: "GET",
            url: "declineConsultation.php?id="+requestID,
            success: function (response) {
               //parse the json response from the server
                var declineResponse = JSON.parse(response);
            if (declineResponse=="1") {
                 // If the server response indicates success remove the table row from the dom
                 $("tr[id='R" + requestID + "']").remove();

    }
    else {
         alert("An error occurred!! couldn't delete the row");
    }
}
        });
    }
    
    </script>
</html>
