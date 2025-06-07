<?php 
require(dirname(__FILE__) . '/../dbconnect.php');

session_start();
if (!isset($_SESSION['agent_id'])) {
        header('Location: ./login/index.php');
    } else {
        $status = $_GET['status'];
        if($status == 0) {
                $status = 1;
                } else {
                $status = 0;
                }

        $stmt = $dbh->prepare('UPDATE applicants SET send_status = :status WHERE id = :applicant_id');
        $stmt->bindValue(':status', $status, PDO::PARAM_INT);
        $stmt->bindValue(':applicant_id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();

        $nowPage = $_GET['nowPage'];
        header("Location: ./index.php?page_id=$nowPage");
        }