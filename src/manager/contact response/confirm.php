<?php
require(dirname(__FILE__) . '/../../dbconnect.php');

session_start();
if (!isset($_SESSION['agent'])) {
        header('Location: ./login/index.php');
    } else {
        $status = $_GET['status'];
        if($status == 0) {
                $status = 1;
                } else {
                $status = 0;
                }

        $stmt = $dbh->prepare('UPDATE questions SET status = :status WHERE id = :id');
        $stmt->bindValue(':status', $status, PDO::PARAM_INT);
        $stmt->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();

        header("Location: ./index.php");
}