<?php
require(dirname(__FILE__) . '/../../dbconnect.php');

session_start();

if (!isset($_SESSION['agent'])) {
    header('Location: ../index.php');
} else {
$destination = $_POST['destination'];
        $question = $_POST['question'];
        $answer = $_POST['answer'];
        $today = date("Y-m-d");

        $stmt = $dbh->prepare('INSERT INTO fqa (destination, question, answer, start_day , status) VALUES (:destination, :question, :answer, :start_day, 1)');
        $stmt->bindValue(':destination', $destination, PDO::PARAM_INT);
        $stmt->bindValue(':question', $question, PDO::PARAM_STR);
        $stmt->bindValue(':answer', $answer, PDO::PARAM_STR);
        $stmt->bindValue(':start_day', $today, PDO::PARAM_STR);
        $stmt->execute();

        header('Location: ./index.php');
}