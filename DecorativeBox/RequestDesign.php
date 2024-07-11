<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Other/html.html to edit this template
-->
<?php
// DB connections
$connection = mysqli_connect('localhost', 'root', 'root', 'decorativebox');

if (!$connection) {
    die("Database connection error: " . mysqli_connect_error());
}{
    //
   if (isset($_GET['designerID'])) {//comment it to test
        $designerID = mysqli_escape_string($connection, $_GET['designerID']);//comment it to test
    }
}//comment it to test
?>

<!--
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Request Design</title>
        <link rel="stylesheet" href="RequestDesign.css">
    </head>
    <body>
  <div id="logout">
                <a href="logout.php" id="btn">Log-out</a>
            </div>
        <div class="background-container">
            <div class="div1">
                <h1>Request Design </h1>
                
                <!--
                When the form is submitted, it sends a request for a PHP page
                -->


                <form action="submitDesignRequest.php" method="POST">
                    <div class="form-section">
                        <label for="roomType">Room Type:</label>
                        <select id="roomType" name="roomType" >
                            <option value="Living Room" >Living Room</option> 

                            <option value="bedroom">Bedroom</option>
                            <option value="kitchen">Kitchen</option>
                            <option value="bathroom">Bathroom</option>
                        </select>
                    </div>

                    <div class="form-section">
                        <label for="width">Width (m):</label>
                        <input type="text" id="width" name="width" placeholder="Width" required="">
                    </div>

                    <div class="form-section">
                        <label for="length">Length (m):</label>
                        <input type="text" id="length" name="length" placeholder="Length" required="">
                    </div>

                    <div class="form-section">
                        <label for="designCategory">Design Category:</label>
                        <select id="designCategory" name="designCategory">
                            <option value="Modern">Modern</option>
                            <option value="Country">Country</option>
                            <option value="Coastal">Coastal</option>
                            <option value="Bohemian">Bohemian</option>
                        </select>
                    </div>

                    <div class="form-section">
                        <label for="colorPreferences">Color Preferences:</label>
                        <input type="text" id="colorPreferences" name="colorPreferences" placeholder="E.g., Beige and Green" required="">
                    </div>
                    <input type="hidden" name="designerId" value="<?php echo $designerID; ?>">
                    <input type="submit" value="SUBMIT">
                </form>
            </div>
        </div>


    </body>
</html>



