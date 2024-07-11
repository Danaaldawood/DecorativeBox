<?php

$connection = mysqli_connect("localhost", "root", "root", "decorativeBox");

if (mysqli_connect_error()) {
    die("unable to connect" . mysqli_connect_error());
} else {



    $targetDir = "imagesUploads/";

    if (isset($_POST['submit'])) {
        $requestID = $_POST['requestID'];
        $consultation = $_POST["consultation"];
        //When the form is submitted, a request should be sent for a PHP page that will update the status for the corresponding request in the database to “consultation provided”
        $updateSql = "UPDATE designconsultationrequest SET statusID = (SELECT id FROM requeststatus WHERE status = 'consultation provided') WHERE id = '$requestID'";
        $updateResult = mysqli_query($connection, $updateSql);

        //add a new design consultation in the database, then redirect to the designer’s homepage.الخطوه
        if (!empty($_FILES["file"]["name"])) {
            $originalFileName = basename($_FILES["file"]["name"]);
            $fileType = pathinfo($originalFileName, PATHINFO_EXTENSION);

            $fileName = uniqid() . '.' . $fileType;

            $targetFilePath = $targetDir . $fileName;

            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($fileType, $allowTypes)) {
                if ($_FILES["file"]["error"] === UPLOAD_ERR_OK) {
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                        $insertSql = "INSERT INTO designconsultation (requestID, consultation, consultationImgFileName) VALUES (?, ?, ?)";

                        if ($stmt = mysqli_prepare($connection, $insertSql)) {
                            mysqli_stmt_bind_param($stmt, 'iss', $requestID, $consultation, $fileName);
                            if (mysqli_stmt_execute($stmt)) {
                                mysqli_stmt_close($stmt);
                                // Redirect to the designer's homepage
                                header('Location: DesignerHomepage.php');
                                exit();
                            } else {
                                echo "File upload failed, please try again.";
                            }
                        } else {
                            echo "Failed to prepare the statement.";
                        }
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                } else {
                    echo "Error uploading file: " . $_FILES["file"]["error"];
                }
            } else {
                echo 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
            }
        } else {
            echo "No file was uploaded.";
        }
    }
}
            
