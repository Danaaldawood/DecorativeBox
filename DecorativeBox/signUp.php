 <?php
    //Session Variable
    session_start();
    
    //Database connection
    include_once 'Database_Connect.php';
    if (!$connection) {
        echo "Error connecting to the database: " . mysqli_connect_error();
    } else {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['designerSubmit'])) {
                
                // Check if all required fields in the signup form are not empty and all are defined
                if (isset($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['password'], $_POST['brandName'], ($_POST['Category'])) && !empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['brandName'])) {
                    
                     //escape user input and store it
                    $firstName = mysqli_real_escape_string($connection, $_POST['firstName']);
                    $lastName = mysqli_real_escape_string($connection, $_POST['lastName']);
                    $email = mysqli_real_escape_string($connection, $_POST['email']);
                    $password = mysqli_real_escape_string($connection, $_POST['password']);
                    $brandName = mysqli_real_escape_string($connection, $_POST['brandName']);
                    
                    //Upload photo to server
                    $file = $_FILES['logoInput'];
                    $fileName = $file['name'];
                    $fileTmpName = $file['tmp_name'];
                    $fileError = $file['error'];
                    $fileExt = explode('.', $fileName);
                    $fileActualExt = strtolower(end($fileExt));
                    $allowed=array('gif','jpg','jpeg','webp','avif','png');
                    if (in_array($fileActualExt, $allowed)) {
                        if ($fileError === 0) {
                                $filenameNew = uniqid('', true) . "." . $fileActualExt;
                                $fileDes = 'imagesUploads/' . $filenameNew;
                                move_uploaded_file($fileTmpName, $fileDes);
                        } else {
                            echo "<div class='error-message'>There is an error while uploading your logo image</div>";
                        }
                    } else {
                        echo "<div class='error-message'>Unsupported photo extension</div>";
                    }

                    //check if the user is exsisting in the database
                    $sql = "SELECT * FROM designer WHERE emailAddress='$email'";
                    $result = mysqli_query($connection, $sql);
                    if (!$result) {
                        echo "Error executing query ".mysqli_connect_error();
                    } else {
                        if ($result && mysqli_num_rows($result) > 0) {
                            echo"<div class='error-message'>This Account is Already exist</div>";
                        } else {
                            
                            //hash the password before store it in the database 
                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                            
                            //insert the user to the appropriate table in the database
                            $sql2 = "INSERT INTO designer(firstName, lastName, emailAddress, password, brandName, logoImgFileName) VALUES('$firstName','$lastName', '$email', '$hashedPassword', '$brandName', '$filenameNew')";
                            $result2 = mysqli_query($connection, $sql2);
                            if ($result2) {
                                
                                // Get the designer ID
                                $designerID = mysqli_insert_id($connection);
                                //save the user id and type in the sesstion
                                $_SESSION['user_id'] = $designerID;
                                $_SESSION['user_type'] = 'designer';

                                //make sure the category is set and store it in array
                                $categories = isset($_POST['Category']) ? $_POST['Category'] : [];
                                
                                //fetch the categories to designerspeciality table based on the selected categories
                                foreach ($categories as $category) {
                                    $categoryID = mysqli_real_escape_string($connection, $category);
                                    $sql = "SELECT id FROM designcategory WHERE category='$categoryID'";
                                    $result = mysqli_query($connection, $sql);
                                    if ($result) {
                                        $row = mysqli_fetch_assoc($result);
                                        $categoryID = $row['id'];
                                        $sql3 = "INSERT INTO designerspeciality(designerID, designCategoryID) VALUES('$designerID', '$categoryID')";
                                        $result3 = mysqli_query($connection, $sql3);
                                        if ($result3) {
                                            //if all the queries successes then redirect the user to its appropriate homepage
                                            header("Location: DesignerHomepage.php");
                                        } else {
                                            echo "Error inserting designer specialty ".mysqli_error($connection);
                                        }
                                        
                                    } else {
                                        echo "<p>Error retrieving category id </p>".mysqli_connect_error();
                                    }
                                }
                            } else {
                               echo "<p>Error inserting user information </p>".mysqli_connect_error();
                            }
                        }
                    }
                } else {
                    echo "<div class='error-message'>Please enter valid information</div>";
                }
            }//Designer End

            if (isset($_POST['clientSubmit'])) {
                
                // Check if all required fields in the signup form are not empty and all are defined
                if (isset($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['password']) && !empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['email']) && !empty($_POST['password'])) {
                    
                    //escape user input and store it
                    $firstName = mysqli_real_escape_string($connection, $_POST['firstName']);
                    $lastName = mysqli_real_escape_string($connection, $_POST['lastName']);
                    $email = mysqli_real_escape_string($connection, $_POST['email']);
                    $password = mysqli_real_escape_string($connection, $_POST['password']);

                    //check if the user is exsisting in the database
                    $sql1 = "SELECT * FROM client WHERE emailAddress='$email'";
                    $result1 = mysqli_query($connection, $sql1);
                    if (!$result1) {
                        echo "Error executing query".mysqli_connect_error();
                    } else {
                        if (mysqli_num_rows($result1) > 0) {
                            echo "<div class='error-message'>This Account is Already exist</div>";         
                        } 
                        else {
                            //hash the password before store it in the database 
                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                            
                            //insert the user to the appropriate table in the database
                            $sql2 = "INSERT INTO client(firstName, lastName, emailAddress, password) VALUES('$firstName','$lastName', '$email', '$hashedPassword')";
                            $result2 = mysqli_query($connection, $sql2);
                            if ($result2) {
                                //save the user id and type in the sesstion
                                $clientID = mysqli_insert_id($connection);
                                $_SESSION['user_id'] = $clientID;
                                $_SESSION['user_type'] = 'Client';
                                
                                //if all the queries successes then redirect the user to its appropriate homepage
                                header("Location: ClientHomepage.php");
                            } 
                            else {
                                echo "Error inserting user information ".mysqli_connect_error();
                            }
                        } 
                    }
                } else {
                    echo "<div class='error-message'>Please enter valid information</div>";
                }
            }
        }
    }
    ?>

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Other/html.html to edit this template
-->
<html>
    <head>
        <title>Sign Up</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="SignUp.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            .error-message {
                background-color: #FFE3E3;
                padding: 10px;
                text-align: center;
                font-weight: bold;
                font-size: 20px;
            }


            .checkboxContainer{
                max-width: 1200px;
                margin: 0 auto;
                display: flex;
                flex-wrap: wrap;
            }

            .checkboxContainer div{
                margin: 10px;
            }

            .checkboxContainer div label{
                cursor: pointer;
            }

            .checkboxContainer div label input[type="checkbox"]{
                display: none;
            }

            .checkboxContainer div label span{
                position: relative;
                display: inline-block;
                background: #C9CCD5;
                padding: 10px 10px;
                color: gray;
                text-shadow: 0 1px 6px rgba(0,0,0,0.3);
                border-radius: 30px;
                font-size: 17px;
                transition: 0.5s;
                overflow: hidden;

            }

            .checkboxContainer div label span::before{
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 50%;
                background: rgba(255,255,255,0.2)
            }

            .checkboxContainer div label input[type="checkbox"]:checked + span {
                background: #93B5C6;
                color: #fff;
                box-shadow: 0 2px 2px #84a2b2;
            }
        </style>
    </head>
    
    <body>
        <header>
            <div class="logo">
                <img src="images/logo.png" alt="Logo" height="200" width="250">
                <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            </div>
        </header>



        <!-- designer page-->

        <div class="split-screen">
            <div class="left-side">
                <div class="page1" style="display: none;">
                    <div class="signUpForm" id="designerForm">
                        <img class="userimg" src="images/UserImg.png" alt="">

                        <h1>Sign Up</h1>
                        <form action="signUp.php" method="POST" enctype="multipart/form-data">

                            <div class="nameGroup">
                                <input type="text" class="input" name="firstName" placeholder="First Name" required> 
                                <input type="text" class="input" name="lastName" placeholder="Last Name" required> 
                            </div>

                            <input type="email" class="input" name="email" placeholder="Email" required> 

                            <div class="passBox">
                                <input type="password" class="input password" name="password" placeholder="Password" required>
                                <img src="images/closeEye.png" class="eye" alt="">
                            </div>

                            <input type="text" class="input" name="brandName" placeholder="Brand's Name" required>  
                            <br>

                            <div class="category-section">
                                <p>Specialty:</p>
                                <div class="checkboxContainer">
                      
<?php
//Display the categories retrieved from the database in the checkbox
$sql = "SELECT category FROM designcategory";
$result = mysqli_query($connection, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div ><label><input type='checkbox' name='Category[]' value='" . $row['category'] . "'><span>" . $row['category'] . "</span></label></div>";
    }
} else {
    echo "Error fetching categories ". mysqli_connect_error();
}
?>
                                </div>
                            </div>

                            <br>
                            <div class="uploadLogo">
                                <label for="logoInput" class="logoButton">
                                    <i class="material-icons">add_photo_alternate</i>&nbsp; Upload Logo
                                </label>
                                <input type="file" name="logoInput" id="logoInput" style="display: none;" required accept="image/*">
                            </div>
                            <br>

                            <button type="submit" class="signUpButton" name="designerSubmit">Sign Up</button>

                        </form>
                    </div>
                </div>

                <!--client page-->

                <div class="page2" style="display: none;">

                    <div class="signUpForm"  id="clientForm">
                        <form action="signUp.php" method="POST">
                            <img class="userimg" src="images/UserImg.png" alt="">
                            <h1>Sign Up</h1>

                            <div class="nameGroup">
                                <input type="text" class="input" name="firstName" placeholder="First Name" required> 
                                <input type="text" class="input" name="lastName" placeholder="Last Name" required> 
                            </div>

                            <input type="email" class="input" name="email" placeholder="Email" required>

                            <div class="passBox">
                                <input type="password" class="input password" name="password" placeholder="Password" required>
                                <img src="images/closeEye.png" class="eye" alt="">
                            </div>


                            <button type="submit" class="signUpButton" name="clientSubmit">Sign Up</button>

                        </form>
                    </div>
                </div>
            </div> 


            <!-- Sign up as -->
            <div class="right-side" >
                <div class="container">
                    <h2>Sign Up As:</h2>
                    <div class="radio-title-group">
                        <div class="input-container">
                            <input type="radio" name="option" id="option1" value="1" onclick="showPage(1)">
                            <div class="radio-title">
                                <label class="radio-container" for="option1">Designer</label>
                            </div>
                        </div>
                        <div class="input-container">
                            <input type="radio" name="option" id="option2" value="2" onclick="showPage(2)">
                            <div class="radio-title">
                                <label class="radio-container" for="option2">Client</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function showPage(val) {
                if (val === 1) {
                    document.querySelector('.page1').style.display = 'block';
                    document.querySelector('.page2').style.display = 'none';
                } else if (val === 2) {
                    document.querySelector('.page1').style.display = 'none';
                    document.querySelector('.page2').style.display = 'block';
                } else {
                    document.querySelector('.page1').style.display = 'none';
                    document.querySelector('.page2').style.display = 'none';
                }
            }

            //------------------------The Eye icon code------------------------//    

            let eyes = document.getElementsByClassName("eye");
            let passwords = document.getElementsByClassName("password");

            for (let i = 0; i < eyes.length; i++) {
                eyes[i].onclick = function () {
                    if (passwords[i].type == "password") {
                        passwords[i].type = "text";
                        eyes[i].src = "images/openEye.png";
                    } else {
                        passwords[i].type = "password";
                        eyes[i].src = "images/closeEye.png";
                    }
                }
            }

        </script>

    </body>
</html>