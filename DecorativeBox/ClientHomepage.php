



<!DOCTYPE html>


<html lang="en">
    <head>
        <!-- comment -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Client Homepage</title>
        <link rel="stylesheet" href="clientHomepage.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    </head>
    <body>

        <header>
            <div class="logo">
                <img src="images/logo.png" alt="Logo" height="200" width="250">
            </div>


            <div id="logout">
                <a href="logout.php" id="btn">Log-out</a>
            </div>
        </header>
        <main>
            <section>

                <div class="client-info">

                    <?php
                    session_start();
                    $connection = mysqli_connect("localhost", "root", "root", "decorativeBox");

                    if (mysqli_connect_error()) {
                        die("unable to connect" . mysqli_connect_error());
                    } else {
                        $clientId = $_SESSION['user_id'];
                        $sql = "SELECT * FROM  client WHERE  id='$clientId'";

                        $result = mysqli_query($connection, $sql);

                        while ($row = mysqli_fetch_assoc($result)) {

                            echo"<h1>Welcome, " . $row['firstName'] . "</h1>";
                            echo " <div class='welcome-box'>";
                            echo "<pre>" . $row['firstName'] . "'s Information:" . "<br>";
                            echo $row['firstName'] . " " . $row['lastName'] . "<br>";
                            echo $row['emailAddress'] . "</pre>";
                            echo "</div>";
                        }
                    }
                    ?>

                </div>
                <h2>Interior Designers</h2>

                <form action="ClientHomepage.php" method="POST">


                    <label for="categoryFilter">Select Category:</label>
                    <select name='category' id="categoryFilter" class="categoryF">
                        <option value="all">All Categories</option>
                        <?php
                        
                        $query = "SELECT category FROM designcategory"; 
                        $result = mysqli_query($connection, $query);
                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $category = $row['category']; 
                                echo "<option value='{$category}'>{$category}</option>";
                            }
                        } 
                        ?>
                    </select>



                </form>







                <table id="designersTable">
                    <thead>
                        <tr>
                            <th>Designer</th>
                            <th>Speciality</th>
                        </tr>
                    </thead>

                    <?php
                    $sqlInitial = "SELECT 
    designer.id as designerID,  
    designer.brandName,
    designer.logoImgFileName,
    GROUP_CONCAT(designcategory.category SEPARATOR ', ') as specialties
FROM 
    designer
JOIN 
    designerspeciality ON designer.id = designerspeciality.designerID
JOIN 
    designcategory ON designerspeciality.designCategoryID = designcategory.id";

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $selectedCategory = mysqli_real_escape_string($connection, $_POST['category']);

                        if ($selectedCategory != "all") {
                            $sqlInitial .= " WHERE designcategory.category = '$selectedCategory'";
                        }
                    }

                    $sqlInitial .= " GROUP BY designer.id";
                    $resultInitial = mysqli_query($connection, $sqlInitial);

                    if ($resultInitial) {

                        while ($rowInitial = mysqli_fetch_assoc($resultInitial)) {
                            $brandNameInitial = $rowInitial['brandName'];
                            $logoImgFileNameInitial = $rowInitial['logoImgFileName'];
                            $specialtiesInitial = $rowInitial['specialties'];
                            $designerIDInitial = $rowInitial['designerID'];

                            $specialtyClasses = [
                                'Modern' => 'modern',
                                'Bohemian' => 'bohemian',
                                'Coastal' => 'coastal',
                                'Country' => 'country',
                            ];

                            $classes = '';
                            $specialtiesArray = explode(', ', $specialtiesInitial);

                            foreach ($specialtiesArray as $specialty) {
                                $specialty = trim($specialty);

                                if (isset($specialtyClasses[$specialty])) {
                                    $classes .= $specialtyClasses[$specialty] . ' ';
                                }
                            }

                            $classes = rtrim($classes);

                            echo "<tr>";
                            echo "<td><a href='DesignPortfolio(client).php?designerID=$designerIDInitial'><img src='imagesUploads/$logoImgFileNameInitial' alt='$brandNameInitial Logo' width='50'><br>$brandNameInitial</a></td>";
                            echo "<td>";
                            $specialtiesArray = explode(', ', $specialtiesInitial);
                            foreach ($specialtiesArray as $specialty) {
                                $specialty = trim($specialty);
                                switch ($specialty) {
                                    case 'Modern':
                                        echo "<p class='modern'>$specialty</p>";
                                        break;
                                    case 'Bohemian':
                                        echo "<p class='bohemian'>$specialty</p>";
                                        break;
                                    case 'Coastal':
                                        echo "<p class='coastal'>$specialty</p>";
                                        break;
                                    case 'Country':
                                        echo "<p class='country'>$specialty</p>";
                                        break;
                                    default:
                                        break;
                                }
                            }
                            echo "</td>";
                            echo "<td><a href='RequestDesign.php?designerID=$designerIDInitial'>Request Consultation</a></td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </section>

            <section>
                <h2>Previous Design Consultations Requests</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Designer</th>
                            <th>Room</th>
                            <th>Dimensions</th>
                            <th>Design Category</th>
                            <th>Color Preferences</th>
                            <th>Request Date</th>
                            <th>Design Consultation</th>
                        </tr>
                    </thead>
                    <tbody>

<?php
/* Retrieves  all  consultation  design  requests  for  this  client  and  displays  them  in  a  table  of  7
  columns: the requested designer’s logo with brand name, room type, room dimensions, design
  category, color preferences, date of request, and the status of the request. If a consultation
  was  provided  for  a  request,  then  the  consultation  and  its  image  are  shown  in  the
  corresponding cell. */

$sql = "SELECT designconsultationrequest.id, 
                designer.brandName, 
                designer.logoImgFileName, 
                roomtype.type, 
                designcategory.category, 
                designconsultationrequest.roomWidth, 
                designconsultationrequest.roomLength, 
                designconsultationrequest.colorPreferences, 
                designconsultationrequest.date, 
                requeststatus.status,
                designconsultation.consultation,  
                designconsultation.consultationImgFileName   
            FROM designconsultationrequest
            JOIN designer ON designconsultationrequest.designerID = designer.id
            JOIN roomtype ON designconsultationrequest.roomTypeID = roomtype.id
            JOIN designcategory ON designconsultationrequest.designCategoryID = designcategory.id
            JOIN requeststatus ON designconsultationrequest.statusID = requeststatus.id
            LEFT JOIN designconsultation ON designconsultationrequest.id = designconsultation.requestID 
            WHERE designconsultationrequest.clientID = {$clientId}"; // 1 for testing , need to take form session 

$result = mysqli_query($connection, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td><img src='imagesUploads/" . $row['logoImgFileName'] . "' alt='" . $row['brandName'] . "' /><br>" . $row['brandName'] . "</td>";
        echo "<td>" . $row['type'] . "</td>";
        echo "<td>" . $row['roomWidth'] . "x" . $row['roomLength'] . "m</td>";
        echo "<td>" . $row['category'] . "</td>";
        echo "<td>" . $row['colorPreferences'] . "</td>";
        echo "<td>" . $row['date'] . "</td>";

        // Check if consultation was provided
        if (!empty($row['consultation'])) {
            echo "<td>" . $row['consultation'];
            // If an image path is provided, display the image

            echo "<br><img src='imagesUploads/" . $row['consultationImgFileName'] . "' alt='Consultation Image' />";

            echo "</td>";
        } else {
            echo "<td>" . $row['status'] . "</td>";
        }

        echo "</tr>";
    }
} else {
    echo "Error: " . mysqli_error($connection);
}
?>

                    </tbody>
                </table>
            </section>
        </main>

        <script>
            $(document).ready(function () {
                $("#categoryFilter").change(function () {
                    var selectedCategory = $(this).val();

                    $.ajax({
                        url: 'filter.php',
                        type: 'POST',
                        data: {category: selectedCategory},
                        dataType: 'json',
                        success: function (response) {

                            updateDesignersTable(response);
                        },
                        error: function () {
                            alert("Error loading designers");
                        }
                    });
                });
            });

            function updateDesignersTable(designers) {
                var tableContent = '';
                $.each(designers, function (i, designer) {
                    tableContent += '<tr>' +
                            '<td><a href="DesignPortfolio(client).php?designerID=' + designer.designerID + '">' +
                            '<img src="imagesUploads/' + designer.logoImgFileName + '" alt="' + designer.brandName + ' Logo" width="50"><br>' +
                            designer.brandName + '</a></td>' +
                            '<td>' + designer.specialties + '</td>' +
                            '<td><a href="RequestDesign.php?designerID=' + designer.designerID + '">Request Consultation</a></td>' +
                            '</tr>';
                });
                $('#designersTable tbody').html(tableContent);
            }

        </script>

    </body>
</html>
