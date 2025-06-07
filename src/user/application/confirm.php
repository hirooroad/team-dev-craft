<?php

    session_start();

    if($_SESSION) {
    $name = $_SESSION['name'];
    $furigana = $_SESSION['furigana'];
    $birthdate = $_SESSION['birthdate'];
    $gender = $_SESSION['gender'];
    $email = $_SESSION['email'];
    $confirmationEmail = $_SESSION['confirmation-email'];
    $address = $_SESSION['address'];
    $phone = $_SESSION['phone'];
    $humaScience = $_SESSION['huma-science'];
    $school = $_SESSION['school'];
    $graduationDate = $_SESSION['graduationdate'];
    $agent = $_SESSION['agent'];

    // $_SESSION['application'] = 1;
    // $_SESSION['name'] = $name;
    // $_SESSION['furigana'] = $furigana;
    // $_SESSION['birthdate'] = $birthdate;
    // $_SESSION['gender'] = $gender;
    // $_SESSION['email'] = $email;
    // $_SESSION['confirmation-email'] = $confirmationEmail;
    // $_SESSION['address'] = $address;
    // $_SESSION['phone'] = $phone;
    // $_SESSION['huma-science'] = $humaScience;
    // $_SESSION['school'] = $school;
    // $_SESSION['graduationdate'] = $graduationDate;
    // $_SESSION['agent'] = $agent;

    $count = count($_SESSION['agent']);
} else {
    header('Location: form.php');
}

    $genders = array(
        1 => '男性',
        2 => '女性',
        3 => 'その他',
    );

    $sciences = array(
        1 => '文系',
        2 => '理系',
        3 => 'その他',
    );
?>

<!DOCTYPE html>
<html lang="en"></html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>申込みフォーム確認　CRAFT就活エージェント比較サイト</title>
    <link rel="stylesheet" href="../../assets/css/user.css">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/sp/user.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
<?php include(dirname(__FILE__) . '../../../components/user/header.php'); ?>
    <div class="header-go2"></div>
    <div class="word-box">
        <div class="word-box-container">
            <div class="word-container">
                <div class="form-word4">入力</div>
                <div class="form-word5">確認</div>
                <div class="form-word3">完了</div>
            </div>
        </div>
    </div>
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
            <label class="confirm-label">生年月日</label>
            <p class="confirm-text"><?

        $date = $birthdate;
            // 日本語のフォーマットに設定
            setlocale(LC_ALL, 'ja_JP.UTF-8');

        // 日付をフォーマット
        $formattedDate = date("Y年m月d日", strtotime($date));
        echo $formattedDate;?>
        </p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">性別</label>
            <p class="confirm-text"><?=$genders[$gender]?></p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">メールアドレス</label>
            <p class="confirm-text"><?=$email?></p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">ご確認用メールアドレス</label>
            <p class="confirm-text"><?=$confirmationEmail?></p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">住所</label>
            <p class="confirm-text"><?=$address?></p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">電話番号</label>
            <p class="confirm-text"><?=$phone?></p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">文理区分</label>
            <p class="confirm-text"><?=$sciences[$humaScience]?></p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">最終学歴</label>
            <p class="confirm-text"><?=$school?></p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">卒業見込み年</label>
            <p class="confirm-text"><?
                $gdate = $graduationDate;
                // 日本語のフォーマットに設定
                setlocale(LC_ALL, 'ja_JP.UTF-8');
    
                 // 日付をフォーマット
                $formattedDate = date("Y年m月", strtotime($gdate));
                echo $formattedDate;?></p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">申し込むエージェント</label>
            <ul id="confirm-agent">
            </ul>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">情報利用ポリシー</label>
            <p class="confirm-text">同意する</p>
        </div>
        <div class="submit">

            <button type="button" class="confirm-button" onclick="location.href='form.php'">入力内容を変更する</button>
            <button type="button" class="confirm-button"  onclick="location.href='./complete.php'">送信する</button>
        </div>
    </form>
    <script>
        let items = JSON.parse(localStorage.getItem("items"));
        let agentList = document.getElementById("confirm-agent");

        if (items) {
            items.forEach((item) => {
                const li = document.createElement("li");
                li.classList.add("confirm-text");
                li.textContent = item.name;
                agentList.appendChild(li);
            });
        }
    </script>
</body>
</html>