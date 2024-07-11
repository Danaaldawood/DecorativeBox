<?php
session_start();
include_once 'Database_Connect.php';

if (!$connection) {
    echo json_encode("0");
} else {
     //check if the request id is provided in the url
    if (isset($_GET['id'])) {
        $requestID = mysqli_real_escape_string($connection, $_GET['id']);

        //update the status id in the design consultation request table from pending to declined
        $updateStatusSql = "UPDATE designconsultationrequest SET statusID = '3'
            WHERE id = '$requestID' AND statusID = 1";
        $updateResult = mysqli_query($connection, $updateStatusSql);

        //check if the update query was successful
        if ($updateResult) {
            //return success response as json
            echo json_encode("1");
        } else {
            //return error response if the update query failed as json
            echo json_encode("0");
        }
    }
}
?>
