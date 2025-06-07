<?php
require(dirname(__FILE__)) . './../../dbconnect.php';

session_start();

if (!isset($_SESSION['agent'])) {
    header('Location: ../index.php');
} else {

    // $name = isset($_SESSION['name']) ? $_SESSION['name'] : null;
    // // Check if each session variable is set before using it
    // $style = isset($_SESSION['style']) ? $_SESSION['style'] : null;
    // $prefecture = isset($_SESSION['prefecture']) ? $_SESSION['prefecture'] : null;
    // $select = isset($_SESSION['select']) ? $_SESSION['select'] : null;
    // // Repeat for other variables as needed
    // $text = isset($_SESSION['text']) ? $_SESSION['text'] : null;
    // $image = isset($_SESSION['image']) ? $_SESSION['image'] : null;
    // $email = $_SESSION['email'];
    // $confirmationEmail = isset($_SESSION['confirmation_email']) ? $_SESSION['confirmation_email'] : null;
    // $password = isset($_SESSION['password']) ? $_SESSION['password'] : null;
    // $confirmationPassword = isset($_SESSION['confirmation_password']) ? $_SESSION['confirmation_password'] : null;

    if(isset($_SESSION['name'])) {
        if(isset($_SESSION['application'])){
            if($_SESSION['application'] == 3) {
            $name = $_SESSION['name'];
            $style = $_SESSION['style'];
            $prefecture = $_SESSION['prefecture'];
            $select = $_SESSION['select'];
            $text = $_SESSION['text'];
            $image = $_SESSION['image'];
            $email = $_SESSION['email'];
            $confirmationEmail = $_SESSION['confirmation_email'];
            $password = $_SESSION['password'];
            $confirmationPassword = $_SESSION['confirmation_password'];
        }else {
            $name = "";
            $style = "";
            $prefecture = "";
            $select = "";
            $text = "";
            $image = "";
            $email = "";
            $confirmationEmail = "";
            $password = "";
            $confirmationPassword = "";
        }} else {
            $name = "";
            $style = "";
            $prefecture = "";
            $select = "";
            $text = "";
            $image = "";
            $email = "";
            $confirmationEmail = "";
            $password = "";
            $confirmationPassword = "";
        }} else {
            $name = "";
            $style = "";
            $prefecture = "";
            $select = "";
            $text = "";
            $image = "";
            $email = "";
            $confirmationEmail = "";
            $password = "";
            $confirmationPassword = "";
        }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $style = $_POST['style'];
        $prefecture = $_POST['prefecture'];
        $select = $_POST['select'];
        $text = $_POST['text'];
        $email = $_POST['email'];
        $confirmationEmail = $_POST['confirmation_email'];
        $password = $_POST['password'];
        $confirmationPassword = $_POST['confirmation_password'];

        $_SESSION['name'] = $name;
        $_SESSION['style'] = $style;
        $_SESSION['prefecture'] = $prefecture;
        $_SESSION['select'] = $select;
        $_SESSION['text'] = $text;
        $_SESSION['email'] = $email;
        $_SESSION['confirmation_email'] = $confirmationEmail;
        $_SESSION['password'] = $password;
        $_SESSION['confirmation_password'] = $confirmationPassword;

        $submitOK = 0;

        if ($_FILES['image']['size'] > 1024000) {
            $image_error = 'ファイルサイズは1MB以下にしてください';
        } else {
            $submitOK++;
        }

        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
        $file_parts = explode('.', $_FILES['image']['name']);
        $file_ext = strtolower(end($file_parts));
        if (!in_array($file_ext, $allowed_ext)) {
            $image_error = '許可されていない拡張子です';
        } else {
            $submitOK++;
        }

        $_SESSION['image'] = $_FILES['image'];

        $image_name = uniqid(mt_rand(), true) . '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
        $_SESSION['image_name'] = $image_name;
        $image_path = dirname(__FILE__) . '/../../assets/img/' . $image_name;

        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);

            if($style != 0) {
                $submitOK++;
            } else {
                $style_error = '業種が選択されていません';
            }

            if ($email == $confirmationEmail) {
                $submitOK++;
            } else {
                $email_error = 'メールアドレスと確認用メールアドレスが一致しません';
            }

            if ($password == $confirmationPassword) {
                $submitOK++;
            } else {
                $password_error = 'パスワードと確認用パスワードが一致しません';
            }

            if ($submitOK == 5) {
                header('Location: confirm.php');
            }
    }
}
?>

<!DOCTYPE html>
<html lang="ja"></html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>エージェント新規登録 CRAFT管理者画面 就活エージェント比較サイト</title>
    <link rel="stylesheet" href="../../assets/css/manager.css">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
    <!-- <header class="header" id="js-header">
        <div class="header-container">
            <a href="./" class="header-logo">
                <img src="../../assets/img/craft logo2.png" alt="POSSE③">
                <p>管理者画面</p>
            </a>
            <nav class="header-nav">
                <ul class="header-navList">
                    <li class="header-navItem">
                        <a href="login/index.php" class="header-navLink">
                            Logout
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="header-menu-box">
            <p class="header-menu">エージェント管理</p>
            <p class="header-menu">通報対応</p>
            <p class="header-menu">お問合せ</p>
            <p class="header-menu">FQA編集</p>
        </div>
    </header> -->
    <?php include(dirname(__FILE__) . '../../../components/manager/header.php'); ?>
    <div class="header-go"></div>
    <form class="form" method="POST" enctype="multipart/form-data">
        <h1 class="form-title">エージェント登録</h1>

        <label for="name" class="form-label">エージェント名<p class="form_error_message"></p></label>
        <input class="form-input" type="text" id="name" name="name" required>

        <label for="style" class="form-label">業種</label><p>
            <?php if (isset($style_error)) echo $style_error; ?>
        </p></label>
        <select class="select-form" id="style" name="style" required>
            <option class="select-form-input" disabled value="0">選択してください</option>
            <option class="select-form-input" value="1">総合型</option>
            <option class="select-form-input" value="2">理系職業</option>
            <option class="select-form-input" value="3">IT</option>
            <option class="select-form-input" value="4">芸術系</option>
        </select>
        
        <label for="prefecture" class="form-label">エリア</label>
        <select class="select-form" id="prefecture" name="prefecture">
            <option class="prefecture-input"value="1">全国</option>
            <option class="prefecture-input" value="2">北海道・東北</option>
            <option class="prefecture-input" value="3">関東</option>
            <option class="prefecture-input" value="4">中部</option>
            <option class="prefecture-input" value="5">近畿</option>
            <option class="prefecture-input" value="6">中国・四国</option>
            <option class="prefecture-input" value="7">九州・沖縄</option>
        </select>

        <label for="select" class="form-label">形態<span>(複数選択可)</span></label>
        <section class="select-form">
            <label class="select-label"><input class="select-input" type="checkbox" name="select[]" value="1" checked>大手</label>
            <label class="select-label"><input class="select-input" type="checkbox" name="select[]" value="2">中小</label>
            <label class="select-label"><input class="select-input" type="checkbox" name="select[]" value="3">ベンチャー</label>
            <label class="select-label"><input class="select-input" type="checkbox" name="select[]" value="4">外資系</label>
        </section>

        <label for="text" class="form-label">特徴(60字以内)<p class="form_error_message"></p></label>
        <input class="feature-input" type="text" id="text" name="text" maxlength="60" onkeyup="ShowLength( 'inputlength2' , value );" required>
        <p id="inputlength2">0文字</p>

        <label for="image" class="form-label">アイコン画像<span>(1MB以下)</span><p class="form_error_message">
            <?php if (isset($image_error)) echo $image_error; ?>
        </p></label>
        <input class="form-input" type="file" id="image" name="image" required placeholder="+">

        <label for="email" class="form-label">ログインID<span>(emailアドレス)</span><p class="form_error_message"></p></label>
        <input class="form-input" type="email" id="email" name="email" required placeholder="(例) carft.boozer@gmail.com">

        <label for="confirmation-email" class="form-label">確認用ログインID<span>(emailアドレス)</span><p class="form_error_message">
            <?php if (isset($email_error)) echo $email_error; ?>
        </p></label>
        <input class="form-input" type="email" id="confirmation-email" name="confirmation_email" required placeholder="(例) carft.boozer@gmail.com"></input>

        <label for="password" class="form-label">パスワード<p class="form_error_message"></p></label>
        <input class="form-input" type="password" id="password" name="password" required>

        <label for="password" class="form-label">確認用パスワード<p class="form_error_message">
            <?php if (isset($password_error)) echo $password_error; ?>
        </p></label>
        <input class="form-input" type="password" id="confirmation-password" name="confirmation_password" required>

        <div class="submit">
            <button type="submit" class="submit-button">確認</button>
        </div>
    </form>
    <script>
        //文字数カウント
        function ShowLength( idn, str ) {
        document.getElementById(idn).innerHTML = str.length + "文字";
}
        const submitButton = document.querySelector('.submit-button');
        const errorMessage = document.querySelectorAll('.form_error_message');
        const nameInput = document.getElementById('name');
        const styleForms = document.querySelectorAll('.select-form-input');
        const prefectureForms = document.querySelectorAll('.prefecture-input');
        const selectForms = document.querySelectorAll('.select-input');
        const textInput = document.getElementById('text');
        const imageInput = document.getElementById('image');
        const emailInput = document.getElementById('email');
        const confirmationEmailInput = document.getElementById('confirmation-email');
        const passwordInput = document.getElementById('password');
        const confirmationPasswordInput = document.getElementById('confirmation-password');
        let error = "";
        let errorNumber = 0;

                nameInput.value = "<?=$name?>";
                const style = "<?=$style?>";
                if (style != "") {
                    styleForms[style].selected = true;
                }
                const prefecture = "<?=$prefecture?>";
                if (prefecture != "") {
                    prefectureForms[prefecture - 1].selected = true;
                }

                <?php
                if ($select != "")
                foreach ($select as $value) {?>
                    selectForms[<?=$value?> - 1].checked = true;
                <?php }?>
                textInput.value = "<?=$text?>";
                emailInput.value = "<?=$email?>";
                confirmationEmailInput.value = "<?=$confirmationEmail?>";
                passwordInput.value = "<?=$password?>";
                confirmationPasswordInput.value = "<?=$confirmationPassword?>";

        submitButton.addEventListener('click', () => {
            errorNumber = 0;

            if (nameInput.value === '') {
                error = 'エージェント名が入力されていません';
                console.log(error);
                console.log(errorMessage[0]);
                errorMessage[0].textContent = error;
                errorNumber++;
            } else {
                    errorMessage[0].textContent = '';
            }


            if (textInput.value === '') {
            error = "特徴を入力してください";
            console.log(error);
            console.log(errorMessage[1]);
            errorMessage[1].textContent = error;
            errorNumber++;
            } else {
            errorMessage[1].textContent = '';
            }

            const image = imageInput.files[0];
            const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
             // エラーメッセージ初期化
            errorMessage[2].textContent = '';
            // 未選択の場合
            if (!image) {
                errorMessage[2].textContent = 'アイコン画像が選択されていません';
            }else if (image.size > 1024000) {
                errorMessage[2].textContent = 'ファイルサイズは1MB以下にしてください';
                return;
            }else if (image.name) {
                const extension = image.name.split('.').pop().toLowerCase();
                if (!allowedExtensions.includes(extension)) {
                    errorMessage[2].textContent = '許可されていない拡張子です';
                }
                } else {
                errorMessage[2].textContent = 'ファイル名が取得できません';
            }


        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (emailInput.value === '') {
            error = 'メールアドレスが入力されていません';
            console.log(error);
            console.log(errorMessage[3]);
            errorMessage[3].textContent = error;
            errorNumber++;
        } else if (!emailRegex.test(emailInput.value)) {
            error = 'メールアドレスの形式が正しくありません';
            errorMessage[3].textContent = error;
            errorNumber++;
        } else {
                errorMessage[3].textContent = '';
        }

        if (confirmationEmailInput.value === '') {
            error = '確認用メールアドレスが入力されていません';
            console.log(error);
            console.log(errorMessage[4]);
            errorMessage[4].textContent = error;
            errorNumber++;
        } else if (!emailRegex.test(confirmationEmailInput.value)) {
            error = '確認用メールアドレスの形式が正しくありません';
            errorMessage[4].textContent = error;
            errorNumber++;
        } else if (confirmationEmailInput.value !== emailInput.value) {
            error = 'メールアドレスと確認用メールアドレスが一致しません';
            errorMessage[4].textContent = error;
            errorNumber++;
        } else {
                errorMessage[4].textContent = '';
        }

        if (passwordInput.value === '') {
            error = 'パスワードが入力されていません';
            console.log(error);
            console.log(errorMessage[5]);
            errorMessage[5].textContent = error;
            errorNumber++;
        } else {
                errorMessage[5].textContent = '';
        }

        if (confirmationPasswordInput.value === '') {
            error = '確認用パスワードが入力されていません';
            console.log(error);
            console.log(errorMessage[6]);
            errorMessage[6].textContent = error;
            errorNumber++;
        } else if (passwordInput.value !== confirmationPasswordInput.value) {
            error = 'パスワードと確認用パスワードが一致しません';
            errorMessage[6].textContent = error;
            errorNumber++;
        } else {
                errorMessage[6].textContent = '';
        }

    });

    </script>
</body>
</html>
