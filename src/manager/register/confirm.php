<?php

session_start();

if (!isset($_SESSION['agent'])) {
    header('Location: ../index.php');
} else {
    $name = $_SESSION['name'];
    $style = $_SESSION['style'];
    $prefecture = $_SESSION['prefecture'];
    $select = $_SESSION['select'];
    // $select1 = $_POST['select1'];
    // $select2 = $_POST['select2'];
    // $select3 = $_POST['select3'];
    // $select4 = $_POST['select4'];
    $text = $_SESSION['text'];
    $image = $_SESSION['image'];
    $email = $_SESSION['email'];
    $confirmationEmail = $_SESSION['confirmation_email'];
    $password = $_SESSION['password'];
    $confirmationPassword = $_SESSION['confirmation_password'];
    $_SESSION['application'] = 3;

    $styles = array(
        1 => 'すべて',
        2 => '総合型',
        3 => '理系職業',
        4 => 'IT',
        5 => '芸術系',
    );

    $prefectures = array(
        1 => '全国',
        2 => '北海道・東北',
        3 => '関東',
        4 => '中部',
        5 => '近畿',
        6 => '中国・四国',
        7 => '九州・沖縄',
    );

    // $selects = array(
    //     1 => '大手',
    //     2 => '中小',
    //     3 => 'ベンチャー',
    //     4 => '外資系',
    // );
    // var_dump($selects);
// }else {
//         $name = '';
//         $style = '';
//         $prefecture = '';
//         $select = '';
//         $text = '';
//         $email = '';
//         $confirmationEmail = '';
//         $password = '';
//         $confirmationPassword = '';
//     }
}
?>
<!DOCTYPE html>
<html lang="en"></html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>エージェント新規登録・確認 CRAFT管理者画面 就活エージェント比較サイト</title>
    <link rel="stylesheet" href="../../assets/css/manager.css">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
<?php include(dirname(__FILE__) . '../../../components/manager/header.php'); ?>
    <div class="header-go"></div>
    <form class="form">
        <h1 class="form-title">エージェント登録</h1>
        <div class="confirm-box">
            <label class="confirm-label">エージェント名</label>
            <p class="confirm-text"><?=$name?></p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">業種</label>
            <p class="confirm-text"><?=$styles[$style]?></p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">エリア</label>
            <p class="confirm-text"><?=$prefectures[$prefecture]?></p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">形態</label>
            <p class="confirm-text">
                <?php
//                 // $_POST['select'] が存在し、配列であることを確認します。
// if (isset($_POST['select']) && is_array($_POST['select'])) {
//     $selects = $_POST['select'];
// } else {
//     // $_POST['select'] が存在しないか、配列ではない場合、空の配列を用意します。
//     $selects = array();
// }

// // $selects が空の配列でないことを確認してからループを実行します。
// if (!empty($selects)) {
//     foreach ($selects as $select) {
//         echo $select . PHP_EOL;
//     }
// } else {
//     // $selects が空の場合、何も出力しないか、エラーメッセージを表示します。
//     echo "選択肢がありません。";
// }

                    // 事前に定義された選択肢とその説明
                    $selects = array(
                        1 => '大手',
                        2 => '中小',
                        3 => 'ベンチャー',
                        4 => '外資系',
                    );

                    // $_SESSION['select'] が存在し、配列であることを確認します。
                    if (isset($_SESSION['select']) && is_array($_SESSION['select'])) {
                        // 選択された各値に対してループを実行します。
                        foreach ($_SESSION['select'] as $selectedValue) {
                            // 数値をキーとして文字列を出力します。
                            if (array_key_exists($selectedValue, $selects)) {
                                echo $selects[$selectedValue] . PHP_EOL;
                            }
                        }
                    } else {
                        // $_SESSION['select'] が存在しないか、配列ではない場合、エラーメッセージを表示します。
                        echo "選択肢がありません。";
                    }
// $array = [];
// foreach ($select as $value) {
//   if ($value !== 0) {
//     $array[] = $value;
//   }
// }

// var_dump($array); // [2, 3]
// if ($select1 === '1') {
//     echo $selects[$select1];}
//     elseif ($select1 === '2') {
//     echo $selects[$select2];}
//     elseif ($select1 === '3') {
//     echo $selects[$select3];}
//     elseif ($select1 === '4') {
//     echo $selects[$select4];}
//
                    ?>
        </p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">特徴</label>
            <p class="confirm-text"><?=$text?></p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">画像</label>
            <p class="confirm-text"><?=$image['name']?></p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">ログインID(emailアドレス)</label>
            <p class="confirm-text"><?=$email?></p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">確認用ログインID(emailアドレス)</label>
            <p class="confirm-text"><?=$confirmationEmail?></p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">パスワード</label>
            <p class="confirm-text"><?=$password?></p>
        </div>
        <div class="confirm-box">
            <label class="confirm-label">確認用パスワード</label>
            <p class="confirm-text"><?=$confirmationPassword?></p>
        </div>
        <div class="submit">
            <button type="button" class="confirm-button" onclick="location.href='./form.php'">入力内容を変更する</button>
            <button type="button" class="confirm-button" onclick="location.href='./complete.php'">送信する</button>
        </div>
    </form>
</body>
</html>