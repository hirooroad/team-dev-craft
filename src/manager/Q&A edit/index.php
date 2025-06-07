<?php
require(dirname(__FILE__) . '/../../dbconnect.php');

session_start();

if (!isset($_SESSION['agent'])) {
    header('Location: ../index.php');
} else {

    $stmt = $dbh->prepare('SELECT *  from fqa WHERE destination = 0');
    $stmt->execute();
    $fqa_student = $stmt->fetchAll();

    $stmt = $dbh->prepare('SELECT *  from fqa WHERE destination = 1');
    $stmt->execute();
    $fqa_company = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FQA編集 CRAFT管理者画面 就活エージェント比較サイト</title>
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
        <h1 class="FQA_title">
            FQA一覧
        </h1>
        <h2 class="FQA_subtitle">
            学生様向け
        </h2>
        <section>
            <table class="FQA">
                    <tr class="FQA-top">
                        <th class="center">No.</th>
                        <th>質問</th>
                        <th>回答</th>
                        <th>掲載日</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php foreach ($fqa_student as $fqa) : ?>
                        <tr class="FQA-contents">
                            <td class="center"><?= $fqa['id'] ?></td>
                            <td><?php if (mb_strlen($fqa['question']) >= 18) {
                                echo mb_substr($fqa['question'], 0, 17) . "...";
                            }else {
                                echo $fqa['question'];
                            } ?></td>
                            <td><?php
                            if (mb_strlen($fqa['answer']) >= 21) {
                                echo mb_substr($fqa['answer'], 0, 20) . "...";

                            } else {
                                echo $fqa['answer'];
                            }?></td>
                            <td class="center"><?= $fqa['start_day'] ?></td>
                            <td class="center"><button class="FQA_edit" onclick="location.href='./edit.php?id=<?=$fqa['id']?>'">編集</button></td>
                            <?php if($fqa['status'] == 1) : ?>
                            <td class="center"><button class="FQA_appear" onclick="location.href='./status.php?id=<?=$fqa['id']?>&status=<?=$fqa['status']?>'">非掲載</button></td>
                            <?php else : ?>
                            <td class="center"><button class="FQA_appear FQA_disappear" onclick="location.href='./status.php?id=<?=$fqa['id']?>&status=<?=$fqa['status']?>'">掲載</button></td>
                            <?php endif; ?>
                            <td class="center"><button class="FQA_delete" onclick="location.href='./delete.php?id=<?=$fqa['id']?>'">削除</button></td>
                        </tr>
                    <?php endforeach; ?>
            </table>
        </section>

        <h2 class="FQA_subtitle">
            企業様向け
        </h2>
        <section>
        <table class="FQA">
                    <tr class="FQA-top">
                        <th class="center">No.</th>
                        <th>質問</th>
                        <th>回答</th>
                        <th>掲載日</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php foreach ($fqa_company as $fqa) : ?>
                        <tr class="FQA-contents">
                            <td class="center"><?= $fqa['id'] ?></td>
                            <td><?php if (mb_strlen($fqa['question']) >= 18) {
                                echo mb_substr($fqa['question'], 0, 17) . "...";
                            }else {
                                echo $fqa['question'];
                            } ?></td>
                            <td><?php
                            if (mb_strlen($fqa['answer']) >= 21) {
                                echo mb_substr($fqa['answer'], 0, 20) . "...";

                            } else {
                                echo $fqa['answer'];
                            }?></td>
                            <td class="center"><?= $fqa['start_day'] ?></td>
                            <td class="center"><button class="FQA_edit" onclick="location.href='./edit.php?id=<?=$fqa['id']?>'">編集</button></td>
                            <?php if($fqa['status'] == 1) : ?>
                            <td class="center"><button class="FQA_appear" onclick="location.href='./status.php?id=<?=$fqa['id']?>&status=<?=$fqa['status']?>'">非掲載</button></td>
                            <?php else : ?>
                            <td class="center"><button class="FQA_appear FQA_disappear" onclick="location.href='./status.php?id=<?=$fqa['id']?>&status=<?=$fqa['status']?>'">掲載</button></td>
                            <?php endif; ?>
                            <td class="center"><button class="FQA_delete" onclick="location.href='./delete.php?id=<?=$fqa['id']?>'">削除</button></td>
                        </tr>
                    <?php endforeach; ?>
            </table>
        </section>
        <section class="FQA_add_box">
        <h1 class="FQA_title">
            FQA追加
        </h1>
        <form action="./create.php" method="POST">
            <div class="FQA_fieldset"> <p class="FQA_subtitle">質問箇所</p>
                <label><input type="radio" name="destination" checked class="FQA_check_button" value="0"> <p class="FQA_check_subtitle">学生様向け</p></label>
                <label><input type="radio" name="destination" class="FQA_check_button" value="1"> <p class="FQA_check_subtitle">企業様向け</p></label>
            </div>
            <div>
                <label class="FQA_subtitle">
                    <p class="FQA_questionTitle">質問内容</p>
                    <textarea class="FQA_text" name="question" id="question"></textarea>
                </label>
            </div>
            <div>
                <label class="FQA_subtitle">
                    <p class="FQA_questionTitle">回答内容</p>
                    <textarea class="FQA_text" name="answer" id="answer"></textarea>
                </label>
            </div>
            <div class="FQA_button_box">
                <button type="submit" class="FQA_addButton" disabled>追加</button>
            </div>
        </form>
        </section>

        <!-- <section>
            <div class="FQA_overlay closed" id="FQA_overlay"></div>
            <div class="FQA_pop_up closed" id="FQA_pop_up">
                <div class="FQA_top">
                    <button class="FQA_closeButton" id="FQA_closeButton">
                        <img src="../../assets/img/batten.png" alt="">
                    </button>
                </div>
                <div class="FQA_contents-block">
                    <p class="FQA_contents-top">質問内容</p>
                    <textarea class="FQA_contents"></textarea>

                    <p class="FQA_contents-top">回答内容</p>
                    <textarea class="FQA_contents"></textarea>
            </div>
            <div class="FQA_pop_button">
                    <button class="FQA_editButton" onclick="location.href='./index.php'">編集完了</button>
            </div>
        </div>
        </section> -->
    </main>

    <script>
{
const question = document.getElementById('question');
const answer = document.getElementById('answer');
    // テキストエリアの入力状態によってボタンの有効・無効を切り替える
    function checkInput() {
        if (question.value === '' || answer.value === '') {
            // Disable the submit button
            document.querySelector('.FQA_addButton').disabled = true;
            console.log('disabled');
        } else {
            // Enable the submit button
            document.querySelector('.FQA_addButton').disabled = false;
            console.log('enabled');
        }
    }

    question.addEventListener('input', checkInput);
    {
        if (question.value === '' || answer.value === '') {
            // Disable the submit button
            document.querySelector('.FQA_addButton').disabled = true;
            console.log('disabled');
        } else {
            // Enable the submit button
            document.querySelector('.FQA_addButton').disabled = false;
            console.log('enabled');
    };
    }
    answer.addEventListener('input', checkInput);{
        if (question.value === '' || answer.value === '') {
            // Disable the submit button
            document.querySelector('.FQA_addButton').disabled = true;
            console.log('disabled');
        } else {
            // Enable the submit button
            document.querySelector('.FQA_addButton').disabled = false;
            console.log('enabled');
        }
    }
    if (document.getElementById('question').value === '' || document.getElementById('answer').value === '') {
        // Disable the submit button
        document.querySelector('.FQA_addButton').disabled = true;
    } else {
        // Enable the submit button
        document.querySelector('.FQA_addButton').disabled = false;
    }
}
    </script>
</body>
</html>