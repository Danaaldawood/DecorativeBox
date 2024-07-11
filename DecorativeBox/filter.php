<?php
$connection = mysqli_connect("localhost", "root", "root", "decorativeBox");
$selectedCategory = mysqli_real_escape_string($connection, $_POST['category']);
$response = [];

$query = "SELECT designer.id as designerID, designer.brandName, designer.logoImgFileName, GROUP_CONCAT(designcategory.category SEPARATOR ', ') as specialties
          FROM designer
          JOIN designerspeciality ON designer.id = designerspeciality.designerID
          JOIN designcategory ON designerspeciality.designCategoryID = designcategory.id";

if ($selectedCategory != "all") {
    $query .= " WHERE designcategory.category = '$selectedCategory'";
}
$query .= " GROUP BY designer.id";

$result = mysqli_query($connection, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }
}

echo json_encode($response);

?>
