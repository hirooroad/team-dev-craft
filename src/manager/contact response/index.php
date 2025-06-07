<?php
require(dirname(__FILE__) . '/../../dbconnect.php');

session_start();
if (!isset($_SESSION['agent'])) {
        header('Location: ./login/index.php');
    } else {
        $stmt = $dbh->prepare('SELECT *  from questions');
        $stmt->execute();
        $questions = $stmt->fetchAll();

        $sorted_questions = rsort($questions);
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせ対応 CRAFT管理者画面 就活エージェント比較サイト</title>
    <link rel="stylesheet" href="../../assets/css/manager.css">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
<?php include(dirname(__FILE__) . '../../../components/manager/header.php'); ?>
<div class="header-go"></div>
    <main>
        <h1 class="contact_title">
            お問い合わせ対応
        </h1>
        <section>
            <table class="contact">
                <tr class="contact-top">
                    <th class="center">No.</th>
                    <th>申込者</th>
                    <th>フリガナ</th>
                    <th class="center">emailアドレス</th>
                    <th>貴社名</th>
                    <th></th>
                    <th>対応状態</th>
                </tr>
                <?php $question_count = 0;
                forEach($questions as $question) :?>
                <tr class="contact-contents">
                    <td class="center"><?=$question['id']?></td>
                    <td><?=$question['name']?></td>
                    <td><?=$question['furigana']?></td>
                    <td><?=$question['mail_address']?></td>
                    <td><?=$question['company']?></td>
                    <td class="center"><button class="contact-details" id="contact-details<?=$question_count?>">詳細</button></td>
                    <?php if($question['status'] == 0) {?>
                    <td class="center"><button type="button" class="contact-check" onclick="location.href='./confirm.php?id=<?= $question['id'] ?>&status=<?= $question['status'] ?>'"></button></td>
                    <?php } else {?>
                    <td class="center"><button type="button" class="contact-check contact-check-true"  onclick="location.href='./confirm.php?id=<?= $question['id'] ?>&status=<?= $question['status'] ?>'"></button></td>
                    <?php } ?>
                </tr>
                <?php $question_count++;
            endforeach; ?>
            </table>
        </section>

        <section>
            <?php $question_count = 0;
            forEach($questions as $question) :?>
                <div class="contact_overlay closed" id="contact_overlay<?=$question_count?>"></div>
                <div class="contact_pop_up closed" id="contact_pop_up<?=$question_count?>">
                    <div class="contact_top">
                        <p class="contact_title"><?=$question['name']?>様のお問い合わせ内容</p>
                        <button class="contact_closeButton" id="contact_closeButton<?=$question_count?>">
                            <img src="../../assets/img/batten.png" alt="">
                        </button>
                    </div>
                    <div class="contact_contents-block">
                        <p class="contact_contents-top">氏名</p>
                        <p class="contact_contents"><?=$question['name']?></p>

                        <p class="contact_contents-top">フリガナ</p>
                        <p class="contact_contents"><?=$question['furigana']?></p>

                        <p class="contact_contents-top">メールアドレス</p>
                        <p class="contact_contents"><?=$question['mail_address']?></p>

                        <p class="contact_contents-top">電話番号</p>
                        <p class="contact_contents"><?=$question['tele_number']?></p>

                        <?php if($question['company']) {?>
                        <p class="contact_contents-top">貴社名</p>
                        <p class="contact_contents"><?=$question['company']?></p>
                        <?php } ?>

                        <p class="contact_contents-top">お問い合わせ内容</p>
                        <p class="contact_contents"><?=$question['content']?></p>
                    </div>

                </div>
            <?php $question_count++;
        endforeach; ?>

        </section>
    </main>
    <script>

    <?php $question_count = 0;
    forEach($questions as $question) : ?>
    const contact<?=$question_count?> = document.querySelector("#contact_pop_up<?=$question_count?>");
    const contactOverlay<?=$question_count?> = document.querySelector("#contact_overlay<?=$question_count?>");
    const contactCloseButton<?=$question_count?> = document.querySelector("#contact_closeButton<?=$question_count?>");
    const contactOpenButton<?=$question_count?> = document.querySelector("#contact-details<?=$question_count?>");

    //閉じるボタン
    contactCloseButton<?=$question_count?>.addEventListener("click", function () {
    contact<?=$question_count?>.classList.toggle("closed");
    contactOverlay<?=$question_count?>.classList.toggle("closed");
    });

     //開くボタン
    contactOpenButton<?=$question_count?>.addEventListener("click", function() {
        contact<?=$question_count?>.classList.toggle("closed");
        contactOverlay<?=$question_count?>.classList.toggle("closed");
    });
    <?php $question_count++;
    endforeach; ?>
    </script>
</body>
</html>