<?php
    session_start();

    if (!empty($_SESSION['name'])) {
        if($_SESSION['application'] = 2){
        $name = $_SESSION['name'];
        $furigana = $_SESSION['furigana'];
        $mail_adress = $_SESSION['mail_adress'];
        $confirmation_email_adress = $_SESSION['confirmation_email_adress'];
        $tele_number = $_SESSION['tele_number'];
        $company = $_SESSION['company'];
        $content = $_SESSION['content'];


        $today = date("Y-m-d");

        require(dirname(__FILE__) . './../../dbconnect.php');

        $sql = $dbh->prepare('INSERT INTO questions (name, furigana, mail_address, tele_number, company, content, day, status)
        VALUES (:name, :furigana, :email, :phone, :company, :content, :day, 0)');
        $sql -> bindValue(':name' , $name);
        $sql -> bindValue(':furigana' , $furigana);
        $sql -> bindValue(':email' , $mail_adress);
        $sql -> bindValue(':phone' , $tele_number);
        $sql -> bindValue(':company' , $company);
        $sql -> bindValue(':content' , $content);
        $sql -> bindValue(':day' , $today);
        $sql -> execute();

        $headers = "From: craft@example.com";
            $headers .= "MIME-Version: 1.0\n";
            $headers .= "Content-Transfer-Encoding: BASE64\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\n";

        $sql2 = $dbh->prepare('SELECT id, login_id FROM manager');
        $sql2 -> execute();
        $managers = $sql2->fetch(PDO::FETCH_ASSOC);

        $to = $managers['login_id'];

        $subject = "エージェント登録完了のお知らせ";

        $body = "".$name."様からお問い合わせがありました。\n
        お問い合わせ内容：".$content."\n
        お問い合わせ日時：".$today."\n
        \n

        このメールはシステムより自動送信されています。\n
        このメールに心当たりがない場合は、お手数ですが破棄してください。\n
        CRAFT就活エージェント比較サイト\n
        株式会社boozer";

        $rtt = mb_send_mail($to, $subject, $body,  $headers);
        }
    }
?>

<!DOCTYPE html>
<html lang="ja"></html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>問い合わせフォーム送信完了　CRAFT就活エージェント比較サイト</title>
    <link rel="stylesheet" href="../../assets/css/user.css">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/sp/user.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
<?php include(dirname(__FILE__) . '../../../components/user/header.php'); ?>
    <div class="header-go3"></div>
    <div class="form-space"></div>
    <div class="header-go"></div>
    <form class="form">
        <h1 class="complete-title">お問い合わせフォームの送信が完了致しました</h1>
        <div>
            <p class="complete-text">この度はお問合せいだたきありがとうございました。
                <br>担当者からの連絡をお待ちください。
                <br><br>送信後しばらくしてもメールが届かない場合、お手数ですがフォームを再度入力していただくか、お電話にてお問合せしていただくようお願いいたします。
            </p>
        </div>
        <div class="submit">
        <button type="button" class="submit-button" onclick="location.href='./index.php'">Q&Aページに戻る</button>
        </div>
    </form>
</body>
</html>