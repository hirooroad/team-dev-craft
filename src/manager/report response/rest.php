<?php
require(dirname(__FILE__) . '/../../dbconnect.php');

session_start();

if (!isset($_SESSION['agent'])) {
    header('Location: ../index.php');
} else {

    $stmt = $dbh->prepare('SELECT *  from alert WHERE id = :alert_id');
    $stmt->bindValue(':alert_id', $_GET['id']);
    $stmt->execute();
    $alert = $stmt->fetch();

    $stmt = $dbh->prepare('SELECT * FROM applicants WHERE id = :applicant_id');
        $stmt->bindValue(':applicant_id', $alert['applicant_id']);
        $stmt->execute();
        $applicant = $stmt->fetch();

    $stmt = $dbh->prepare('SELECT * FROM agents WHERE id = :agent_id');
        $stmt->bindValue(':agent_id', $alert['agent_id']);
        $stmt->execute();
        $agent = $stmt->fetch();

    $stmt = $dbh->prepare('DELETE FROM alert WHERE applicant_id = :applicant_id');
    $stmt->bindValue(':applicant_id', $alert['applicant_id']);
    $stmt->execute();

    $headers = "From: craft@example.com";
            $headers .= "MIME-Version: 1.0\n";
            $headers .= "Content-Transfer-Encoding: BASE64\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\n";
// 宛先
        $to = $agent['login_id'];

// 件名
        $subject = "通報フォームが承認されませんでした";

// 本文
        $body = "".$applicant['name']."様に対する通報フォームが承認されませんでした。\n\n
        ご不明な点がございましたら、弊社にてお問い合わせください。\n\n
        このメールは自動送信です。\n
        お心当たりのない場合は、お手数ですが破棄してください。\n\n

        CRAFT for Agent 就活エージェント比較サイト\n
        株式会社boozer";

        // メール送信
$rtt = mb_send_mail($to, $subject, $body,  $headers);
    header('Location: ./index.php');
}