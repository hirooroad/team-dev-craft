<?php
require(dirname(__FILE__) . './../../dbconnect.php');

session_start();

if (!empty($_SESSION)) {
    $name = $_SESSION['name'];
    $furigana = $_SESSION['furigana'];
    $mail_adress = $_SESSION['mail_adress'];
    $confirmation_email_adress = $_SESSION['confirmation_email_adress'];
    $tele_number = $_SESSION['tele_number'];
    $company = $_SESSION['company'];
    $content = $_SESSION['content'];
    $_SESSION['application'] = 2;
}else {
    $name = '';
    $furigana = '';
    $mail_adress = '';
    $confirmation_email_adress = '';
    $tele_number = '';
    $company = '';
    $content = '';
}
?>
<!DOCTYPE html>
<html lang="en"></html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>問い合わせフォーム確認　CRAFT就活エージェント比較サイト</title>
    <link rel="stylesheet" href="../../assets/css/user.css">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/sp/user.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
<?php include(dirname(__FILE__) . '../../../components/user/header.php'); ?>
    <div class="header-go"></div>
    <div class="header-go3"></div>
    <div class="form-space"></div>
    <form class="form">
        <h1 class="form-title">入力確認</h1>
        <div class="confirm-box">
            <label class="confirm-label">氏名</label>
            <p class="confirm-text" name="name"><?=$name?></p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">フリガナ</label>
            <p class="confirm-text"><?=$furigana?></p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">メールアドレス</label>
            <p class="confirm-text"><?=$mail_adress?></p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">ご確認用メールアドレス</label>
            <p class="confirm-text"><?=$confirmation_email_adress?></p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">電話番号</label>
            <p class="confirm-text"><?=$tele_number?></p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">貴社名</label>
            <p class="confirm-text"><?=$company?></p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">お問い合わせ内容</label>
            <p class="confirm-text"><?=$content?></p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">情報利用ポリシー</label>
            <p class="confirm-text">同意する</p>
        </div>
        <div class="submit">
            <button type="button" class="confirm-button" onclick="location.href='./index.php#contact'">変更する</button>
            <button type="button" class="confirm-button"  onclick="location.href='./complete.php'">送信する</button>
        </div>