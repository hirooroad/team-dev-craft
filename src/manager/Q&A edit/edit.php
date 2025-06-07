<?php
require(dirname(__FILE__) . '/../../dbconnect.php');

session_start();

if (!isset($_SESSION['agent'])) {
    header('Location: ../index.php');
} else {
    $stmt = $dbh->prepare('SELECT * FROM fqa WHERE id = :fqa_id');
    $stmt->bindValue(':fqa_id', $_GET['id']);
    $stmt->execute();
    $fqa = $stmt->fetch();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $destination = (int)$_POST['destination'];
        $stmt = $dbh->prepare('UPDATE fqa SET question = :question, answer = :answer, destination = :destination WHERE id = :fqa_id');
        $stmt->bindValue(':fqa_id', $_GET['id']);
        $stmt->bindValue(':question', $_POST['question']);
        $stmt->bindValue(':answer', $_POST['answer']);
        $stmt->bindValue(':destination', $destination);
        $stmt->execute();
        
        header('Location: index.php');
    }
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
    <main>
        <div class="header-go"></div>
        <h1 class="FQA_title">
            FQA編集
        </h1>
        <form method="POST" class="FQA_edit-form">
            <div class="FQA_fieldset"> <p class="FQA_subtitle">質問箇所</p>
                <label><input type="radio" name="destination" <?php echo ($fqa['destination'] == 0) ? 'checked' : ''; ?> class="FQA_check_button" value="0"> <p class="FQA_check_subtitle">学生様向け</p></label>
                <label><input type="radio" name="destination" <?php echo ($fqa['destination'] == 1) ? 'checked' : ''; ?> class="FQA_check_button" value="1"> <p class="FQA_check_subtitle">企業様向け</p></label>
            </div>
            <div>
                <label class="FQA_subtitle">
                    <p class="FQA_questionTitle">質問内容</p>
                    <textarea class="FQA_text" name="question" id="question"><?php echo $fqa['question']; ?></textarea>
                </label>
            </div>
            <div>
                <label class="FQA_subtitle">
                    <p class="FQA_questionTitle">回答内容</p>
                    <textarea class="FQA_text" name="answer" id="answer"><?php echo $fqa['answer']; ?></textarea>
                </label>
            </div>
            <div class="FQA_button_box">
                <button type="submit" class="FQA_addButton" disabled>追加</button>
            </div>
        </form>
        </section>
    </main>
    <script>

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
    </script>
</body>
