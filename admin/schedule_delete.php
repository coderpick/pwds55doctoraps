<?php
$realpath = realpath(dirname(__FILE__));
require_once($realpath . "/../db/db_connection.php");
session_start();

if (isset($_GET['id'])) {
    $id = base64_decode($_GET['id']);
    /* delete user */
    $sql = "DELETE FROM schedules WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $_SESSION['success'] = "Schedule deleted successfully";
    header("location:schedule.php");
}
