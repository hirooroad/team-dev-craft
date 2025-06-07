<?php
require(dirname(__FILE__) . '/../../dbconnect.php');

session_start();

if (!isset($_SESSION['agent_id'])) {
    header('Location: ../login/index.php');
} else {
    $stmt = $dbh->prepare('SELECT * FROM agents WHERE id = :agent_id');
    $stmt->bindValue(':agent_id', $_SESSION['agent_id'], PDO::PARAM_INT);
    $stmt->execute();
    $agent = $stmt->fetch();
}

    $name = $agent['name'];
    $industry = $agent['industry'];
    $area = $agent['area'];
    $content = $agent['information'];

    $stmt = $dbh->prepare('SELECT * FROM form WHERE agent_id = :agent_id');
    $stmt->bindValue(':agent_id', $_SESSION['agent_id'], PDO::PARAM_INT);
    $stmt->execute();
    $forms = $stmt->fetchAll();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $industry= $_POST['industry'];
        $area = $_POST['area'];
        $select = $_POST['select'];
        $information = $_POST['information'];

        $submitOK = 0;
        if($_FILES['image']['size'] > 0) {
        if ($_FILES['image']['size'] > 1024000) {
            $image_error = 'ファイルサイズは1MB以下にしてください';
        } else {
            $submitOK++;
        }

        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
        $file_parts = explode('.', $_FILES['image']['name']);
        $file_ext = strtolower(end($file_parts));
        if (!in_array($file_ext, $allowed_ext)) {
            $image_error = '許可されていない拡張子です';
        } else {
            $submitOK++;
        }

        $_SESSION['image'] = $_FILES['image'];

        $image_name = uniqid(mt_rand(), true) . '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
        $_SESSION['image_name'] = $image_name;
        $image_path = dirname(__FILE__) . '/../../assets/img/' . $image_name;

        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);

    } else {
        $image_name = $agent['image'];
        $submitOK++;
        $submitOK++;
    }

            if($industry != 0) {
                $submitOK++;
            } else {
                $industry_error = '業種が選択されていません';
            }

            if ($submitOK == 3) {
                $stmt = $dbh->prepare('UPDATE agents SET name = :name, industry = :industry, area = :area, information = :information WHERE id = :agent_id');
                $stmt->bindValue(':name', $name, PDO::PARAM_STR);
                $stmt->bindValue(':industry', $industry, PDO::PARAM_INT);
                $stmt->bindValue(':area', $area, PDO::PARAM_INT);
                $stmt->bindValue(':information', $information, PDO::PARAM_STR);
                $stmt->bindValue(':agent_id', $_SESSION['agent_id'], PDO::PARAM_INT);
                $stmt->execute();

                if(isset($_FILES['image']) ) {
                    $stmt = $dbh->prepare('UPDATE agents SET image = :image WHERE id = :agent_id');
                    $stmt->bindValue(':image', $image_name, PDO::PARAM_STR);
                    $stmt->bindValue(':agent_id', $_SESSION['agent_id'], PDO::PARAM_INT);
                    $stmt->execute();
                }

                $stmt = $dbh->prepare('DELETE FROM form WHERE agent_id = :agent_id');
                $stmt->bindValue(':agent_id', $_SESSION['agent_id'], PDO::PARAM_INT);
                $stmt->execute();

                foreach ($select as $select) {
                    $stmt = $dbh->prepare('INSERT INTO form (agent_id, form) VALUES (:agent_id, :form)');
                    $stmt->bindValue(':agent_id', $_SESSION['agent_id'], PDO::PARAM_INT);
                    $stmt->bindValue(':form', $select, PDO::PARAM_INT);
                    $stmt->execute();
                }
                header('Location: ../index.php');
            }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>エージェント編集 CRAFT for Agent 就活エージェント比較サイト</title>
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
    <div class="edit">
        <form method="POST" enctype="multipart/form-data">
            <div class="edit-top">
                            <p class="edit-title">エージェント情報を編集する</p>
                        </div>
                        <div class="edit-content">
                            <p class="edit-item">企業ロゴ</p>   <p class="form_error_message">
                                <?php if(isset($image_error)) {echo $image_error;}?>
                            </p>
                                <input type="file"  class="edit-image" name="image" id="image"  placeholder="ああ" />
                            <p class="edit-item" required>企業名</p><p class="form_error_message"></p>
                                <input type="text" id="name" name="name" class="edit-write">
                            <p class="edit-item">業種</p><p class="form_error_message">
                                <?php if(isset($industry_error)) {echo $industry_error;}?>
                            </p>
                            <select name="industry" id="industry" class="edit-select">
                                <option disabled selected>選択してください</option>
                                <option class="industry-value" value="1">総合型</option>
                                <option class="industry-value" value="2">理系就職</option>
                                <option class="industry-value" value="3">IT系</option>
                                <option class="industry-value" value="4">美術系</option>
                            </select>
                            <p class="edit-item">エリア</p>
                            <select name="area" id="area" class="edit-select">
                                <option class="area-value" value="0" disabled selected>選択してください</option>
                                <option class="prefecture-input"value="1">全国</option>
                                <option class="prefecture-input" value="2">北海道・東北</option>
                                <option class="prefecture-input" value="3">関東</option>
                                <option class="prefecture-input" value="4">中部</option>
                                <option class="prefecture-input" value="5">近畿</option>
                                <option class="prefecture-input" value="6">中国・四国</option>
                                <option class="prefecture-input" value="7">九州・沖縄</option>
                            </select>

                            <p class="edit-item">形態</p>
                            <section class="edit-form">
                                <label class="edit-form-label"><input class="edit-form-input" type="checkbox" name="select[]" value="1">大手</label>
                                <label class="edit-form-label"><input class="edit-form-input" type="checkbox" name="select[]" value="2">中小</label>
                                <label class="edit-form-label"><input class="edit-form-input" type="checkbox" name="select[]" value="3">ベンチャー</label>
                                <label class="edit-form-label"><input class="edit-form-input" type="checkbox" name="select[]" value="4">外資</label>
                            </section>
                            <p class="edit-item">特徴</p><p class="form_error_message"></p>
                            <textarea name="information" id="information" class="edit-information" maxlength="60" onkeyup="ShowLength( 'inputlength2' , value );" required></textarea>
                            <p id="inputlength2">0文字</p>
                        </div>
                        <button type="submit" id="" class="edit-complete-button">編集完了</button>
        </form>
                </div>
    </div>
    </main>
    <script>
        function ShowLength( idn, str ) {
        document.getElementById(idn).innerHTML = str.length + "文字";
}

        const nameInput = document.getElementById('name');
        const industryInput = document.querySelectorAll('.industry-value');
        const areaInput = document.querySelectorAll('.prefecture-input');
        const formInput = document.querySelectorAll('.edit-form-input');
        const informationInput = document.getElementById('information');
        const confirmButton = document.querySelector('.edit-complete-button');
        const errorMessage = document.querySelectorAll('.form_error_message');

        nameInput.value = "<?=$name?>";
        const industry = "<?=$industry?>";
        if (industry != "") {
            industryInput[industry - 1].selected = true;
        }
        const area = "<?=$area?>";
        if (area != "") {
            areaInput[area - 1].selected = true;
        }
        <?php
                if ($forms != "")
                foreach ($forms as $form) {?>
                    formInput[<?=$form[2]?> - 1].checked = true;
                <?php }?>
        informationInput.value = "<?=$content?>";

        confirmButton.addEventListener('click', () => {
            if (nameInput.value === "") {
                errorMessage[0].textContent = '企業名が入力されていません';
            } else if (informationInput.value === "") {
                errorMessage[1].textContent = '特徴が入力されていません';
            }
        });
    </script>
</html>