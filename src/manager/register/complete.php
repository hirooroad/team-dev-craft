<?php
require(dirname(__FILE__) . './../../dbconnect.php');
session_start();

if (!isset($_SESSION['agent'])) {
    header('Location: ../index.php');
} else if ($_SESSION['application'] != 3) {
    header('Location: form.php');
} else {
    $name = $_SESSION['name'];
    $style = $_SESSION['style'];
    $prefecture = $_SESSION['prefecture'];
    $select = $_SESSION['select'];
    $text = $_SESSION['text'];
    $image = $_SESSION['image'];
    $email = $_SESSION['email'];
    // $confirmationEmail = $_SESSION['confirmationEmail'];
    $password = password_hash($_SESSION['password'], PASSWORD_DEFAULT);
    // $confirmationPassword = $_SESSION['confirmationPassword'];
    $imagename = $_SESSION['image_name'];

    $today = date("Y-m-d");
    $nextYear = date("Y-m-d", strtotime("+1 year"));

    $sql = $dbh->prepare('INSERT INTO agents (name, industry, area, information,  image, login_id, password, claim_money ,claim_confirm , alert_number, start_period , end_period ,display)
        VALUES (:name, :style, :prefecture , :text , :image , :email , :password, 0 , 0, 0 , :start_period , :end_period, 1)');
        $sql -> bindValue(':name' , $name);
        $sql -> bindValue(':style' , $style);
        $sql -> bindValue(':prefecture' , $prefecture);
        $sql -> bindValue(':text' , $text);
        $sql -> bindValue(':image' , $imagename);
        $sql -> bindValue(':email' , $email);
        $sql -> bindValue(':password', $password);
        $sql -> bindValue(':start_period' , $today);
        $sql -> bindValue(':end_period' , $nextYear);
        $sql -> execute();
        }

        $agentId = $dbh->query('SELECT id FROM agents WHERE login_id = "'.$email.'"')->fetchAll(PDO::FETCH_ASSOC);;
        $agent = $agentId[0]['id'];

        forEach ($select as $select) {
        $sql2 = $dbh->prepare('INSERT INTO form (agent_id, form)
        VALUES (:agent_id, :select)');
        $sql2 -> bindValue(':agent_id' , $agent);
        $sql2 -> bindValue(':select' , $select);
        $sql2 -> execute();
        }
        $headers = "From: craft@example.com";
            $headers .= "MIME-Version: 1.0\n";
            $headers .= "Content-Transfer-Encoding: BASE64\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\n";

        $to = $email;

        $subject = "エージェント登録完了のお知らせ";

        $body = "".$name."様 \n\n
        CRAFTへのエージェント登録が完了しました。
        正常にログインできない、もしくはエージェント一覧に表示されない場合は、弊社にてお問い合わせください。\n\n
        登録情報\n
        エージェント名：".$name."\n
        ログインID：".$email."\n\n
        このメールに心当たりがない場合は、お手数ですが破棄してください。\n
        CRAFT就活エージェント比較サイト\n
        株式会社boozer";

        $rtt = mb_send_mail($to, $subject, $body,  $headers);

        unset($_SESSION['name']);
        unset($_SESSION['style']);
        unset($_SESSION['prefecture']);
        unset($_SESSION['select']);
        unset($_SESSION['text']);
        unset($_SESSION['image']);
        unset($_SESSION['email']);
        unset($_SESSION['password']);
        unset($_SESSION['confirmationEmail']);
        unset($_SESSION['confirmationPassword']);
?>

<!DOCTYPE html>
<html lang="en"></html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>エージェント新規登録・完了 CRAFT管理者画面 就活エージェント比較サイト</title>
    <link rel="stylesheet" href="../../assets/css/manager.css">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
<?php include(dirname(__FILE__) . '../../../components/manager/header.php'); ?>
    <div class="header-go"></div>
    <form class="form">
        <div class="form-complete">
            <h1 class="form-title">エージェント登録が完了しました</h1>
        </div>

        <div class="submit">
            <button type="button" class="submit-button" onclick="location.href='../look/index.php'">エージェント管理に戻る</button>
        </div>
    </form>
</body>
</html>