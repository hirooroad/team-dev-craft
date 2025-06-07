<?php
require(dirname(__FILE__) . '/../../dbconnect.php');

session_start();

if (!isset($_SESSION['agent_id'])) {
    header('Location: ../login/index.php');
} else if(!isset($_GET['id'])) {
    header('Location: ../index.php');
} else {
$stmt = $dbh->prepare('SELECT * FROM applicants WHERE id = :applicant_id');
    $stmt->bindValue(':applicant_id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $applicant = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>通報フォーム CRAFT for Agent 就活エージェント比較サイト</title>
    <link rel="stylesheet" href="../../assets/css/agent.css">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
<?php include(dirname(__FILE__) . '../../../components/agent/header.php'); ?>
    <main>
        <div class="header-go"></div>
        <p class="alert-teach">こちらは、通報フォームです。申込の内容が不正と感じた時のみご利用ください。</p>
        <div class="alert-box">
            <form method="POST">
                <h1 class="alert-title">通報フォーム</h1>
                <div class="alert-item">
                    <p class="alert-item-top">通報対象：</p>
                    <p class="alert-item-content"><?=$applicant[0]['name']?></p>
                </div>
                <div class="alert-item">
                    <p class="alert-item-top">通報内容：</p>
                    <form action="">
                        <select name="area" id="area" class="alert-item-select">
                            <option disabled selected value="0">選択してください</option>
                            <option value="1">氏名</option>
                            <option value="2">生年月日</option>
                            <option value="3">メールアドレス</option>
                            <option value="4">住所</option>
                            <option value="5">電話番号</option>
                            <option value="6">最終学歴・文理区分</option>
                            <option value="7">卒業見込年</option>
                            <option value="8">その他</option>
                        </select>
                    </form>
                        </div>
                        <div>
                <p class="alert-reason-top">通報箇所：
                </p>
                <form action="">
                    <textarea name="reason" id="reason" class="alert-reason"></textarea>
                </form>
                        </div>
                        <button class="alert-confirm-button">確認</button>
                    </main>
            </form>
    <script>
        const area = document.getElementById('area');
        const reason = document.getElementById('reason');
        const confirmButton = document.querySelector('.alert-confirm-button');

        confirmButton.addEventListener('click', () => {
            if (area.value === '0' || reason.value === '') {
                alert('未入力の項目があります');
            } else {
                location.href = './confirm.php?id=<?=$_GET['id']?>&area=' + area.value + '&reason=' + reason.value;
            }
        });
    </script>
</body>
</html>