<?php
require(dirname(__FILE__) . '/../../dbconnect.php');

session_start();

if (!isset($_SESSION['agent_id'])) {
    header('Location: ../login/index.php');
} else if(!isset($_GET['id']) && !isset($_GET['area']) && !isset($_GET['reason'])) {
    header('Location: ../index.php');
} else {
    $stmt = $dbh->prepare('SELECT * FROM applicants WHERE id = :applicant_id');
    $stmt->bindValue(':applicant_id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $applicant = $stmt->fetchAll();

    $today = date("Y-m-d");

    $stmt = $dbh->prepare('INSERT INTO alert (applicant_id, agent_id, place, reason, day) VALUES (:applicant_id, :agent_id, :place, :reason, :day)');
    $stmt->bindValue(':applicant_id', $_GET['id'], PDO::PARAM_INT);
    $stmt->bindValue(':agent_id', $_SESSION['agent_id'], PDO::PARAM_INT);
    $stmt->bindValue(':place', $_GET['area'], PDO::PARAM_INT);
    $stmt->bindValue(':reason', $_GET['reason'], PDO::PARAM_STR);
    $stmt->bindValue(':day', $today);
    $stmt->execute();

    $headers = "From: craft@example.com";
            $headers .= "MIME-Version: 1.0\n";
            $headers .= "Content-Transfer-Encoding: BASE64\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\n";

            $place = array(
                1 => '氏名',
                2 => '生年月日',
                3 => 'メールアドレス',
                4 => '住所',
                5 => '電話番号',
                6 => '最終学歴・文理区分',
                7 => '卒業見込年',
                8 => 'その他'
            );

            $agent_id = $_SESSION['agent_id'];

            $stmt = $dbh->prepare('SELECT * FROM agents WHERE id = :agent_id');
            $stmt->bindValue(':agent_id', $agent_id , PDO::PARAM_INT);
            $stmt->execute();
            $agent = $stmt->fetch();
// 宛先
        $to = $agent['login_id'];

// 件名
        $subject = "通報フォームが送信されました。";

// 本文
        $body = "通報フォームが送信されました。\n
        通報対象：".$applicant[0]['name']."\n
        通報内容：".$place[$_GET['area']]."\n
        通報理由：".$_GET['reason']."\n
        通報日時：".$today."\n
        \n
        通報フォームの確認状況は、担当者よりご連絡をさせていただきます。\n
        CRAFT for Agent 就活エージェント比較サイト\n
        株式会社boozer";

        // メール送信
$rtt = mb_send_mail($to, $subject, $body,  $headers);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>通報フォーム送信 CRAFT for Agent 就活エージェント比較サイト</title>
    <link rel="stylesheet" href="../../assets/css/agent.css">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
<?php include(dirname(__FILE__) . '../../../components/agent/header.php'); ?>
    <main>
        <div class="header-go"></div>
        <div class="complete-box">
        <h1 class="complete-title">通報フォームの送信が完了致しました</h1>
        <div>
            <p class="complete-text">この度はお問合せいだたきありがとうございました。
                <br>担当者からの連絡をお待ちください。
                <br>また登録されているメールアドレス宛に確認用のメールをお送りさせていただいております。
                <br><br>送信後しばらくしてもメールが届かない場合、お手数ですがフォームを再度入力していただくか、メールにてお問合せしていただくようお願いいたします。
            </p>
        </div>
        <button type="button" class="complete-submit-button" onclick="location.href='../index.php'">トップページに戻る</button>
    </div>
    </main>
</body>
</html>