<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Design Portfolio</title>
    <link rel="stylesheet" href="DesignPortfolio(client).css">
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
        <h1>Designer's Portfolio</h1>
        <div id="info">
            <?php
            include_once './Database_Connect.php';

            $designerID = $_GET['designerID'];

            $sql1 = "SELECT * FROM designer WHERE id='$designerID'";
            $result1 = mysqli_query($connection, $sql1);

            if ($result1) {
                $row = mysqli_fetch_assoc($result1);
                 echo "<p>Designer: " . $row["firstName"] . " " . $row["lastName"] . "</p>";
                echo "<p>Brand Name: " . $row["brandName"] . "</p>";
               
            } else {
                echo "<p>Error retrieving designer information</p>";
            }

            $table = "<table>";
            $table .= "<thead><tr><th>Project Name</th><th>Image</th><th>Design Category</th><th>Description</th></tr></thead>";
            $table .= "<tbody>";

            $sql3 = "SELECT * FROM designprotofiloproject WHERE designerID='$designerID'";
            $result3 = mysqli_query($connection, $sql3);

            if ($result3) {
                while ($row = mysqli_fetch_assoc($result3)) {
                    $table .= "<tr><td>" . $row['projectName'] . "</td>";

                    $categoryID = $row['designCategoryID'];
                    $sql2 = "SELECT category FROM designcategory WHERE id='$categoryID'";
                    $result2 = mysqli_query($connection, $sql2);

                    if ($result2) {
                        $row2 = mysqli_fetch_assoc($result2);
                        $category = $row2['category'];

                        $class = '';
                        switch ($category) {
                            case 'Modern':
                                $class = 'modern';
                                break;
                            case 'Bohemian':
                                $class = 'bohemian';
                                break;
                            case 'Coastal':
                                $class = 'coastal';
                                break;
                            case 'Country':
                                $class = 'country';
                                break;
                            default:
                                break;
                        }
                    } else {
                        echo "<p>Error retrieving category</p>";
                    }

                    $table .= "<td><img src='imagesUploads/" . $row['projectImgFileName'] . "' alt='" . $row['projectImgFileName'] . "'></td>";
                    $table .= "<td><p class='$class'>" . $category . "</p></td>";
                    $table .= "<td>" . $row['description'] . "</td></tr>";
                }

                $table .= "</tbody></table>";
                echo $table;
            } else {
                echo "<p>Couldn't retrieve designer portfolio</p>";
            }
            ?>
        </div>
    </main>
</body>
</html>
