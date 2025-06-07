<?php
require(dirname(__FILE__) . '/../dbconnect.php');

session_start();

if (!isset($_SESSION['agent_id'])) {
    header('Location: ./login/index.php');
} else {
    $agent_id = $_SESSION['agent_id'];

    $stmt = $dbh->prepare('SELECT * FROM agents WHERE id = :agent_id');
    $stmt->bindValue(':agent_id', $agent_id , PDO::PARAM_INT);
    $stmt->execute();
    $agent = $stmt->fetch();

    $stmt = $dbh->prepare('SELECT * FROM submit WHERE agent_id = :agent_id');
    $stmt->bindValue(':agent_id', $agent['id']);
    $stmt->execute();
    $submits = $stmt->fetchAll();

    if($submits){
    $category = isset($_GET['category']) ? $_GET['category'] : '';

    if(!isset($_GET['page_id'])){
        $now = 1;
    }else{
        $now = $_GET['page_id'];
    }

    // $stmt = $dbh->prepare('SELECT COUNT(*) FROM applicants WHERE id = :applicant_id' );
    // $stmt->bindParam(':applicant_id', $category, PDO::PARAM_STR);
    // $stmt->execute();
    // $total = $stmt->fetchColumn();

    for ($i = 0; $i <count($submits) ; $i++) {
        $stmt = $dbh->prepare('SELECT id , send_status FROM applicants WHERE id = :applicant_id');
        $stmt->bindValue(':applicant_id', $submits[$i]['applicant_id'], PDO::PARAM_INT);
        $stmt->execute();
        $applicantsCount[] = $stmt->fetchAll();
        }
        $applicant_count = count($applicantsCount);
        $pageSize = 10;
        $max_page = ceil($applicant_count / $pageSize);
    $pageNum = isset($_GET['page_id']) ? $_GET['page_id'] : 1;
    $offset = ($pageNum - 1) * $pageSize;

    $applicants = array();
    $countSubmits = ceil(($offset + 1) / 10) * 10;
    if($countSubmits > $applicant_count){
        $countSubmits = $applicant_count;
    }

    $sorted_submit = rsort($submits);

    for ($i = $offset; $i < $countSubmits; $i++) {
    $stmt = $dbh->prepare('SELECT * FROM applicants WHERE id = :applicant_id ORDER BY id DESC LIMIT :offset, :pageSize');
    $stmt->bindValue(':applicant_id', $submits[$i]['applicant_id'], PDO::PARAM_INT);
    $stmt->bindValue(':offset', 0, PDO::PARAM_INT);
    $stmt->bindValue(':pageSize', $pageSize, PDO::PARAM_INT);
    $stmt->execute();
    $applicants[] = $stmt->fetchAll();
    }
    
    $stmt= $dbh->prepare('SELECT * FROM alert WHERE agent_id = :agent_id');
    $stmt->bindValue(':agent_id', $agent['id'], PDO::PARAM_INT);
    $stmt->execute();
    $alerts = $stmt->fetchAll();
    $alertsNumber = array_column($alerts, 'applicant_id');


    $stmt = $dbh->prepare('SELECT * FROM money');
    $stmt->execute();
    $money = $stmt->fetchAll();
    $total_num = count($applicants);

    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //     for ($i = 0; $i < $total_num; $i++) {
    //         if (isset($_POST['checkbox' . $i])) {
    //             $checkbox = $_POST['checkbox' . $i];
    //             $checkboxID = $_POST['checkboxID' . $i];
    //             $stmt = $dbh->prepare('UPDATE applicants SET send_status = :send_status WHERE id = :applicant_id');
    //             $stmt->bindValue(':send_status', $checkbox, PDO::PARAM_INT);
    //             $stmt->bindValue(':applicant_id', $checkboxID, PDO::PARAM_INT);
    //             $stmt->execute();
    //         }
    // }

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

    if($_GET) {
        $now_page = $_GET['page_id'];
    } else {
        $now_page = 1;
    }

    } else {
        $applicant_count = 0;
        $total = 0;
        $total_num = 0;
        $offset = 0;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>応募者一覧 CRAFT for Agent 就活エージェント比較サイト</title>
    <link rel="stylesheet" href="../assets/css/agent.css">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
    <!-- <header class="header" id="js-header">
        <a href="./" class="header-logo">
            <img src="../assets/img/craft logo3 1.png" alt="POSSE③">
            <p>for Agent</p>
        </a>
        <nav class="header-nav">
            <ul class="header-navList">
                <li class="header-navItem">
                    <form action="./login/signout.php" method="POST">
                        <input type="submit" name= "destroy" class="header-navLink" value="Logout">
                        </input>
                    </form>
                </li>
            </ul>
        </nav>
    </header> -->
    <?php include(dirname(__FILE__) . '../../components/agent/header.php'); ?>
    <main>
        <div class="header-go"></div>
        <div class="agent-topbar">
            <h1 class="agent-name"><?=$agent['name']?> 様</h1>
            <button class="profile-button" id="edit-button" onclick="location.href='./edit/index.php'">プロフィール編集</button>
        </div>
        <div class="agent-status">
            <div class="agent-status-top">
                <p>申込者一覧</p>
            </div>
            <div>
                <p class="agent-status-contentTop">申込数</p>
                <div class="agent-status-content">
                    <p class="agent-status-contentNumber"><?=$applicant_count?></p>
                    <p class="agent-status-contentAdjustment">件</p>
                </div>
            </div>
            <div>
                <p class="agent-status-contentTop">未送信件数</p>
                <div class="agent-status-content">
                    <?php
                    if($total_num != 0) {
                    $count = count(array_filter($applicantsCount, function($applicant) {
                        return $applicant[0]['send_status'] == 0;
                    }));} else {
                        $count = 0;
                    };?>
                    <p class="agent-status-contentNumber"><?=$count?></p>
                    <p class="agent-status-contentAdjustment">件</p>
                </div>
            </div>
            <div>
                <p class="agent-status-contentTop">請求金額</p>
                <div class="agent-status-content">
                    <?php
                    $agent_status_contentNumber = 0;
                    if ($total_num != 0) {
                        $agent_status_contentNumber = $applicant_count * $money[0]['money'];
                    }
                    ?>
                    <p class="agent-status-contentNumber"><?= $agent_status_contentNumber ?></p>
                    <p class="agent-status-contentAdjustment">円</p>
                </div>
            </div>
            <div class="agent-status-rest">
                <p>通報申請数: <span><?php if ($total_num != 0) { echo count($alerts);} else { echo 0;}?></span>件</p>
                <p>削除件数: <span><?=$agent['alert_number']?></span>件</p>
                <p>掲載期間: <span class="agent-status-rest-period"><?=$agent['start_period']?> ～ <?=$agent['end_period']?></span></p>
            </div>
        </div>
        <p class="agents-paging-information"><?=$applicant_count?>件中 <?=$offset?>件～<?=$offset + $total_num?>件表示</p>
        <div>
            <table class="agents">
                <tr class="agents-top">
                    <th class="center">No.</th>
                    <th>日付</th>
                    <th>申込者</th>
                    <th>emailアドレス</th>
                    <th class="center">メール送信状態</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php $applicant_number = 0;
                if($total_num != 0) {
                foreach ($applicants as $applicant) : ?>
                        <tr class="agents-contents">
                            <td class="center"><?= $applicant[0]['id'] ?></td>
                            <td><?= $applicant[0]['day'] ?></td>
                            <td><?= $applicant[0]['name'] ?></td>
                            <td><?= $applicant[0]['mail_address'] ?></td>
                            <?php if ($applicant[0]['send_status'] == 0) { ?>
                                <td class="center"><button type="button" name="checkbox<?=$applicant_number?>" value="0" onclick="location.href='./sendmail.php?id=<?= $applicant[0]['id'] ?>&status=<?=$applicant[0]['send_status']?>&nowPage=<?=$now_page?>'" class="agents-check"></button></td>
                                <?php  } else { ?>
                                <td class="center"><button type="button" name="checkbox<?=$applicant_number?>" value="1" onclick="location.href='./sendmail.php?id=<?= $applicant[0]['id'] ?>&status=<?=$applicant[0]['send_status']?>&nowPage=<?=$now_page?>'" class="agents-check agents-check-true"></td>
                            <?php } ?>
                            <td class="center"><button class="agents-detail" id="agents-detail<?=$applicant_number?>">詳細</button></td>
                            <td class="center">
                                <?php if (in_array($applicant[0]['id'], $alertsNumber)) {?>
                                    <p class="agents-alert-end">通報済</p>
                                <?php } else {?>
                                    <a href="./alert/index.php?id=<?=$applicant[0]['id']?>" class="agents-alert">通報</a>
                            <?php } ?>
                            </td>
                        </tr>
                <?php $applicant_number++;
            endforeach;} else { ?>
                <td class="center"></td>
                <td></td>
                <td></td>
                <td>申込者はいません</td>
            <? } ?>
            </table>
        </div>
        <?php if($total_num != 0) { ?>
        <div class="paging">
            <!-- <figure class="paging-back"><img src="../assets/img/Group 45.png" alt=""><img src="../assets/img/Group 45.png" alt=""></figure> -->
            <?php if($now > 1){ ?>
            <a href="index.php?page_id=<?=$now -1?>">
                <figure class="paging-back"><img src="../assets/img/Group 45.png" alt=""></figure>
            </a>
            <?php } else { ?>
            <?php } ?>
            <?php for($i = 1; $i <= $max_page; $i++){
    if ($i == $now) { ?>
        <p class="paging-contents paging-now"><?= $i ?></p>
    <?php } else { ?>
        <a href="index.php?page_id=<?=$i?>">
            <p class="paging-contents"><?= $i ?></p>
        </a>
    <?php }
}
if($now < $max_page){ ?>
        <a href="index.php?page_id=<?=$now +1?>">
            <figure class="paging-forward"><img src="../assets/img/Group 45.png" alt=""></figure>
        </a>
            <?php }else { ?>
                <?php } ?>
            <!-- <figure class="paging-forward"><img src="../assets/img/Group 45.png" alt=""><img src="../assets/img/Group 45.png" alt=""></figure> -->
        </div>
        <?php }
        $detail_number = 0;
        if ($total_num != 0) {
        forEach ($applicants as $applicant) :?>
            <div>
                <div class="details-overlay closed" id="details-overlay<?= $detail_number ?>"></div>
                <div class="details closed" id="details<?= $detail_number ?>">
                    <div class="details-top">
                        <p class="details-title"><?= $applicant[0]['name'] ?>様の詳細情報</p>
                        <button class="details-closeButton" id="details-closeButton<?= $detail_number ?>">
                            <img src="../assets/img/batten.png" alt="">
                        </button>
                    </div>
                    <div class="details-contents-block">
                        <p class="details-contents-top">氏名</p>
                        <p class="details-contents"><?= $applicant[0]['name'] ?></p>
                        <p class="details-contents-top">フリガナ</p>
                        <p class="details-contents"><?= $applicant[0]['furigana'] ?></p>
                        <p class="details-contents-top">生年月日</p>
                        <p class="details-contents"><?= $applicant[0]['birthday'] ?></p>
                        <p class="details-contents-top">性別</p>
                        <p class="details-contents"><?= $genders[$applicant[0]['gender']] ?></p>
                
                        <p class="details-contents-top">メールアドレス</p>
                        <p class="details-contents"><?= $applicant[0]['mail_address'] ?></p>
                        <p class="details-contents-top">住所</p>
                        <p class="details-contents"><?= $applicant[0]['address'] ?></p>
                        <p class="details-contents-top">電話番号</p>
                        <p class="details-contents"><?= $applicant[0]['tele_number'] ?></p>
                        <p class="details-contents-top">文理区分</p>
                        <p class="details-contents"><?= $sciences[$applicant[0]['huma_science']]?></p>
                        <p class="details-contents-top">最終学歴</p>
                        <p class="details-contents"><?= $applicant[0]['academic'] ?></p>
                        <p class="details-contents-top">卒業見込年</p>
                        <p class="details-contents"><?= $applicant[0]['graduation_YEAR'] ?>年<?= $applicant[0]['graduation_MONTH'] ?>月</p>
                    </div>
                    <?php if(!in_array($applicant[0]['id'], $alertsNumber)) {?>
                    <button class="details-alertButton" onclick="location.href='./alert/index.php?id=<?=$applicant[0]['id']?>'">通報する</button>
                    <?php } else ?>
            </div>
            <?php $detail_number++;
        endforeach;} ?>
        <div class="details-overlay closed" id="details-overlay"></div>
        <div class="details closed" id="details">
            <div class="details-top">
                <p class="details-title">佐藤茂樹様の詳細情報</p>
                <button class="details-closeButton" id="details-closeButton">
                    <img src="../assets/img/batten.png" alt="">
                </button>
            </div>
            <div class="details-contents-block">
                <p class="details-contents-top">氏名</p>
                <p class="details-contents">佐藤　茂樹</p>

                <p class="details-contents-top">フリガナ</p>
                <p class="details-contents">サトウ　シゲキ</p>

                <p class="details-contents-top">生年月日</p>
                <p class="details-contents">2003年5月21日</p>

                <p class="details-contents-top">性別</p>
                <p class="details-contents">男性</p>

                <p class="details-contents-top">メールアドレス</p>
                <p class="details-contents">satoshige@gakum.com</p>

                <p class="details-contents-top">住所</p>
                <p class="details-contents">茨城県取手市けやき台53丁目</p>

                <p class="details-contents-top">電話番号</p>
                <p class="details-contents">09025254022</p>

                <p class="details-contents-top">文理区分</p>
                <p class="details-contents">文系</p>

                <p class="details-contents-top">最終学歴</p>
                <p class="details-contents">成城大学　法学部　法学科</p>

                <p class="details-contents-top">卒業見込年</p>
                <p class="details-contents">2027年3月</p>
            </div>
                <button class="details-alertButton" onclick="location.href='./alert/index.php'">通報する</button>
            </div>
            <!-- <div class="edit-overlay closed" id="edit-overlay"></div>
            <div class="edit closed" id="edit">
                <div class="edit-top">
                    <p class="edit-title">エージェント情報を編集する</p>
                    <button class="edit-closeButton" id="edit-closeButton">
                    <img src="../assets/img/batten.png" alt="">
                    </button>
                </div>
                <div class="edit-content">
                    <p class="edit-item">企業ロゴ</p>
                        <input type="file"  class="edit-image" name="image" id="image"  placeholder="ああ" />
                    <p class="edit-item">企業名</p>
                        <input type="text" class="edit-write">
                    <p class="edit-item">業種</p>
                    <select name="" id="area" class="edit-select">
                        <option disabled selected>選択してください</option>
                        <option>総合型</option>
                        <option>理系就職</option>
                        <option>IT系</option>
                        <option>美術系</option>
                    </select>
                    <p class="edit-item">エリア</p>
                    <select name="" id="area" class="edit-select">
                        <option disabled selected>選択してください</option>
                        <option>すべて</option>
                        <option>北海道</option>
                        <option>北陸</option>
                        <option>関東</option>
                        <option>東海</option>
                        <option>甲信越</option>
                        <option>北陸</option>
                        <option>近畿</option>
                        <option>中国</option>
                        <option>四国</option>
                        <option>九州・沖縄</option>
                    </select>
                    <p class="edit-item">形態</p>
                    <section class="edit-form">
                        <label class="edit-form-label"><input class="edit-form-input" type="checkbox" name="" value="">大手</label>
                        <label class="edit-form-label"><input class="edit-form-input" type="checkbox" name="" value="">中小</label>
                        <label class="edit-form-label"><input class="edit-form-input" type="checkbox" name="" value="">ベンチャー</label>
                        <label class="edit-form-label"><input class="edit-form-input" type="checkbox" name="" value="">外資</label>
                    </section>
                </div>
                <button class="edit-complete-button">編集完了</button>
            </div> -->
    </main>
    <!-- <script src="../assets/js/agent.js"></script> -->
    <script>
        "use strict";
            // 詳細表示画面、ポップアップの実装

            <?php $script_number = 0;
            if($total_num != 0) {
            forEach( $applicants as $applicant) :?>
            const details<?= $script_number ?> = document.querySelector("#details<?= $script_number ?>");
            console.log(details<?= $script_number ?>);
            const detailsOverlay<?= $script_number ?> = document.querySelector("#details-overlay<?= $script_number ?>");
            console.log(detailsOverlay<?= $script_number ?>)
            const detailsCloseButton<?= $script_number ?> = document.querySelector("#details-closeButton<?= $script_number ?>");
            const detailsOpenButton<?= $script_number ?> = document.querySelector("#agents-detail<?= $script_number ?>");
            console.log(detailsOpenButton<?= $script_number ?>);

            //閉じるボタン
            detailsCloseButton<?= $script_number ?>.addEventListener("click", function () {
            details<?= $script_number ?>.classList.toggle("closed");
            detailsOverlay<?= $script_number ?>.classList.toggle("closed");
            });

            //開くボタン
            detailsOpenButton<?= $script_number ?>.addEventListener("click", function() {
                console.log("はい<?= $script_number?>");
            details<?= $script_number ?>.classList.toggle("closed");
            detailsOverlay<?= $script_number ?>.classList.toggle("closed");
            });
            <?php $script_number++ ;
            endforeach; } ?>
//             const details = document.querySelector("#details");
//             const detailsOverlay = document.querySelector("#details-overlay");
//             const detailsCloseButton = document.querySelector("#details-closeButton");
//             const detailsOpenButton = document.querySelectorAll(".agents-detail");
//             // const likeCloseButton2 = document.querySelector("#likeList-closeButton2");

// //閉じるボタン
//             detailsCloseButton.addEventListener("click", function () {
//             details.classList.toggle("closed");
//             detailsOverlay.classList.toggle("closed");
//             });

//             //開くボタン
//             detailsOpenButton.forEach(function(button) {
//             button.addEventListener("click", function() {
//             details.classList.toggle("closed");
//             detailsOverlay.classList.toggle("closed");
//             });
            // });

//エージェント編集のポップアップ
const editButton = document.querySelector("#edit-button");
const editForm = document.querySelector("#edit");
const editFormOverlay = document.querySelector("#edit-overlay");
const editFormCloseButton = document.querySelector("#edit-closeButton");

//閉じるボタン
// editFormCloseButton.addEventListener("click", function () {
//   editForm.classList.toggle("closed");
//   editFormOverlay.classList.toggle("closed");
// });

// //開くボタン
// editButton.addEventListener("click", function () {
//   editForm.classList.toggle("closed");
//   editFormOverlay.classList.toggle("closed");
// });

function submitForm() {
  // チェックボックスの値を取得
const checkboxValue = document.querySelector('input[name="checkbox"]').value;

// Create a FormData object and append the checkbox value
const formData = new FormData();
formData.append('checkbox_value', checkboxValue);

// Ajax通信で INSERT 処理を実行
const xhr = new XMLHttpRequest();
xhr.open('POST', 'sendmail.php');
xhr.send(formData);

  // 通信成功時の処理
  xhr.onload = function() {
    if (xhr.status === 200) {
      // 処理成功
      console.log('INSERT成功');
    } else {
      // 処理失敗
      console.log('INSERT失敗');
    }
  };
}
    </script>
</body>
</html>