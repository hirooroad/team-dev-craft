<?php
require(dirname(__FILE__) . '/../../dbconnect.php');

session_start();
if (!isset($_SESSION['agent'])) {
        header('Location: ./login/index.php');
    } else {

        $stmt = $dbh->prepare('DELETE FROM agents WHERE id = :agent_id');
        $stmt->bindValue(':agent_id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();

        header("Location: ./index.php");
    }
?>