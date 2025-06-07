<?php
require(dirname(__FILE__) . './../../dbconnect.php');

session_start();

if(isset($_SESSION['name'])) {
    if($_SESSION['application'] == 1){
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
    } else {
        $name = '';
        $furigana = '';
        $birthdate = '';
        $gender = '';
        $email = '';
        $confirmationEmail = '';
        $address = '';
        $phone = '';
        $humaScience = '';
        $school = '';
        $graduationDate = '';
    }} else {
        $name = '';
        $furigana = '';
        $birthdate = '';
        $gender = '';
        $email = '';
        $confirmationEmail = '';
        $address = '';
        $phone = '';
        $humaScience = '';
        $school = '';
        $graduationDate = '';
    }

    $name_error = 0;
    $furigana_error = 0;
    $email_error = 0;
    $phone_error = 0;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // エラーチェック
        $name = $_POST['name'];
        $furigana = $_POST['furigana'];
        $birthdate = $_POST['birthdate'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $confirmationEmail = $_POST['confirmation-email'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $humaScience = $_POST['huma-science'];
        $school = $_POST['school'];
        $graduationDate = $_POST['graduationdate'];
        $agent = $_POST['agent'];

        $_SESSION['application'] = 1;
        $_SESSION['name'] = $name;
        $_SESSION['furigana'] = $furigana;
        $_SESSION['birthdate'] = $birthdate;
        $_SESSION['gender'] = $gender;
        $_SESSION['email'] = $email;
        $_SESSION['confirmation-email'] = $confirmationEmail;
        $_SESSION['address'] = $address;
        $_SESSION['phone'] = $phone;
        $_SESSION['huma-science'] = $humaScience;
        $_SESSION['school'] = $school;
        $_SESSION['graduationdate'] = $graduationDate;
        $_SESSION['agent'] = $agent;

            $submitOK = 0;

            if (strpos($name, '　') !== false) {
                $submitOK++;
            } else {
                $name_error = '氏名には全角スペースを含めてください';
            }
    
            if (strpos($furigana, '　') !== false) {
                $submitOK++;
            } else {
                $furigana_error = 'フリガナには全角スペースを含めてください';
            }

            if ($_POST['email'] == $_POST['confirmation-email']) {
                $submitOK++;
            } else {
                $email_error = 'メールアドレスと確認用メールアドレスが一致しません';
            }

            if (strlen($_POST['phone']) >= 10 && strlen($_POST['phone']) <= 11) {
                $submitOK++;
            } else {
                $phone_error = '電話番号の形式が正しくありません';
            }

            if ($submitOK == 4) {
                header('Location: confirm.php');
            }

    require(dirname(__FILE__) . './../../dbconnect.php');
                }

    // $emailcheck = $dbh->query('SELECT mail_address FROM applicants WHERE mail_address = :email')->fetchAll(PDO::FETCH_ASSOC);;
?>

<!DOCTYPE html>
<html lang="en"></html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>申込みフォーム　CRAFT就活エージェント比較サイト</title>
    <link rel="stylesheet" href="../../assets/css/user.css">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/sp/user.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
<?php include(dirname(__FILE__) . '../../../components/user/header.php'); ?>
    <div class="form-text">
        <p>
            申し込みをするためには、登録が必要です。<br>以下の項目に回答してください。
        </p>
    </div>
    <div class="word-box">
        <div class="word-box-container">
            <p class="form-process">
                登録の流れ
            </p>
            <div class="word-container">
                <div class="form-word1">入力</div>
                <div class="form-word2">確認</div>
                <div class="form-word3">完了</div>
            </div>
        </div>
    </div>
    <form class="form" method="post">
        <h1 class="form-title">お申込みフォーム</h1>

        <label for="name" class="form-label">氏名<span>(姓と名の間に全角スペース)</span><span class="indispensable">※必須</span><p class="form_error_message">
            <?php if($name_error != 0) {echo $name_error;} ?>
        </p></label>
        <input class="form-input" type="text" id="name" name="name" required placeholder="(例) 応募　太郎">

        <label for="name" class="form-label">フリガナ<span>(姓と名の間に全角スペース)</span><span class="indispensable">※必須</span><p class="form_error_message">
            <?php if($furigana_error != 0) {echo $furigana_error;} ?>
        </p></label>
        <input class="form-input" type="text" id="furigana" name="furigana" required placeholder="(例) オウボ　タロウ">

        <label for="birthdate" class="form-label">生年月日<span class="indispensable">※必須</span><p class="form_error_message"></p></label>
        <input class="form-input" type="date" id="birthdate" name="birthdate" required>

        <label for="gender" class="form-label">性別<span class="indispensable">※必須</span><p class="form_error_message"></p></label>
        <section class="form-gender" id="form-gender">
            <label class="gender-label"><input class="gender-input" type="radio" name="gender" value="1">男性</label>
            <label class="gender-label"><input class="gender-input" type="radio" name="gender" value="2">女性</label>
            <label class="gender-label"><input class="gender-input" type="radio" name="gender" value="3">その他</label>
        </section>
        

        <label for="email" class="form-label">メールアドレス<span class="indispensable">※必須</span><p class="form_error_message"></p></label>
        <input class="form-input" type="email" id="email" name="email" required placeholder="(例) carft.boozer@gmail.com">

        <label for="confirmation-email" class="form-label">確認用メールアドレス<span class="indispensable">※必須</span><p class="form_error_message">
            <?php if($email_error !=0) {echo $email_error;} ?>
        </p></label>
        <input class="form-input" type="email" id="confirmation-email" name="confirmation-email" required placeholder="(例) carft.boozer@gmail.com"></input>

        <label for="address" class="form-label">住所<span class="indispensable">※必須</span><p class="form_error_message"></p></label>
        <input class="form-input" type="text" id="address" name="address" required placeholder="(例) 東京都港区青山3丁目15-9MINOWA表参道　3階">

        <label for="phone" class="form-label">電話番号<span class="indispensable">※必須</span><p class="form_error_message">
        <?php if($phone_error != 0) {echo $phone_error ;} ?>
        </p></label>
        <input class="form-input" type="tel" id="phone" name="phone" required placeholder="(例) 09012345678">

        <label for="phone" class="form-label">文理区分<span class="indispensable">※必須</span><p class="form_error_message"></p></label>
        <section class="form-gender">
            <label class="science-label"><input class="science-input" type="radio" name="huma-science" value="1">文系</label>
            <label class="science-label"><input class="science-input" type="radio" name="huma-science" value="2">理系</label>
            <label class="science-label"><input class="science-input" type="radio" name="huma-science" value="3">文理融合</label>
        </section>

        <label for="school" class="form-label">最終学歴<span class="indispensable">※必須</span><p class="form_error_message"></p></label>
        <input class="form-input" type="text" id="school" name="school" required placeholder="(例) ○○大学 ○○学部 ○○学科">
        <!-- <input class="form-input" type="text" id="school" name="school" required placeholder="(例) ○○学部">
        <input class="form-input" type="text" id="school" name="school" required placeholder="(例) ○○学科"> -->

        <label for="birthdate" class="form-label">卒業見込年<span class="indispensable">※必須</span><p class="form_error_message"></p></label>
        <input class="form-input" type="month" id="graduationdate" name="graduationdate" required>

        <label for="birthdate" class="form-label">情報利用ポリシー<span class="indispensable">※必須</span></label>
        <p class="information-use-policy">
            CRAFTでは、お客様の情報を以下の用途に利用します。
            <br>(1)エージェント会社様への送信
            <br>(2)エージェント会社様が違法な申し込みと判断した場合、boozer社が閲覧する可能性があります。
            <br>個人情報を、それ以外の会社に送信することは一切ございません。
        </p>
        <input class="form-checkbox" type="checkbox" id="myCheckbox">
        <label for="myCheckbox" class="checkbox-label">情報利用ポリシーに同意する<span class="indispensable">※必須</span></label>

        <label for="application">
            <ul id="application-id">
            </ul>
        </label>

        <div class="submit">
            <button type="submit" class="submit-button" disabled>入力内容の確認</button>
        </div>
    </form>
    <script>
        const myCheckbox = document.getElementById('myCheckbox');
        const submitButton = document.querySelector('.submit-button');

        myCheckbox.addEventListener('change', () => {
            if (myCheckbox.checked) {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true;
            }
        });

        const errorMessage = document.querySelectorAll('.form_error_message');
        const nameInput = document.getElementById('name');
        const furiganaInput = document.getElementById('furigana');
        const birthDate = document.getElementById('birthdate');
        const formGenders = document.querySelectorAll('.gender-input');
        const emailInput = document.getElementById('email');
        const confirmationEmailInput = document.getElementById('confirmation-email');
        const addressInput = document.getElementById('address');
        const phoneInput = document.getElementById('phone');
        const scienceInput = document.querySelectorAll('.science-input');
        const schoolInput = document.getElementById('school');
        const graduationYear = document.getElementById('graduationdate');
        let error = "";
        let errorNumber = 0;

        let items = JSON.parse(localStorage.getItem("items"));
        const applicationId = document.getElementById('application-id');
        let countNumber = 0;

        items.forEach((item) => {
            const agent = document.createElement('li');
            const agentInput = document.createElement('input');
            agentInput.type = 'hidden';
            agentInput.name = 'agent['+countNumber+']';
            agentInput.value = item.aid;
            agent.appendChild(agentInput);
            applicationId.appendChild(agent);
            countNumber++;
        });

        nameInput.value = "<?=$name?>";
                furiganaInput.value = "<?=$furigana?>";
                birthDate.value = "<?=$birthdate?>";
                const gender = "<?=$gender?>";
                if(gender != "") {
                formGenders[gender - 1].checked = true;
                }
                emailInput.value = "<?=$email?>";
                confirmationEmailInput.value = "<?=$confirmationEmail?>";
                addressInput.value = "<?=$address?>";
                phoneInput.value = "<?=$phone?>";
                const humaScience = "<?=$humaScience?>";
                if(humaScience != "") {
                scienceInput[humaScience - 1].checked = true;
                }
                schoolInput.value = "<?=$school?>";
                graduationYear.value = "<?=$graduationDate?>";

        submitButton.addEventListener('click', () => {
            errorNumber = 0;
            if (nameInput.value === '') {
                error = '名前が入力されていません';
                console.log(error);
                console.log(errorMessage[0]);
                errorMessage[0].textContent = error;
                errorNumber++;
            } else if (!nameInput.value.includes('　')) {
                error = '名前に全角スペースが入っていません';
                errorMessage[0].textContent = error;
                errorNumber++;
            } else {
                    errorMessage[0].textContent = '';
            }

            if(furiganaInput.value === '') {
                error = 'フリガナが入力されていません';
                errorMessage[1].textContent = error;
                errorNumber++;
            } else if (!furiganaInput.value.includes('　')) {
                error = 'フリガナに全角スペースが入っていません';
                errorMessage[1].textContent = error;
                errorNumber++;
            } else {
                    errorMessage[1].textContent = '';
            }

            if(birthDate.value === '') {
                error = '生年月日が入力されていません';
                errorMessage[2].textContent = error;
                errorNumber++;
            } else {
                    errorMessage[2].textContent = '';
            }

            genderCheck = 0;

            console.log(formGenders);
            for (const formGender of formGenders) {
                console.log(formGender);
            if (formGender.checked) {
            genderCheck++;
            }
            }

            if (genderCheck === 0) {
                error = '性別が選択されていません';
            errorMessage[3].textContent = error;
            errorNumber++;
            } else {
            errorMessage[3].textContent = '';
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (emailInput.value === '') {
            error = 'メールアドレスが入力されていません';
            errorMessage[4].textContent = error;
            errorNumber++;
        } else if (!emailRegex.test(emailInput.value)) {
            error = 'メールアドレスの形式が正しくありません';
            errorMessage[4].textContent = error;
            errorNumber++;
        } else {
                errorMessage[4].textContent = '';
        }

        if (confirmationEmailInput.value === '') {
            error = '確認用メールアドレスが入力されていません';
            errorMessage[5].textContent = error;
            errorNumber++;
        } else if (!emailRegex.test(confirmationEmailInput.value)) {
            error = '確認用メールアドレスの形式が正しくありません';
            errorMessage[5].textContent = error;
            errorNumber++;
        } else if (emailInput.value !== confirmationEmailInput.value) {
            error = 'メールアドレスと確認用メールアドレスが一致しません';
            errorMessage[5].textContent = error;
            errorNumber++;
        } else {
                errorMessage[5].textContent = '';
        }

        if (addressInput.value === '') {
            error = '住所が入力されていません';
            errorMessage[6].textContent = error;
            errorNumber++;
        } else {
                errorMessage[6].textContent = '';
        }

        const phoneRegex = /^\d{10,11}$/;

        if (phoneInput.value === '') {
            error = '電話番号が入力されていません';
            errorMessage[7].textContent = error;
            errorNumber++;
        } else if (!phoneRegex.test(phoneInput.value)) {
            error = '電話番号の形式が正しくありません';
            errorMessage[7].textContent = error;
            errorNumber++;
        } else {
                errorMessage[7].textContent = '';
        }

        let scienceCheck = 0;

        for (const science of scienceInput) {
            if (science.checked) {
                scienceCheck++;
                break;
            }
        }

        if (scienceCheck === 0) {
            error = '文理区分が選択されていません';
            errorMessage[8].textContent = error;
            errorNumber++;
        } else {
            errorMessage[8].textContent = '';
        }

        if (schoolInput.value === '') {
            error = '最終学歴が入力されていません';
            errorMessage[9].textContent = error;
            errorNumber++;
        } else {
                errorMessage[9].textContent = '';
        }

        if (graduationYear.value === '') {
            error = '卒業見込年が入力されていません';
            errorMessage[10].textContent = error;
            errorNumber++;
        } else {
                errorMessage[10].textContent = '';
        }

        console.log(errorNumber);

        if (errorNumber === 0) {
            location.href = './confirm.php';
        }
        });
    </script>
</body>
</html>