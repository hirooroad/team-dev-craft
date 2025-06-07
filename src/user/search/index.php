<?php
require(dirname(__FILE__) . './../../dbconnect.php');

session_start();

// 最初に入ったとき
// if (!isset($_SESSION['first_visit'])) {
//   // $_POST を空にする
//   unset($_POST);

//   // セッション変数を設定する
//   $_SESSION['first_visit'] = true;
// }

// if ($_POST["industry"] == "" || $_POST["area"] == "" || $_POST["form"] == "") { //IDおよびユーザー名の入力有無を確認]
    // $today = date("Y-m-d");
    // $next_year = date("Y-m-d", strtotime("+1 year"));

    $today = new DateTime(date("Y-m-d"));
$next_year = new DateTime(date("Y-m-d", strtotime("+1 year")));
    if (count($_POST) === 0) { //IDおよびユーザー名の入力有無を確認
    $agents = $dbh->query("SELECT
        agents.id,
        agents.name,
        agents.start_period,
        agents.end_period,
        agents.image,
        agents.information,
        agents.industry,
        agents.area,
        GROUP_CONCAT(form.form) AS forms
        FROM
        agents
        INNER JOIN
        form ON agents.id = form.agent_id
        WHERE agents.display = 1 AND DATE(agents.start_period) <= '{$today->format("Y-m-d")}'
        AND DATE(agents.end_period) >= '{$today->format("Y-m-d")}'
        GROUP BY
        agents.id
        ORDER BY
        agents.id ASC")->fetchAll(PDO::FETCH_ASSOC);

} else {
    $industry = $_POST["industry"];
    $area = $_POST["area"];
    $form = $_POST["form"];

    $whereClause = "";
    if($industry != 0 && !empty($form)) {
        $whereClause = "AND agents.industry = '$industry' AND form.form LIKE '%$form%'";
    }
    else if ($industry != 0) {
        $whereClause = "AND agents.industry = '$industry'";
    }
    else if ($form != 0) {
        $whereClause = "AND form.form like '%$form%'";
    }

    $agents = $dbh->query("SELECT
        agents.id,
        agents.name,
        agents.start_period,
        agents.end_period,
        agents.image,
        agents.information,
        agents.industry,
        agents.area,
        GROUP_CONCAT(form.form) AS forms
        FROM
        agents
        INNER JOIN
        form ON agents.id = form.agent_id
        WHERE agents.area = '$area' $whereClause AND agents.display = 1 AND DATE(agents.start_period) <= '{$today->format("Y-m-d")}'
        AND DATE(agents.end_period) >= '{$today->format("Y-m-d")}'
        GROUP BY
        agents.id
        ORDER BY
        agents.id ASC")->fetchAll(PDO::FETCH_ASSOC);
}

$industries = array(
    1 => '総合型',
    2 => '理系就職',
    3 => 'IT',
    4 => '芸術'
);

$areas = array(
    1 => '全国',
    2 => '北海道・東北',
    3 => '関東',
    4 => '中部',
    5 => '近畿',
    6 => '中国・四国',
    7 => '九州・沖縄',
);

// $form_sql = "
// SELECT
// agents.id,
// agents.name,
// agents.start_period,
// agents.end_period,
// agents.image,
// agents.information,
// agents.industry,
// agents.area,
// GROUP_CONCAT(form.form) AS forms
// FROM
// agents
// INNER JOIN
// form ON agents.id = form.agent_id
// GROUP BY
// agents.id
// ORDER BY
// agents.id ASC;
// ";
// $stmt = $dbh->query($form_sql)->fetchAll(PDO::FETCH_ASSOC);
// $form_number = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>エージェント検索　CRAFT 就活エージェント比較サイト</title>
    <link rel="stylesheet" href="../../assets/css/user.css">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/sp/user.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
<?php include(dirname(__FILE__) . '../../../components/user/header.php'); ?>
    <main>
    <div class="header-go"></div>
        <div class="search-container">
            <div class="search-box">
                <h1 class="search-box-title">絞り込み</h1>
                <form action="./index.php" method="POST">
                    <label for="industry">
                        <p class="search-box-top">業種</p>
                    </label>
                    <select name="industry" id="industry" class="search-box-main search-box-main1">
                            <option value="0">すべて</option>
                            <option value="1">総合型</option>
                            <option value="2">理系職業</option>
                            <option value="3">IT</option>
                            <option value="4">芸術</option>
                    </select>
                    <label for="area">
                        <p class="search-box-top">エリア</p>
                    </label>
                        <select name="area" id="area" class="search-box-main">
                            <option value="1">全国</option>
                            <option value="2">北海道・東北</option>
                            <option value="3">関東</option>
                            <option value="4">中部</option>
                            <option value="5">近畿</option>
                            <option value="6">中国・四国</option>
                            <option value="7">九州・沖縄</option>
                    </select>
                        <label for="form">
                            <p class="search-box-top">形態</p>
                        </label>
                            <select name="form" id="form" class="search-box-main">
                                <option value="0">すべて</option>
                                <option value="1">大手</option>
                                <option value="2">中小</option>
                                <option value="3">ベンチャー</option>
                                <option value="4">外資</option>
                            </select>
                        <button class="search-box-button"><img src="../../assets/img/image 10.png" alt="">検索</button>
                </form>
                <? $count = count($agents);;?>
            <p class="search-box-number"><span><?=$count?></span>件がヒットしました</p>
            </div>
            <div></div>
            <div class="agents-box" id="agents-box">
                            <?php
                            foreach ($agents as $agent) :?>
                    <div class="agents">
                        <div class="agents-top">
                            <h1 class="agents-title"><?= $agent['name'] ?></h1>
                            <p class="agents-span">掲載期間:<?= $agent['start_period'] ?> ～ <?= $agent['end_period'] ?></p>
                        </div>
                        <div class="agents-center">
                            <figure class="agents-logo">
                                <img src="../../assets/img/<?= $agent['image']?>" alt="">
                            </figure>
                            <div class="agents-contents">
                                <div class="agents-contents-top">
                                    <p>業種</p>
                                    <p>エリア</p>
                                    <p>形態</p>
                                    <p>特徴</p>
                                </div>
                                <div class="agents-line"></div>
                                <div class="agents-contents-details">
                                    <p><?=
                                            $industries[$agent['industry']];
                                        ?></p>
                                    <p><?= $areas[$agent['area']] ?></p>
                                    <p><?php
                                        // $forms = $stmt[$form_number]['forms'];
                                        // $forms = $agent['forms'];
                                        $form_data =  $dbh->query("SELECT
                                        agents.id,
                                        GROUP_CONCAT(form.form) AS forms
                                        FROM
                                        agents
                                        INNER JOIN
                                        form ON agents.id = form.agent_id
                                        WHERE agents.id = {$agent['id']}
                                        GROUP BY
                                        agents.id
                                        ORDER BY
                                        agents.id ASC")->fetchAll(PDO::FETCH_ASSOC);
                                        $forms = $form_data[0]['forms'];
                                        $forms = str_replace(
                                            array('1', '2', '3', '4' ,','),
                                            array('大手', '中小', 'ベンチャー','外資','、'),
                                            // $stmt[$form_number]['forms']
                                            // $agent['forms']
                                            $form_data[0]['forms']
                                        );
                                        echo $forms;
                                    ?></p>
                                    <p><?= $agent['information'] ?></p>
                                </div>
                            </div>
                        </div>
                        <!-- <form action=""> -->
                            <button class="agents-likeButton" id="agents-likeButton" value="<?=$agent['id']?>" data-aid="<?=$agent['id']?>"
                            data-name="<?= $agent['name'] ?>" data-start="<?= $agent['start_period']?>" data-end="<?= $agent['end_period'] ?>"
                            data-image="<?= $agent['image']?>" data-industry="<?=$industries[$agent['industry']];?>"
                            data-area="<?= $areas[$agent['area']] ?>" data-forms="<?=$forms?>"
                            data-information="<?=$agent['information']?>"><img src="../../assets/img/image 15.png" alt=""><p>申し込みリストに追加</p></button>
                        <!-- </form> -->
                    </div>
                <?php $count++;
            endforeach; ?>
                <!-- <div class="agents">
                    <div class="agents-top">
                        <h1 class="agents-title">リクナビ就活エージェント</h1>
                        <p class="agents-span">掲載期間:2023/1/1 ～ 2024/1/1</p>
                    </div>
                    <div class="agents-center">
                        <figure class="agents-logo">
                            <img src="../../assets/img/A0001.png" alt="">
                        </figure>
                        <div class="agents-contents">
                            <div class="agents-contents-top">
                                <p>業種</p>
                                <p>エリア</p>
                                <p>形態</p>
                                <p>特徴</p>
                            </div>
                            <div class="agents-line"></div>
                            <div class="agents-contents-details">
                                <p>総合型</p>
                                <p>全国</p>
                                <p>大手、中小、ベンチャー</p>
                                <p>専属のアドバイザーが就活をサポート。企業の選考ポイントも把握しており、面接や履歴書についてもサポートされる。</p>
                            </div>
                        </div>
                    </div>
                    <button class="agents-likeButton"><img src="../../assets/img/image 15.png" alt=""><p>お気に入り登録する</p></button> -->
                </div>
            </div>
            <div class="likeList-overlay likeList-closed" id="likeList-overlay"></div>
            <div class="likeList likeList-closed" id="likeList">
                <div class="likeList-top">
                    <div class="likeList-title">
                        <img src="../../assets/img/image 15.png" alt="">
                        <p>申し込みリスト</p>
                    </div>
                    <button class="likeList-closeButton" id="likeList-closeButton">
                        <img src="../../assets/img/batten.png" alt="閉じる">
                    </button>
                </div>
                <div class="likeList-height">
                    <div class="likeList-contents" id="likeList-contents">
                    </div>
                </div>
                <div class="likeList-bottom">
                    <button class="likeList-bottomButton" id="likeList-closeButton2">戻る</button>
                    <div class="likeList-bottomAdjustment"></div>
                    <a href="../application/form.php"><button class="likeList-bottomButton" id="form-button" disabled>申し込み</button></a>
                </div>
                </div>
            </div>
            <button class="likeList-button" id="likeList-button">
                <div class="likeList-button-number likeList-closed" id="likeList-button-number">
                    <div class="likeList-button-number-adjustment"></div>1</div>申し込み<br>リスト</button>
            </div>
    </main>
    <script>

        // エージェント一覧画面、ポップアップの実装

        const likeList = document.querySelector("#likeList");
        const likeListOverlay = document.querySelector("#likeList-overlay");
        const likeCloseButton = document.querySelector("#likeList-closeButton");
        const likeOpenButton = document.querySelector("#likeList-button");
        const likeCloseButton2 = document.querySelector("#likeList-closeButton2");

        //閉じるボタン
        likeCloseButton.addEventListener("click", function () {
        likeList.classList.toggle("likeList-closed");
        likeListOverlay.classList.toggle("likeList-closed");
        });

        likeCloseButton2.addEventListener("click", function () {
        likeList.classList.toggle("likeList-closed");
        likeListOverlay.classList.toggle("likeList-closed");
        });

        //開くボタン
        likeOpenButton.addEventListener("click", function () {
        likeList.classList.toggle("likeList-closed");
        likeListOverlay.classList.toggle("likeList-closed");
        });
        //検索タブの実装
        <?php if (count($_POST) !== 0) {?>
            const selectdArea = document.getElementById('area');

            selectdArea.value =<?=$_POST["area"]?>;

            const selectIndustry = document.getElementById('industry');

            selectIndustry.value = <?=$_POST["industry"]?>;

            const selectForm = document.getElementById('form');

            selectForm.value = <?=$_POST["form"]?>;
        <?php } else {?>
            const selectdArea = document.getElementById('area');
            selectdArea.value = 1;
            <?php } ?>

        //申し込みリストの実装（宣言)
        let agents = document.querySelectorAll(".agents");
        let likeButtons = document.querySelectorAll(".agents-likeButton");
        let likeNumber_icon = document.getElementById("likeList-button-number");
        let likeNumber = 0;
        let clicked = [];
        let save_items = [];
        let items = JSON.parse(localStorage.getItem("items"));
        let fragment = document.createDocumentFragment();//DOMの追加処理用のフラグメント
        let likeListContents = document.getElementById("likeList-contents");
        let formButton = document.getElementById("form-button");

        //ローカルストレージに保存されているデータを取得、反映
        if (items) {
            let id;
            for (let i = 0; i < items.length; i++) {
                id = items[i].id;
                console.log(id);
                save_items.push(items[i]);
                clicked.push(id);
                activate_btn(id);
            }
            if (items.length != 0) {
                likeNumber_icon.parentNode.classList.remove('likeList-closed');
                likeNumber_icon.innerHTML = items.length;
            }
        }

        //申し込みリストボタンが押された時の挙動
        likeButtons.forEach(function (likeButton) {
            likeButton.addEventListener('click', function () {
                let id = likeButton.dataset.aid;
                console.log(id);
                if (clicked.includes(id)) {
                    let index = clicked.indexOf(id);
                    clicked.splice(index, 1);
                    save_items.splice(index, 1);
                    inactivate_btn(id);
                } else {
                    let name = likeButton.dataset.name,
                        aid = likeButton.dataset.aid;
                    start = likeButton.dataset.start;
                    end = likeButton.dataset.end;
                    image = likeButton.dataset.image;
                    industry = likeButton.dataset.industry;
                    area = likeButton.dataset.area;
                    forms = likeButton.dataset.forms;
                    information = likeButton.dataset.information;
                    clicked.push(id);
                    save_items.push({
                        id: id,
                        name: name,
                        aid: aid,
                        start: start,
                        end: end,
                        image: image,
                        industry: industry,
                        area: area,
                        forms: forms,
                        information: information
                    });
                    activate_btn(id);
                }
                localStorage.setItem("items", JSON.stringify(save_items));
            });
        });

        //申し込みリストに追加された時の挙動
        function activate_btn(id) {
            likeNumber++;
            if (likeNumber >= 1) {
                likeNumber_icon.classList.remove('likeList-closed');
                formButton.disabled = false;
            } else {
                formButton.disabled = true;
            }
            likeNumber_icon.innerHTML = likeNumber; // 修正: 申し込みリストの数を表示
            likeButton = document.querySelector(`.agents-likeButton[data-aid="${id}"]`);
            console.log(likeButton);
            if(likeButton) {
                likeButton.classList.add('agents-likeButton-active');
                likeButton.innerHTML = "<img src='../../assets/img/image 15.png' alt=''><p>申し込みリストから削除</p>";
            }
        }

        //申し込みリストから削除された時の挙動
        function inactivate_btn(id) {
            likeNumber--;
            if (likeNumber == 0) {
                likeNumber_icon.classList.add('likeList-closed');
                formButton.disabled = true;
            } else {
                formButton.disabled = false;
            }
            likeNumber_icon.innerHTML = likeNumber; // 修正: 申し込みリストの数を表示
            likeButton = document.querySelector(`.agents-likeButton[data-aid="${id}"]`);
            if(likeButton) {
            likeButton.classList.remove('agents-likeButton-active');
            likeButton.innerHTML = "<img src='../../assets/img/image 15.png' alt=''><p>申し込みリストに追加</p>";
            }
        }

        //申し込みリストの内容決定(初回アップロード時)
        if (items) {
            for (let i = 0; i < items.length; i++) {
                let div = document.createElement('div'),
                divTop = document.createElement('div'),
                agentsTitle = document.createElement('h1'),
                agentsSpan = document.createElement('p'),
                agentsCenter = document.createElement('div'),
                agentsLogo = document.createElement('figure'),
                agentsContents = document.createElement('div'),
                agentsContentsTop = document.createElement('div'),
                contentsTop1 = document.createElement('p'),
                contentsTop2 = document.createElement('p'),
                contentsTop3 = document.createElement('p'),
                contentsTop4 = document.createElement('p'),
                agentsLine = document.createElement('div'),
                agentsContentsDetails = document.createElement('div'),
                agentIndustry = document.createElement('p'),
                agentArea = document.createElement('p'),
                agentForms = document.createElement('p'),
                agentInformation = document.createElement('p'),
                likeButton = document.createElement('button');

                div.classList.add('agents');

                divTop.classList.add('agents-top');

                agentsTitle.classList.add('agents-title');
                agentsTitle.textContent = items[i].name;

                agentsSpan.classList.add('agents-span');
                agentsSpan.textContent = `掲載期間:${items[i].start} ～ ${items[i].end}`;

                agentsCenter.classList.add('agents-center');

                agentsLogo.classList.add('agents-logo');
                agentsLogo.innerHTML = `<img src="../../assets/img/${items[i].image}" alt="">`;

                agentsContents.classList.add('agents-contents');

                agentsContentsTop.classList.add('agents-contents-top');

                contentsTop1.textContent = '業種';

                contentsTop2.textContent = 'エリア';

                contentsTop3.textContent = '形態';

                contentsTop4.textContent = '特徴';

                agentsLine.classList.add('agents-line');

                agentsContentsDetails.classList.add('agents-contents-details');

                agentIndustry.textContent = items[i].industry;
                agentArea.textContent = items[i].area;
                agentForms.textContent = items[i].forms;
                agentInformation.textContent = items[i].information;

                likeButton.classList.add('agents-likeButton2');
                likeButton.classList.add('agents-likeButton-active2');
                likeButton.innerHTML = "<img src='../../assets/img/image 15.png' alt=''><p>申し込みリストから削除</p>";
                likeButton.setAttribute('value', items[i].id);
                likeButton.dataset.aid = items[i].id;
                likeButton.dataset.name = items[i].name;
                likeButton.dataset.start = items[i].start;
                likeButton.dataset.end = items[i].end;
                likeButton.dataset.image = items[i].image;
                likeButton.dataset.industry = items[i].industry;
                likeButton.dataset.area = items[i].area;
                likeButton.dataset.forms = items[i].forms;
                likeButton.dataset.information = items[i].information;

                div.appendChild(divTop);
                divTop.appendChild(agentsTitle);
                divTop.appendChild(agentsSpan);
                div.appendChild(agentsCenter);
                agentsCenter.appendChild(agentsLogo);
                agentsCenter.appendChild(agentsContents);
                agentsContents.appendChild(agentsContentsTop);
                agentsContentsTop.appendChild(contentsTop1);
                agentsContentsTop.appendChild(contentsTop2);
                agentsContentsTop.appendChild(contentsTop3);
                agentsContentsTop.appendChild(contentsTop4);
                agentsContents.appendChild(agentsLine);
                agentsContents.appendChild(agentsContentsDetails);
                agentsContentsDetails.appendChild(agentIndustry);
                agentsContentsDetails.appendChild(agentArea);
                agentsContentsDetails.appendChild(agentForms);
                agentsContentsDetails.appendChild(agentInformation);
                div.appendChild(likeButton);
                fragment.appendChild(div);
            }
            }

            //申し込みリストへの反映、likeButtonの中身を更新
            likeListContents.appendChild(fragment);
            likeButtons = document.querySelectorAll(".agents-likeButton");
            likeButtons2 = document.querySelectorAll(".agents-likeButton2");

            //（申し込みリスト内の）申し込みリストボタンが押された時の挙動
            likeButtons2.forEach(function (likeButton) {
            likeButton.addEventListener('click', function () {
                let id = likeButton.dataset.aid;
                console.log(id);
                console.log("はーいはうい");
                if (clicked.includes(id)) {
                    let index = clicked.indexOf(id);
                    clicked.splice(index, 1);
                    save_items.splice(index, 1);
                    inactivate_btn2(id);
                }
                localStorage.setItem("items", JSON.stringify(save_items));
            });

            function inactivate_btn2(id) {
            likeNumber--;
            if (likeNumber == 0) {
                likeNumber_icon.classList.add('likeList-closed');
                formButton.disabled = true;
            } else {
                formButton.disabled = false;
            }
            likeNumber_icon.innerHTML = likeNumber; // 修正: 申し込みリストの数を表示
            likeButton2 = document.querySelector(`.agents-likeButton2[data-aid="${id}"]`);
            if(likeButton2) {
            likeButton2.classList.remove('agents-likeButton-active2');
            likeButton2.parentNode.classList.add('likeList-closed');
            likeButton2.innerHTML = "<img src='../../assets/img/image 15.png' alt=''><p>申し込みリストに追加</p>";
            }

            likeButton = document.querySelector(`.agents-likeButton[data-aid="${id}"]`);
            if(likeButton) {
            likeButton.classList.remove('agents-likeButton-active');
            likeButton.innerHTML = "<img src='../../assets/img/image 15.png' alt=''><p>申し込みリストに追加</p>";
            }
        }
            });

            //ボタンが押された時に、申込みリストを更新する。
            likeButtons.forEach(function (likeButton) {
            likeButton.addEventListener('click', function () {
                if (items) {
                    const agentsElements = Array.from(likeListContents.children).filter((child) => child.classList.contains('agents'));
                    agentsElements.forEach((element) => {
                    likeListContents.removeChild(element);
                });
                    items = JSON.parse(localStorage.getItem("items"));
            for (let i = 0; i < items.length; i++) {
                let div = document.createElement('div'),
                divTop = document.createElement('div'),
                agentsTitle = document.createElement('h1'),
                agentsSpan = document.createElement('p'),
                agentsCenter = document.createElement('div'),
                agentsLogo = document.createElement('figure'),
                agentsContents = document.createElement('div'),
                agentsContentsTop = document.createElement('div'),
                contentsTop1 = document.createElement('p'),
                contentsTop2 = document.createElement('p'),
                contentsTop3 = document.createElement('p'),
                contentsTop4 = document.createElement('p'),
                agentsLine = document.createElement('div'),
                agentsContentsDetails = document.createElement('div'),
                agentIndustry = document.createElement('p'),
                agentArea = document.createElement('p'),
                agentForms = document.createElement('p'),
                agentInformation = document.createElement('p'),
                likeButton = document.createElement('button');

                div.classList.add('agents');

                divTop.classList.add('agents-top');

                agentsTitle.classList.add('agents-title');
                agentsTitle.textContent = items[i].name;

                agentsSpan.classList.add('agents-span');
                agentsSpan.textContent = `掲載期間:${items[i].start} ～ ${items[i].end}`;

                agentsCenter.classList.add('agents-center');

                agentsLogo.classList.add('agents-logo');
                agentsLogo.innerHTML = `<img src="../../assets/img/${items[i].image}" alt="">`;

                agentsContents.classList.add('agents-contents');

                agentsContentsTop.classList.add('agents-contents-top');

                contentsTop1.textContent = '業種';

                contentsTop2.textContent = 'エリア';

                contentsTop3.textContent = '形態';

                contentsTop4.textContent = '特徴';

                agentsLine.classList.add('agents-line');

                agentsContentsDetails.classList.add('agents-contents-details');

                agentIndustry.textContent = items[i].industry;
                agentArea.textContent = items[i].area;
                agentForms.textContent = items[i].forms;
                agentInformation.textContent = items[i].information;

                likeButton.classList.add('agents-likeButton2');
                likeButton.classList.add('agents-likeButton-active2');
                likeButton.innerHTML = "<img src='../../assets/img/image 15.png' alt=''><p>申し込みリストから削除</p>";
                likeButton.setAttribute('value', items[i].id);
                likeButton.dataset.aid = items[i].id;
                likeButton.dataset.name = items[i].name;
                likeButton.dataset.start = items[i].start;
                likeButton.dataset.end = items[i].end;
                likeButton.dataset.image = items[i].image;
                likeButton.dataset.industry = items[i].industry;
                likeButton.dataset.area = items[i].area;
                likeButton.dataset.forms = items[i].forms;
                likeButton.dataset.information = items[i].information;

                div.appendChild(divTop);
                divTop.appendChild(agentsTitle);
                divTop.appendChild(agentsSpan);
                div.appendChild(agentsCenter);
                agentsCenter.appendChild(agentsLogo);
                agentsCenter.appendChild(agentsContents);
                agentsContents.appendChild(agentsContentsTop);
                agentsContentsTop.appendChild(contentsTop1);
                agentsContentsTop.appendChild(contentsTop2);
                agentsContentsTop.appendChild(contentsTop3);
                agentsContentsTop.appendChild(contentsTop4);
                agentsContents.appendChild(agentsLine);
                agentsContents.appendChild(agentsContentsDetails);
                agentsContentsDetails.appendChild(agentIndustry);
                agentsContentsDetails.appendChild(agentArea);
                agentsContentsDetails.appendChild(agentForms);
                agentsContentsDetails.appendChild(agentInformation);
                div.appendChild(likeButton);
                fragment.appendChild(div);
            }
            }

            //申込みリストを更新
            likeListContents.appendChild(fragment);
            likeButtons = document.querySelectorAll(".agents-likeButton");
            likeButtons2 = document.querySelectorAll(".agents-likeButton2");
            console.log(likeButtons2);

            //（申し込みリスト内の)申し込みリストボタンが押された時の挙動
        likeButtons2.forEach(function (likeButton) {
            likeButton.addEventListener('click', function () {
                let id = likeButton.dataset.aid;
                if (clicked.includes(id)) {
                    let index = clicked.indexOf(id);
                    clicked.splice(index, 1);
                    save_items.splice(index, 1);
                    inactivate_btn2(id);
                }
                localStorage.setItem("items", JSON.stringify(save_items));
            });
            function inactivate_btn2(id) {
            likeNumber--;
            if (likeNumber == 0) {
                likeNumber_icon.classList.add('likeList-closed');
                formButton.disabled = true;
            } else if (likeNumber >= 1) {
                formButton.disabled = false;
            }
            likeNumber_icon.innerHTML = likeNumber; // 修正: 申し込みリストの数を表示
            likeButton2 = document.querySelector(`.agents-likeButton2[data-aid="${id}"]`);
            likeButton2.classList.remove('agents-likeButton-active2');
            likeButton2.parentNode.classList.add('likeList-closed');
            likeButton2.innerHTML = "<img src='../../assets/img/image 15.png' alt=''><p>申し込みリストに追加</p>";
            likeButton = document.querySelector(`.agents-likeButton[data-aid="${id}"]`);
            likeButton.classList.remove('agents-likeButton-active');
            likeButton.innerHTML = "<img src='../../assets/img/image 15.png' alt=''><p>申し込みリストに追加</p>";
        }
            });});
        });
    </script>
</body>
</html>
