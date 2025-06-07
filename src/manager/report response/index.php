<?php
require(dirname(__FILE__) . '/../../dbconnect.php');

session_start();

if (!isset($_SESSION['agent'])) {
    header('Location: ../index.php');
} else {

    $stmt = $dbh->prepare('SELECT
                        alert.id AS alert_id , alert.place, alert.reason, alert.day AS alert_day , agents.name AS agents_name,
                        applicants.name, applicants.furigana,  applicants.birthday, applicants.gender, applicants.mail_address , applicants.address,
                        applicants.tele_number, applicants.huma_science, applicants.academic, applicants.graduation_YEAR, applicants.graduation_MONTH
                        FROM alert
                        INNER JOIN agents ON alert.agent_id = agents.id
                        INNER JOIN applicants ON alert.applicant_id = applicants.id;');
    $stmt->execute();
    $alerts = $stmt->fetchAll();

    $sorted_alerts = rsort($alerts);

    $total_num = count($alerts);
}

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

$place = array(
    1 => '氏名',
    2 => '生年月日',
    3 => 'メールアドレス',
    4 => '住所',
    5 => '電話番号',
    6 => '最終学歴・文理区分',
    7 => '卒業見込年',
    8 => 'その他'
);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>通報対応 CRAFT管理者画面 就活エージェント比較サイト</title>
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
        <h1 class="report_title">
            通報対応
        </h1>
        <section>
            <table class="report">
                <tr class="report-top">
                    <th class="center">No.</th>
                    <th>日付</th>
                    <th>エージェント名</th>
                    <th>通報対象者</th>
                    <th>通報対象者emailアドレス</th>
                    <th>通報箇所</th>
                    <th></th>
                </tr>
                <?php $alert_number = 0;
                foreach($alerts as $alert) :?>
                <tr class="reports-contents">
                    <td class="center"><?=$alert['alert_id']?></td>
                    <td><?=$alert['alert_day']?></td>
                    <td><?=$alert['agents_name']?></td>
                    <td><?=$alert['name']?></td>
                    <td><?=$alert['mail_address']?></td>
                    <td><?=$place[$alert['place']]?></td>
                    <td class="center"><button class="reports-confirmation" id="reports-confirmation<?=$alert_number?>">確認</button></td>
                </tr>
                    <?php $alert_number++;
                endforeach;?>
                <!-- <tr class="reports-contents">
                    <td class="center">1</td>
                    <td>2024-3-30</td>
                    <td>High Class Agent</td>
                    <td>井伊　蔵之介</td>
                    <td>iikura23@gakum.com</td>
                    <td>住所</td>
                    <td class="center"><button class="reports-confirmation">確認</button></td>
                </tr> -->
            </table>
        </section>

        <section>
        <?php $alert_number = 0;
                if($total_num != 0) {
                foreach ($alerts as $alert) : ?>
            <div>
                <div class="report_overlay closed" id="details-overlay<?= $alert_number ?>"></div>
                <div class="report_pop_up closed" id="details<?= $alert_number ?>">
                    <div class="report_top">
                        <p class="report_title"><?=$alert['name']?>様の情報</p>
                        <button class="report_closeButton" id="details-closeButton<?= $alert_number ?>">
                            <img src="../../assets/img/batten.png" alt="">
                        </button>
                    </div>
                    <div class="report_contents-block">
                        <p class="report_contents-top">氏名</p>
                        <p class="report_contents"><?=$alert['name']?></p>
                        <p class="report_contents-top">フリガナ</p>
                        <p class="report_contents"><?=$alert['furigana']?></p>
                        <p class="report_contents-top">生年月日</p>
                        <p class="report_contents"><?=$alert['birthday']?></p>
                        <p class="report_contents-top">性別</p>
                        <p class="report_contents"><?=$genders[$alert['gender']]?></p>
                        <p class="report_contents-top">メールアドレス</p>
                        <p class="report_contents"><?=$alert['mail_address']?></p>
                        <p class="report_contents-top">住所</p>
                        <p class="report_contents"><?=$alert['address']?></p>
                        <p class="report_contents-top">電話番号</p>
                        <p class="report_contents"><?=$alert['tele_number']?></p>
                        <p class="report_contents-top">文理区分</p>
                        <p class="report_contents"><?=$sciences[$alert['huma_science']]?></p>
                        <p class="report_contents-top">最終学歴</p>
                        <p class="report_contents"><?=$alert['academic']?></p>
                        <p class="report_contents-top">卒業見込年</p>
                        <p class="report_contents"><?=$alert['graduation_YEAR']?>年<?=$alert['graduation_MONTH']?>月</p>
                        <p class="report_contents-top">通報したエージェント</p>
                        <p class="report_contents"><?=$alert['agents_name']?></p>
                        <p class="report_contents-top">通報箇所</p>
                        <p class="report_contents"><?=$place[$alert['place']]?></p>
                        <p class="report_contents-top">通報理由</p>
                        <p class="report_contents"><?=$alert['reason']?></p>
                    </div>
                    <div class="report_pop_button">
                            <button class="report_restButton" onclick="location.href='./rest.php?id=<?=$alert['alert_id']?>'">残留する</button>
                            <button class="report_deleteButton" onclick="location.href='./delete.php?id=<?=$alert['alert_id']?>'">削除する</button>
                    </div>
                </div>
            </div>
            <?php $alert_number++;
            endforeach; } ?>

        </section>
    </main>
    <script>
        <?php $script_number = 0;
            if($total_num != 0) {
            forEach( $alerts as $alert) :?>
            const details<?= $script_number ?> = document.querySelector("#details<?= $script_number ?>");
            console.log(details<?= $script_number ?>);
            const detailsOverlay<?= $script_number ?> = document.querySelector("#details-overlay<?= $script_number ?>");
            console.log(detailsOverlay<?= $script_number ?>)
            const detailsCloseButton<?= $script_number ?> = document.querySelector("#details-closeButton<?= $script_number ?>");
            const detailsOpenButton<?= $script_number ?> = document.querySelector("#reports-confirmation<?= $script_number ?>");
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

    </script>
</body>
</html>