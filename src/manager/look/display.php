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

        $stmt = $dbh->prepare('UPDATE agents SET display = :display WHERE id = :agent_id');
        $stmt->bindValue(':display', $status, PDO::PARAM_INT);
        $stmt->bindValue(':agent_id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();

        header("Location: ./index.php");
        }