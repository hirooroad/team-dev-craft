<?php
require(dirname(__FILE__) . '/../dbconnect.php');

$message = '';
$message1 = '';
$message2 = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(empty($_POST['email'])) {
        $message1 = 'メールアドレスは必須項目です。';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $message1 = '正しいEメールアドレスを指定してください。';
    }
    if (empty($_POST['password'])) {
        $message2 = 'パスワードは必須項目です。';
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $dbh->prepare('SELECT * FROM manager WHERE login_id = :email');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $manager = $stmt->fetch();

        if($manager && password_verify($password, $manager['password'])) {
            session_start();
            $_SESSION['agent'] = $manager;
            header('Location: /manager/menu/index.php');
            exit();
        } else {
            $message = 'ログイン情報が間違っています。';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン CRAFT管理者画面 就活エージェント比較サイト</title>
    <link rel="stylesheet" href="../../assets/css/manager.css">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
    <style>
        /*ヘッダー*/
.header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 80px;
    background-color: #003D63;
    border-bottom: solid 1px var(--gray-light-color);
    padding-left: 24px;
    z-index: 10000;
    transition: background-color .3s linear;
    display: flex !important;
    justify-content: space-between;
    transition: background-color .4s linear;
}

.header-logo{
    display: flex;
}

.header-logo img {
    height: 110%;
}

.header-logo p {
    margin-top: 25px;
    margin-left: 10px;
    font-size: 32px;
}
.header-nav {
    margin-top: 1%;
    margin-top: -0.01%;
    width: 400px;
}

.header-navLink {
    font-weight: bold;
    font-family: "Noto Sans JP", sans-serif;
    font-weight: 400;
    line-height: 1.8;
    letter-spacing: .1em;
    text-align: right;
    margin-left: 55%;
    font-size: 32px;
    padding-top: 10px;
    display: inline-block; /* インラインブロックにすることで中央に寄る */
}

.header-navList img {
    height: 70px;
}
.header-go {
    width: 100%;
    height: 73px;
}

/*ログイン画面*/
.login-padding {
    width: 70%;
    margin: 0 auto;
    margin-top: 100px;
}
.login-title {
    font-size: 40px;
    font-weight: 700;
    color:#437797;
    margin-top: 40px;
}

.login-form-top {
    padding: 12px 12px 12px 0;
    display: block;
    margin-left: 120px;
    font-size: 24px;
    font-weight: 500;
    margin-top: 24px;
    width: 40%;
}

.login-form input{
    width: 70%;
    padding: 12px;
    border: 2px solid #437797;
    border-radius: 8px;
    box-sizing: border-box;
    margin-top: 6px;
    margin-bottom: 16px;
    margin-left: 120px;
    resize: vertical;
    background-color: #ffffff;
}

.error-message {
    color: #FF0000;
    font-size: 20px;
    margin-left: 30px;
}

.input-error-message {
    color: #FF0000;
    font-size: 20px;
    margin-left: 120px;
}

.login-button-block {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.login-button {
    width: 30%;
    background-color: #437797;
    font-family: "Noto Sans JP", sans-serif;
    font-weight: 400;
    padding: 15px;
    color: #FFFFFF;
    border-radius: 8px;
    height: 100%;
    text-align: center;
    border: 1px solid #4E4E4E;
    margin-top: 30px;
    margin-bottom: 40px;
    font-size: 32px;
}

.login-button:hover {
    background-color: #FFFFFF;
    color: #4E4E4E;
    transition: all 0.2s;

}
.password-changeButton {
    font-weight: 700;
    font-size: 16px;
    text-decoration: underline;
}
    </style>
</head>
<body>
    <header class="header" id="js-header">
        <a href="./index.php" class="header-logo">
            <img src="../../assets/img/craft logo2.png" alt="POSSE③">
            <p>for Agent</p>
        </a>
        <nav class="header-nav">
            <ul class="header-navList">
                <li class="header-navItem">
                    <img src="../../assets/img/boozer_logo_white.png" alt="">
                    <a href="./" class="header-navLink closed">
                        Logout
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="header-go"></div>
        <div class="login-padding">
            <div>
                <p class="login-title">管理者ログイン画面</p>
                <p class="error-message"><?=$message?></p>
            </div>
            <form action="" class="login-form" method="POST">
            <div>
                <p class="login-form-top">ログインID(emailアドレス)</p>
                <p class="input-error-message">
                <?= $message1?>
                </p>
                    <input type="text" name="email">
            </div>
            <div>
                <p class="login-form-top">パスワード</p>
                <p class="input-error-message"><?=$message2?></p>
                    <input type="password" name="password">
                </div>
                <div class="login-button-block">
                    <button class="login-button">ログイン</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>