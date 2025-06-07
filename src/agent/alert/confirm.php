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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>通報フォーム確認 CRAFT for Agent 就活エージェント比較サイト</title>
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
        <div class="alert-box-confirm">
            <h1 class="alert-title">通報フォーム</h1>
            <div class="alert-item">
                <p class="alert-item-top">通報対象：</p>
                <p class="alert-item-content"><?=$applicant[0]['name']?></p>
            </div>
            <div class="alert-item">
                <p class="alert-item-top">通報内容：</p>
                <p class=alert-item-content><?=$place[$_GET['area']]?></p>
        </div>
        <div class="alert-reason-confirmBox">
            <p class="alert-reason-top-confirm">通報箇所：
            </p>
            <p class="alert-reason-confirm"><?=$_GET['reason']?></p>
        </div>
        <div class="alert-confirm-buttonBox">
            <button class="alert-confirm-backButton" onclick="location.href='./index.php?id=<?=$_GET['id']?>'">入力し直す</button>
            <button class="alert-confirm-goButton" onclick="location.href='./complete.php?id=<?=$_GET['id']?>&area=<?=$_GET['area']?>&reason=<?=$_GET['reason']?>'">送信</button>
        </div>
    </main>
</body>
</html>