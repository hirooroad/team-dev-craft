<?php
require(dirname(__FILE__) . '/../../dbconnect.php');

session_start();

if (!isset($_SESSION['agent'])) {
    header('Location: ../index.php');
} else {
    $stmt = $dbh->prepare('DELETE FROM fqa WHERE id = :fqa_id');
    $stmt->bindValue(':fqa_id', $_GET['id']);
    $stmt->execute();

    header('Location: ./index.php');
}