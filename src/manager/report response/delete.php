<?php
require(dirname(__FILE__) . '/../../dbconnect.php');

session_start();

if (!isset($_SESSION['agent'])) {
    header('Location: ../index.php');
} else {
    
        $stmt = $dbh->prepare('SELECT *  from alert WHERE id = :alert_id');
        $stmt->bindValue(':alert_id', $_GET['id']);
        $stmt->execute();
        $alert = $stmt->fetch();
    
        $stmt = $dbh->prepare('SELECT * FROM applicants WHERE id = :applicant_id');
        $stmt->bindValue(':applicant_id', $alert['applicant_id']);
        $stmt->execute();
        $applicant = $stmt->fetchAll();

        $stmt = $dbh->prepare('SELECT * FROM agents WHERE id = :agent_id');
        $stmt->bindValue(':agent_id', $alert['agent_id']);
        $stmt->execute();
        $agent = $stmt->fetch();
        $agent['alert_number'] = $agent['alert_number'] + 1;

        $stmt = $dbh->prepare('DELETE FROM alert WHERE applicant_id = :applicant_id');
        $stmt->bindValue(':applicant_id', $alert['applicant_id']);
        $stmt->execute();

        // $stmt = $dbh->prepare('DELETE FROM applicants WHERE id = :applicant_id');
        // $stmt->bindValue(':applicant_id', $alert['applicant_id']);
        // $stmt->execute();

        $stmt = $dbh->prepare('DELETE FROM submit WHERE applicant_id = :applicant_id AND agent_id = :agent_id');
        $stmt->bindValue(':applicant_id', $alert['applicant_id']);
        $stmt->bindValue(':agent_id', $alert['agent_id']);
        $stmt->execute();

        $stmt = $dbh->prepare('UPDATE agents SET alert_number = :alert_number WHERE id = :agent_id');
        $stmt->bindValue(':alert_number', $agent['alert_number'], PDO::PARAM_INT);
        $stmt->bindValue(':agent_id', $alert['agent_id'], PDO::PARAM_INT);
        $stmt->execute();

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

        $headers = "From: craft@example.com";
            $headers .= "MIME-Version: 1.0\n";
            $headers .= "Content-Transfer-Encoding: BASE64\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\n";
// 宛先
        $to = $applicant[0]['mail_address'];

// 件名
        $subject = "通報されたことにより申し込みが削除されました。";

// 本文
        $body = "通報フォームが承認されたことにより、".$agent['name']."社への申し込みが削除されました。\n
        通報対象：".$applicant[0]['name']."\n
        通報内容：".$place[$alert['place']]."\n
        通報理由：".$alert['reason']."\n
        通報日時：".$alert['day']."\n
        \n

        このメールは自動送信です。\n
        お心当たりのない場合は、お手数ですが破棄してください。\n\n

        CRAFT for Agent 就活エージェント比較サイト\n
        株式会社boozer";

        $rtt = mb_send_mail($to, $subject, $body,  $headers);

        $to2= $agent['login_id'];

        $subject2 = "通報フォームが承認されました";

        $body2 = "".$applicant[0]['name']."様に対する通報フォームが承認されました。\n\n
        ご不明な点がございましたら、弊社にてお問い合わせください。\n\n
        このメールは自動送信です。\n
        お心当たりのない場合は、お手数ですが破棄してください。\n\n

        CRAFT for Agent 就活エージェント比較サイト\n
        株式会社boozer";

        // メール送信
        $rtt2 = mb_send_mail($to2, $subject2, $body2,  $headers);

}
        header('Location: ./index.php');
