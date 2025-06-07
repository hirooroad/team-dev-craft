<?php
require(dirname(__FILE__) . '/../../dbconnect.php');

session_start();

if (!isset($_SESSION['agent'])) {
    header('Location: ../index.php');
} else {
        
            $stmt = $dbh->prepare('SELECT *  from agents');
            $stmt->execute();
            $agents = $stmt->fetchAll();

            for ($i = 0; $i <count($agents) ; $i++) {
                $stmt = $dbh->prepare('SELECT * FROM submit WHERE agent_id = :agent_id');
                $stmt->bindValue(':agent_id', $agents[$i]['id']);
                $stmt->execute();
                $submits[] = $stmt->fetchAll();
                }
                $submitsCount = [];

                for ($i = 0; $i < count($submits); $i++) {
                    $submitsCount[$i] = count($submits[$i]);
                }

                $stmt = $dbh->prepare('SELECT * FROM money');
                $stmt->execute();
                $money = $stmt->fetchAll();

            $alerts = [];

            for ($i = 0; $i <count($agents) ; $i++) {
            $stmt = $dbh->prepare('SELECT DISTINCT
            alert.id AS alert_id , alert.applicant_id, alert.agent_id
            FROM alert
            INNER JOIN agents ON alert.agent_id = agents.id
            WHERE  alert.agent_id= :agent_id');
            $stmt->bindValue(':agent_id', $agents[$i]['id']);
            $stmt->execute();
            $alerts[] = $stmt->fetchAll();
            }

            for ($i = 0; $i < count($alerts); $i++) {
                $alertsCount[$i] = count($alerts[$i]);
}}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>エージェント管理 CRAFT管理者画面 就活エージェント比較サイト</title>
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
            <div class="agent-top-bar">
                <h1 class="agent-name">エージェント管理</h1>
                <div>
                    <p class="agent-status-contentTop">エージェント数</p>
                    <div class="agent-status-content">
                        <p class="agent-status-contentNumber"><?=count($agents)?></p>
                        <p class="agent-status-contentAdjustment">件</p>
                    </div>
                </div>
                <div>
                    <p class="agent-status-contentTop2">請求金額合計</p>
                    <div class="agent-status-content">
                        <p class="agent-status-contentNumber">
                            <?php
                            $total = 0;
                            for ($i = 0; $i < count($submitsCount); $i++) {
                                $total += $submitsCount[$i] * $money[0]['money'];
                            }
                            echo $total;
                            ?>
                        </p>
                        <p class="agent-status-contentAdjustment">円</p>
                    </div>
                </div>
                <button class="profile-button"  onclick="location.href='../register/form.php'">新規登録</button>
            </div>
        </div>
        
        <div>
            <table class="agents">
                <tr class="agents-top">
                    <th class="center">No.</th>
                    <th>エージェント会社</th>
                    <th>請求金額</th>
                    <th class="center">請求確認</th>
                    <th>通報件数</th>
                    <th>掲載終了</th>
                    <th></th>
                    <th></th>
                </tr>

                <?php for ($i = 0; $i < count($agents); $i++) : ?>
                <tr class="agents-contents">
                    <td class="center"><?= $agents[$i]['id'] ?></td>
                    <td class="left"><?= $agents[$i]['name'] ?></td>
                    <td class="left"><?= $submitsCount[$i] * $money[0]['money']?>円</td>
                    <?php if ($agents[$i]['claim_confirm'] == 0) { ?>
                                <td class="center"><button type="button" name="checkbox" value="0" onclick="location.href='./confirm.php?id=<?=$agents[$i]['id']?>&status=<?=$agents[$i]['claim_confirm']?>'" class="agents-check"></button></td>
                                <?php  } else { ?>
                                <td class="center"><button type="button" name="checkbox" value="1" onclick="location.href='./confirm.php?id=<?=$agents[$i]['id']?>&status=<?=$agents[$i]['claim_confirm']?>'" class="agents-check agents-check-true"></td>
                            <?php } ?>
                    <td class="center"><?=$alertsCount[$i]?></td>
                    <td class="left"><?= $agents[$i]['end_period'] ?></td>
                    <?php if ($agents[$i]['display'] == 0) { ?>
                        <td class="center"><button class="agents-publish" onclick="location.href='./display.php?id=<?=$agents[$i]['id']?>&status=<?=$agents[$i]['display']?>'">掲載</button></td>
                                <?php  } else { ?>
                        <td class="center"><button class="agents-publish2" onclick="location.href='./display.php?id=<?=$agents[$i]['id']?>&status=<?=$agents[$i]['display']?>'">非掲載</button></td>
                            <?php } ?>
                    <td class="center"><a class="agents-delete agents-detail" id="agents-detail<?=$i?>">削除</a></td>
                </tr>
                <?php endfor; ?>
            </table>
        </div>
        <?php for ($i = 0; $i < count($agents); $i++) : ?>
        <div class="details-overlay closed" id="details-overlay<?=$i?>"></div>
        <div class="details closed" id="details<?=$i?>">
            <div class="details-top">
                <p class="details-title">No.<?=$agents[$i]['id']?> <?=$agents[$i]['name']?></p>
            </div>
            <div>
                <p class="details-contents">この項目を本当に削除しますか</p>
            </div>
                <button class="details-deleteButton" onclick="location.href='delete.php?id=<?=$agents[$i]['id']?>'">削除</button>
                <button class="details-cancelButton" id="details-closeButton<?=$i?>">キャンセル</button>
        </div>
        <?php endfor; ?>
        <!-- <div class="details-overlay closed" id="details-overlay"></div>
        <div class="details closed" id="details">
            <div class="details-top">
                <p class="details-title">No.14 マイナビエージェント</p>
            </div>
            <div>
                <p class="details-contents">この項目を本当に削除しますか</p>
            </div>
                <button class="details-cancelButton" id="details-closeButton">キャンセル</button>
        </div> -->
    </main>
    <!-- <script src="../../assets/js/manager.js"></script> -->
<script>
    "use strict";
// 詳細表示画面、ポップアップの実装


<?php for ($i = 0; $i < count($agents); $i++) { ?>
    const details<?=$i?> = document.querySelector('#details<?=$i?>');
    const detailsOverlay<?=$i?> = document.querySelector('#details-overlay<?=$i?>');
    const detailsCloseButton<?=$i?> = document.querySelector('#details-closeButton<?=$i?>');
    const detailsOpenButton<?=$i?> = document.querySelector('#agents-detail<?=$i?>');
    detailsCloseButton<?=$i?>.addEventListener('click', function () {
        details<?=$i?>.classList.toggle('closed');
        detailsOverlay<?=$i?>.classList.toggle('closed');
    });
    detailsOpenButton<?=$i?>.addEventListener('click', function() {
        details<?=$i?>.classList.toggle('closed');
        detailsOverlay<?=$i?>.classList.toggle('closed');
    });
<?php } ?>

const details = document.querySelector("#details");
const detailsOverlay = document.querySelector("#details-overlay");
const detailsCloseButton = document.querySelector("#details-closeButton");
const detailsOpenButton = document.querySelectorAll(".agents-detail");
// const likeCloseButton2 = document.querySelector("#likeList-closeButton2");

//閉じるボタン
detailsCloseButton.addEventListener("click", function () {
  details.classList.toggle("closed");
  detailsOverlay.classList.toggle("closed");
});

// likeCloseButton2.addEventListener("click", function () {
//     likeList.classList.toggle("closed");
//     likeListOverlay.classList.toggle("closed");
//   });

//開くボタン
detailsOpenButton.forEach(function(button) {
    button.addEventListener("click", function() {
        details.classList.toggle("closed");
        detailsOverlay.classList.toggle("closed");
    });
});
</script>
</body>
</html>
