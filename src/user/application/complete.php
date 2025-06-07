<?php
    session_start();

    if(isset($_SESSION['name'])) {
    if($_SESSION['application'] = 1){
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
        $agents = $_SESSION['agent'];

        // ハイフンで分割
        $graduationDateParts = explode('-', $graduationDate);
        $graduationYear = $graduationDateParts[0]; // ハイフンより前の部分
        $graduationMonth = $graduationDateParts[1]; // ハイフンより後の部分

        $today = date("Y-m-d");

        require(dirname(__FILE__) . './../../dbconnect.php');

        $sql = $dbh->prepare('INSERT INTO applicants (day, name, furigana, birthday , gender , mail_address , address , tele_number , huma_science , academic , graduation_YEAR,graduation_MONTH , send_status)
        VALUES (:day, :name, :furigana, :birthdate , :gender , :email , :address , :phone , :humaScience , :school , :graduationYear , :graduationMonth , 0)');
        $sql -> bindValue(':day' , $today);
        $sql -> bindValue(':name' , $name);
        $sql -> bindValue(':furigana' , $furigana);
        $sql -> bindValue(':birthdate' , $birthdate);
        $sql -> bindValue(':gender', $gender);
        $sql -> bindValue(':email' , $email);
        $sql -> bindValue(':address' , $address);
        $sql -> bindValue(':phone' , $phone);
        $sql -> bindValue(':humaScience' , $humaScience);
        $sql -> bindValue(':school' , $school);
        $sql -> bindValue(':graduationYear' , $graduationYear);
        $sql -> bindValue(':graduationMonth' , $graduationMonth);
        $sql -> execute();

        $applicantID = $dbh->query('SELECT id FROM applicants WHERE name = "'.$name.'"')->fetchAll(PDO::FETCH_ASSOC);;
        $applicant = $applicantID[0]['id'];

        forEach ($agents as $agent) {
            $sql3 = $dbh->prepare('SELECT id, login_id FROM agents WHERE id = :agent');
            $sql3 -> bindValue(':agent' , $agent);
            $sql3 -> execute();
            $agentInfo = $sql3->fetchAll(PDO::FETCH_ASSOC);
        }

        forEach ($agents as $agent) {
        $sql2 = $dbh->prepare('INSERT INTO submit (applicant_id, agent_id) VALUES (:applicant, :agent)');
        $sql2 -> bindValue(':applicant' , $applicant);
        $sql2 -> bindValue(':agent' , $agent);
        $sql2 -> execute();
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

        // 送信者
        // $from = "craft@example.co.jp";
        $headers = "From: craft@example.com";
            $headers .= "MIME-Version: 1.0\n";
            $headers .= "Content-Transfer-Encoding: BASE64\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\n";



// 宛先
        $to = $email;

// 件名
        $subject = "申し込みが確定されました";

// 本文
        $body = "以下の内容で申し込みが確定されました。\n\n
        お名前：".$name."\n
        ふりがな：".$furigana."\n
        生年月日：".$birthdate."\n
        性別：".$genders[$gender]."\n
        メールアドレス：".$email."\n
        住所：".$address."\n
        電話番号：".$phone."\n
        文理区分：".$sciences[$humaScience]."\n
        学校名：".$school."\n
        卒業年月：".$graduationDate."\n\n

        後日、担当エージェントよりご連絡させていただきます。\n
        ご連絡いただくまではしばらくお待ち下さい。\n\n
        このメールは自動送信です。\n
        お心当たりのない場合は、お手数ですが破棄してください。\n\n
        ご不明な点がございましたら、サイトの「問い合わせフォーム」よりお問い合わせください。\n\n
        CRAFT就活エージェント比較サイト\n
        株式会社boozer";

// メール送信
    $rtt = mb_send_mail($to, $subject, $body,  $headers);
    
    forEach ($agentInfo as $agentInfo) {
    $to2 =  $agentInfo['login_id'];

    $subject2 = "新規申し込みがありました";

    $body2 = "以下の内容で新規申し込みがありました。ご確認ください。\n\n
    お名前：".$name."\n
    ふりがな：".$furigana."\n
    生年月日：".$birthdate."\n
    性別：".$genders[$gender]."\n
    メールアドレス：".$email."\n
    住所：".$address."\n
    電話番号：".$phone."\n
    文理区分：".$sciences[$humaScience]."\n
    学校名：".$school."\n
    卒業年月：".$graduationDate."\n\n
    
    このメールは自動送信です。\n
    お心当たりのない場合は、お手数ですが破棄してください。\n\n
    ご不明な点がございましたら、サイトの「問い合わせフォーム」や、弊社へメールにてお問い合わせください。\n\n
    CRAFT就活エージェント比較サイト\n
    株式会社boozer";

    $rtt2 = mb_send_mail($to2, $subject2, $body2,  $headers);
    }

        session_destroy();
    }}else {
        header('Location: ../index.php');
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en"></html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>申込みフォーム送信完了　CRAFT就活エージェント比較サイト</title>
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
                <div class="form-word2">確認</div>
                <div class="form-word6">完了</div>
            </div>
        </div>
    </div>
    <form class="form">
        <h1 class="complete-title">申し込みフォームの送信が完了致しました</h1>
        <div>
            <p class="complete-text">この度はお問合せいだたきありがとうございました。
                <br>各エージェント企業の担当者からの連絡をお待ちください。
                <br>またご入力されたメールアドレス宛に確認用のメールをお送りさせていただいております。
                <br><br>送信後しばらくしてもメールが届かない場合、お手数ですがフォームを再度入力していただくか、お電話にてお問合せしていただくようお願いいたします。
            </p>
        </div>
        <div class="submit">
        <button type="button" class="submit-button" onclick="location.href='../index.php'">トップページに戻る</button>
        </div>
    </form>
</body>
</html>