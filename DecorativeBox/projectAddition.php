<?php
//Database connection
include_once 'Database_Connect.php';
//Session Variable
session_start();
$designerID= $_SESSION['user_id'];
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'designer') {
    echo "Session variables not set correctly or user type mismatch.";
}
//Check if the form is submitted
if($_SERVER["REQUEST_METHOD"]=="POST"){
    
    //Check if picture is submitted and the picture has a name so it can be stored
    if(isset($_FILES['Photo']) && !empty($_FILES['Photo']['name'])){
      $photoName=mysqli_real_escape_string($connection, $_FILES['Photo']['name']);
      
      //Upload photo to server
      
      //Where the photo is temporarily stored
      $photoTmpName=$_FILES['Photo']['tmp_name'];
      
      //extenstion of photo:png,gif,...etc
      $PhotoExt= strtolower(pathinfo($photoName,PATHINFO_EXTENSION));
      //error while uploading: 0 no error 1 there is an error
      $photoError=$_FILES['Photo']['error'];
      //allowed extensions on website: only photo etensions
      $allowed=array('gif','jpg','jpeg','webp','avif','png');
      //If the file is a photo with the following extenstion
      if(in_array($PhotoExt,$allowed)){
          //if photo is submitted with no errors
      if($photoError===0){    
          //Unique name for the photo
      $newPhotoName= uniqid('',true).".".$PhotoExt;
         //Server directories of the photos
      $PhotoDestination="imagesUploads/".$newPhotoName;
         //Change photo storage to the server directory
      move_uploaded_file($photoTmpName, $PhotoDestination);}
      else{
          echo "<p>There is an error while uploading</p>";
      }
      }
      else{
       echo "<p> Unsupported photo extension </p>";
      }
    }
   //Retrieve all designer's info from the form 
   $name= mysqli_real_escape_string($connection, $_POST['Name']); 
   $category=mysqli_real_escape_string($connection, $_POST['Category']); 
   $description=mysqli_real_escape_string($connection, $_POST['description']);
   $sql="SELECT id FROM designcategory WHERE category='$category'";
   $result= mysqli_query($connection, $sql);
   if($result){
       $row= mysqli_fetch_assoc($result);
       $categoryID=$row['id'];
   }
   else{
       echo "<p>Error retrieving category id</p>";
   }
   //Insert query
   $sql="INSERT INTO designprotofiloproject(designerID,projectName,projectImgFileName,description,designCategoryID) VALUES('$designerID','$name','$newPhotoName','$description','$categoryID')";
   $result= mysqli_query($connection, $sql);
   if(!$result){
      echo "<p>Error insertion</p>";
   }
   else{
       header("Location: DesignerHomepage.php ");
   }


   
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Project addition</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="ProjectAddition.css">
        <style>
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
     
        <div id='left'>
            <img src='images/logo.png' alt='logo' id='logo'>
            <img src='images/gg.png' alt='' id='img1'> 
        </div>
        <div id='right'>
        <form method='POST' enctype='multipart/form-data'>
            <fieldset>
                <legend>Project addition</legend>
                <label for="designName"><br>Project's name:<br></label>
                    <input type="text" name="Name" value="" id="designName" required>
                <br>   
                    <p>Project's photo:</p>
                    <div class="oneLine">
                    <label for="designPhoto" id="spec"><img src="images/camera.png" alt="choose a photo" id="specPhoto"></label>
                    <p id="specText">Choose a photo</p>
                    <input type='file' name='Photo' id="designPhoto" accept="image/*">
                    </div>
                <br>
                <label for="category">Design category:<br></label>
                    <div  id="designCategory" class="custselect">
                    <select name='Category' id="category" required>
                        <option value="" disabled selected hidden>Select</option>
                        <?php
                        //Display the categories retrieved from the database in the select
                        $sql="SELECT category FROM designcategory";
                        $result= mysqli_query($connection, $sql);
                        if($result){
                            while ($row = mysqli_fetch_assoc($result)) {
                              echo "<option value='".$row['category']."'>".$row['category']."</option>";
                            }
                        }
                        else{
                            echo "<p>Error</p>";
                        }
                        ?>
                    </select>
                    <span id="arrow"></span>
                    </div>
                <br>
                <label for="designDescr">Project's description:<br></label>
                    <textarea name='description' rows="8" cols="80" id="designDescr" required></textarea>
                <br>
                    <input type="submit" id="btn">
            </fieldset>
        </form>
        </div>
        
        <div id="logout">
         <a href="logout.php" id='linkOut'>Log-out</a>
       </div>
        
    </body>
</html>

