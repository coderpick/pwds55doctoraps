<?php
$realpath = realpath(dirname(__FILE__));
require_once($realpath . "/../db/db_connection.php");
session_start();

if (isset($_GET['id'])) {
    $id = base64_decode($_GET['id']);

    $sql = "SELECT * FROM doctors WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_OBJ);
    /* delete user */
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $row->user_id, PDO::PARAM_INT);
    $stmt->execute();

    /* delete doctor image */
    if (isset($row->image)) {
        unlink($row->image);
    }
    /* delete doctor data */
    $sql = "DELETE FROM doctors WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $_SESSION['success'] = "Doctor deleted successfully";
    header("location:doctor.php");
}
