<?php
require(dirname(__FILE__) . '/../../dbconnect.php');

session_start();

if (!isset($_SESSION['agent'])) {
    header('Location: ../index.php');
} else {

if (isset($_POST['destroy'])) {
    session_start();
    $_SESSION = array();
    session_destroy();
    header('Location: ../index.php');
}
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メニュー CRAFT管理者画面 就活エージェント比較サイト</title>
    <link rel="stylesheet" href="../../assets/css/manager.css">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
</head>
<body class="menu-body">
<?php include(dirname(__FILE__) . '../../../components/manager/header2.php'); ?>
    <div class="menu-header-go"></div>
    <main class="menu-main">
        <div class="menu-title-box">
            <h1 class="menu-title">MENU</h1>
            <h2 class="menu-subtitle">メニュー</h2>
        </div>
        <div class="menu-container">
            <button onclick="location.href='../look/index.php'">
                <div class="menu-item">
                    <a class="menu-text" href="../look/index.php">エージェント管理</a>
                </div>
            </button>
            <button onclick="location.href='../report response/index.php'">
                <div class="menu-item">
                    <a class="menu-text" href="../report response/index.php">通報対応</a>
                </div>
            </button>
            <button onclick="location.href='../contact response/index.php'">
                <div class="menu-item">
                    <a class="menu-text" href="../contact response/index.php">お問合せ</a>
                </div>
            </button>
            <button onclick="location.href='../Q&A edit/index.php'">
                <div class="menu-item">
                    <a class="menu-text" href="../Q&A edit/index.php">FQA編集</a>
                </div>
            </button>
        </div>
    </main>
</body>
</html>