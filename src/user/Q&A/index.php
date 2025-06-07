<?php
require(dirname(__FILE__) . './../../dbconnect.php');

session_start();

// if (!empty($_POST)) {
//     $name = $_POST['name'];
//     $furigana = $_POST['furigana'];
//     $mail_adress = $_POST['mail_adress'];
//     $confirmation_email_adress = $_POST['confirmation_email_adress'];
//     $tele_number = $_POST['tele_number'];
//     $company = $_POST['company'];
//     $content = $_POST['content'];

//     $_SESSION['application'] = 1;
//     $_SESSION['name'] = $name;
//     $_SESSION['furigana'] = $furigana;
//     $_SESSION['mail_adress'] = $mail_adress;
//     $_SESSION['confirmation_email_adress'] = $confirmation_email_adress;
//     $_SESSION['tele_number'] = $tele_number;
//     $_SESSION['company'] = $company;
//     $_SESSION['content'] = $content;
//
if(isset($_SESSION['application'])) {
if($_SESSION['application'] == 2) {
    $name = $_SESSION['name'];
    $furigana = $_SESSION['furigana'];
    $mail_adress = $_SESSION['mail_adress'];
    $confirmation_email_adress = $_SESSION['confirmation_email_adress'];
    $tele_number = $_SESSION['tele_number'];
    $company = $_SESSION['company'];
    $content = $_SESSION['content'];
}
else {
    $name = '';
    $furigana = '';
    $mail_adress = '';
    $confirmation_email_adress = '';
    $tele_number = '';
    $company = '';
    $content = '';
}
}
else {
    $name = '';
    $furigana = '';
    $mail_adress = '';
    $confirmation_email_adress = '';
    $tele_number = '';
    $company = '';
    $content = '';
}

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $furigana = $_POST['furigana'];
        $mail_adress = $_POST['mail_adress'];
        $confirmation_email_adress = $_POST['confirmation_email_adress'];
        $tele_number = $_POST['tele_number'];
        $company = $_POST['company'];
        $content = $_POST['content'];
    
        $error = '';

        $_SESSION['name'] = $name;
        $_SESSION['furigana'] = $furigana;
        $_SESSION['mail_adress'] = $mail_adress;
        $_SESSION['confirmation_email_adress'] = $confirmation_email_adress;
        $_SESSION['tele_number'] = $tele_number;
        $_SESSION['company'] = $company;
        $_SESSION['content'] = $content;

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

            if ($mail_adress == $confirmation_email_adress) {
                $submitOK++;
            } else {
                $email_error = 'メールアドレスと確認用メールアドレスが一致しません';
            }

            if (strlen($tele_number) >= 10 && strlen($tele_number) <= 11) {
                $submitOK++;
            } else {
                $phone_error = '電話番号の形式が正しくありません';
            }

            if ($submitOK == 4) {
                header('Location: confirm.php');
            }
    }



$stmt = $dbh->prepare('SELECT * FROM fqa WHERE status = 1 AND destination = 0 ');
$stmt->execute();
$faq_student = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $dbh->prepare('SELECT * FROM fqa WHERE status = 1 AND destination = 1 ');
$stmt->execute();
$faq_company = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FQA　CRAFT 就活エージェント比較サイト</title>
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
    <main class="QA">
        <div class="QA-title-box">
            <h1 class="QA_title">
                FQA
            </h1>
            <p class="QA_title_jp">
                よくある質問
            </p>
        </div>
        <section class="contact_box">
            <h2 class="contact_box_title">
                学生様向け
            </h2>
            <dl>
                <?php if(!empty($faq_student)) {
                forEach($faq_student as $fqa) :?>
                <div class="OA_content">
                    <dt  class="QA_question">
                        <span class="Q_logo">Q</span>
                        <p>
                            <?= $fqa['question']?>
                        </p>
                    </dt>
                    <dd class="QA_answer">
                    <div class="QA_details">
                        <span class="A_logo">A</span>
                        <p>
                            <?= $fqa['answer']?>
                        </p>
                </div>
                </dd>
                </div>
                <?php endforeach;
                } else { ?>
                    <p class="QA_nothing">現在、FQAは登録されていません</p>
                <?php }
                ?>
            </dl>
        </section>
        <section class="contact_box">
            <h2 class="contact_box_title">
                企業様向け
            </h2>
            <dl>
                <?php  if(!empty($faq_company)) {
                forEach($faq_company as $fqa) :?>
                <div class="OA_content">
                    <dt class="QA_question">
                        <span class="Q_logo">Q</span>
                        <p>
                            <?= $fqa['question']?>
                        </p>
                    </dt>
                    <dd class="QA_answer">
                    <div class="QA_details">
                        <span class="A_logo">A</span>
                        <p>
                            <?= $fqa['answer']?>
                        </p>
                </div>
                </dd>
                </div>
                <?php endforeach;
            } else {?>
                <p class="QA_nothing">現在、FQAは登録されていません</p>
            <?php } ?>
            </dl>
        </section>
        <div id="contact"></div>
        <section class="contact_box" >
            <h2 class="contact_box_title QA-application-title">お問い合わせはこちら</h2>
            <form method="POST">
                <label>
                    <div class="QA_form">
                        氏名（姓と名の間に全角スペース）<span class="QA_essential_information">※必須</span><p class="form_error_message">
                            <?php if(isset($name_error)) {
                                echo $name_error;
                            } ?>
                        </p>
                    </div>
                    <input class="QA_text" type="text" id="name" name="name"  required placeholder="（例）応募　太郎">
                </label><br>
                <label>
                    <div class="QA_form">
                        フリガナ（姓と名の間に全角スペース）<span class="QA_essential_information">※必須</span><p class="form_error_message">
                            <?php if(isset($furigana_error)) {
                                echo $furigana_error;
                            } ?>
                        </p>
                    </div>
                    <input class="QA_text" type="text" id="furigana" name="furigana" required placeholder="（例）オウボ　タロウ">
                </label><br>
                <label>
                    <div class="QA_form">
                        メールアドレス <span class="QA_essential_information">※必須</span><p class="form_error_message"></p>
                    </div>
                    <input class="QA_text" type="text" id ="mail_adress" name="mail_adress" required placeholder="（例）craft.boozer@gmail.com">
                </label><br>
                <label>
                    <div class="QA_form">
                        確認用メールアドレス<span class="QA_essential_information">※必須</span><p class="form_error_message">
                            <?php if(isset($email_error)) {
                                echo $email_error;
                            } ?>
                        </p>
                    </div>
                    <input class="QA_text" type="text" id="confirmation_email_adress" name="confirmation_email_adress" required placeholder="（例）craft.boozer@gmail.com">
                </label><br>
                <label>
                    <div class="QA_form">
                    電話番号<span class="QA_essential_information">※必須</span><p class="form_error_message">
                        <?php if(isset($phone_error)) {
                            echo $phone_error;
                        } ?>
                    </p>
                    </div>
                    <input class="QA_text" type="text" id="tele_number" name="tele_number" required  placeholder="（例）09012345678">
                </label><br>
                <label>
                    <div class="QA_form">
                        貴社名
                    </div>
                    <input class="QA_text" type="text" id="company" name="company" placeholder="（例）株式会社boozer">
                </label><br>
                <label>
                    <div  class="QA_form">
                        お問い合わせ内容<span class="QA_essential_information">※必須</span><p class="form_error_message"></p>
                    </div>
                    <textarea class="contact-content" id="content" name="content" required></textarea>
                </label><br>
                <h2 class="QA_confirmation">お問い合わせにあたっての注意事項</h2>
                <div class="QA_confirmation_contents">
                    <ul>
                        <li><p>お問い合わせいただいた内容すべてに回答できない場合がありますので、ご理解ください</p></li>
                        <li><p>また、当サイトと関係ないお問い合わせに関しましては、回答を控えさせていただいておりますので、ご了承ください</p></li>
                    </ul>
                </div>
                <label class="QA_check"><input class="confirmation_check" type="checkbox" id="confirmationBox">上記注意事項に同意する<span class="QA_essential_information">※必須</span><p class="confirmation_error_message"></p></label>
                <div class="QA_submit">
                    <button type="submit" class="QA_submit-button" disabled>送信</button>
                </div>
            </form>
        </section>

        <!-- <section>
            <div class="QA_overlay closed" id="QA_overlay"></div>
            <div class="QA_pop_up closed" id="QA_pop_up">
                <div class="QA_top">
                    <p class="QA_confirm_title">入力内容確認</p>
                    <button class="QA_closeButton" id="QA_closeButton">
                        <img src="../../assets/img/batten.png" alt="">
                    </button>
                </div>
                <div class="QA_contents-block">
                    <p class="QA_contents-top">氏名</p>
                    <p class="QA_contents"><?=$name?></p>

                    <p class="QA_contents-top">フリガナ</p>
                    <p class="QA_contents"><?=$furigana?></p>

                    <p class="QA_contents-top">メールアドレス</p>
                    <p class="QA_contents"><?=$mail_adress?></p>

                    <p class="QA_contents-top">確認用メールアドレス</p>
                    <p class="QA_contents"><?=$confirmation_email_adress?></p>
                    <p class="QA_contents-top">電話番号</p>
                    <p class="QA_contents"><?=$tele_number?></p>

                    <p class="QA_contents-top">貴社名</p>
                    <p class="QA_contents"><?=$company?></p>

                    <p class="QA_contents-top">お問い合わせ内容</p>
                    <p class="QA_contents"><?=$content?></p>
                </div>
                <div class="QA_pop_button">
                        <button class="QA_reinputButton" onclick="location.href='./index.php'">入力しなおす</button>
                        <button class="QA_sendButton" onclick="location.href='./index.php'">送信を完了する</button>
                </div>

            </div>

        </section> -->
        <!-- <section>
        <div class="QA_overlay closed" id="QA_overlay"></div>
            <div class="QA_pop_up closed" id="QA_pop_up">
                <div class="QA_complete">
                    <p class="QA_confirm_finish">✅</p>
                    <p class="QA_confirm_finish">送信が完了しました</p>
                    <button class="QA_closeButton" id="QA_closeButton">
                        <img src="../../assets/img/batten.png" alt="">
                    </button>
                </div>
            </div>
        </section> -->
    </main>
    <?php include(dirname(__FILE__) . '../../../components/user/footer.php'); ?>
    <script>
    {
        const QAaccordion = document.querySelectorAll('dt');

        QAaccordion.forEach(dt => {
        dt.addEventListener("click", () => {
        dt.parentNode.classList.toggle("appear");
    });
    });
    }
        // 詳細表示画面、ポップアップの実装

        // const qa = document.querySelector("#QA_pop_up");
        // const qaOverlay = document.querySelector("#QA_overlay");
        // const qaCloseButton = document.querySelector("#QA_closeButton");
        // const qaOpenButton = document.querySelectorAll(".QA_submit-button");
        // // const likeCloseButton2 = document.querySelector("#likeList-closeButton2");

        // //閉じるボタン
        // qaCloseButton.addEventListener("click", function () {
        // qa.classList.toggle("closed");
        // qaOverlay.classList.toggle("closed");
        // });

        // likeCloseButton2.addEventListener("click", function () {
        //     likeList.classList.toggle("closed");
        //     likeListOverlay.classList.toggle("closed");
        //   });

        //開くボタン
        // qaOpenButton.forEach(function(button) {
        //     button.addEventListener("click", function() {
        //         qa.classList.toggle("closed");
        //         qaOverlay.classList.toggle("closed");
        //     });
        // });

        // 送信完了画面、ポップアップの実装
//         const sendButton = document.querySelector('.QA_sendButton');

//         sendButton.addEventListener("click", () => {
//             qa.classList.toggle("closed");
//             qaOverlay.classList.toggle("closed");
//         });
// }


    const confirmationBox = document.getElementById('confirmationBox');
    const submitButton = document.querySelector('.QA_submit-button');

    confirmationBox.addEventListener('change', () => {
        if (confirmationBox.checked) {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    });

    const errorMessage = document.querySelectorAll('.form_error_message');
    const nameInput = document.getElementById('name');
    const furiganaInput = document.getElementById('furigana');
    const mailAdressInput = document.getElementById('mail_adress');
    const confirmationEmailAdressInput = document.getElementById('confirmation_email_adress');
    const teleNumberInput = document.getElementById('tele_number');
    const companyInput = document.getElementById('company');
    const contentInput = document.getElementById('content');

    nameInput.value = "<?= $name?>";
    furiganaInput.value = "<?=$furigana?>";
    mailAdressInput.value = "<?=$mail_adress?>";
    confirmationEmailAdressInput.value = "<?=$confirmation_email_adress?>";
    teleNumberInput.value = "<?=$tele_number?>";
    companyInput.value = "<?=$company?>";
    contentInput.value = "<?=$content?>";

    let error = "";
    let errorNumber = 0;

    /**nameInput.value = "<?= $name?>";
    furiganaInput.value = "<?=$furigana?>";
    mailAdressInput.value = "<?=$mail_adress?>";
    confirmationEmailAdressInput.value = "<?=$confirmation_email_adress?>";
    teleNumberInput.value = "<?=$tele_number?>";
    contentInput.value = "<?=$content?>";*/

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
            errorMessage[0].textContent = "";
        }

        if (furiganaInput.value === "") {
            error = "フリガナが入力されていません";
            console.log(error);
            console.log(errorMessage[1]);
            errorMessage[1].textContent = error;
            errorNumber++;
        } else if (!furiganaInput.value.includes('　')) {
            error = 'フリガナに全角スペースが入っていません';
            errorMessage[1].textContent = error;
            errorNumber++;
        } else {
            errorMessage[1].textContent = "";
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (mailAdressInput.value === "") {
            error = "メールアドレスを入力されていません";
            console.log(error);
            console.log(errorMessage[2]);
            errorMessage[2].textContent = error;
            errorNumber++;
        } else if (!emailRegex.test(mailAdressInput.value)) {
            error = 'メールアドレスの形式が正しくありません';
            errorMessage[2].textContent = error;
            errorNumber++;
        }else {
            errorMessage[2].textContent = "";
        }

        if (confirmationEmailAdressInput.value === "") {
            error = "確認用メールアドレスを入力してください";
            console.log(error);
            console.log(errorMessage[3]);
            errorMessage[3].textContent = error;
            errorNumber++;
        } else if (!emailRegex.test(confirmationEmailAdressInput.value)) {
            error = '確認用メールアドレスの形式が正しくありません';
            errorMessage[3].textContent = error;
            errorNumber++;
        } else if (mailAdressInput.value !== confirmationEmailAdressInput.value) {
            error = 'メールアドレスと確認用メールアドレスが一致しません';
            errorMessage[3].textContent = error;
            errorNumber++;
        } else {
            errorMessage[3].textContent = "";
        }

        const phoneRegex = /^\d{10,11}$/;

        if (teleNumberInput.value === "") {
            error = "電話番号を入力してください";
            console.log(error);
            console.log(errorMessage[4]);
            errorMessage[4].textContent = error;
            errorNumber++;
        } else if (!phoneRegex.test(teleNumberInput.value)) {
            error = '電話番号の形式が正しくありません';
            errorMessage[4].textContent = error;
            errorNumber++;
        } else {
            errorMessage[4].textContent = "";
        }

        if (contentInput.value === "") {
            error = "お問い合わせ内容を入力してください";
            console.log(error);
            console.log(errorMessage[5]);
            errorMessage[5].textContent = error;
            errorNumber++;
        } else {
            errorMessage[5].textContent = "";
        }

        console.log(errorNumber);


        if (errorNumber === 0 && confirmationBox.checked) {
            location.href = './confirm.php';
        }
    });
    </script>
</body>
</html>