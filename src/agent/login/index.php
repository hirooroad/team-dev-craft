<?php
require(dirname(__FILE__) . '/../../dbconnect.php');

$message = '';
$message1 = '';
$message2 = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(empty($_POST['email'])) {
        $message1 = 'メールアドレスは必須項目です。';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $message1 = '正しいEメールアドレスを指定してください。';
    }
    if (empty($_POST['password'])) {
        $message2 = 'パスワードは必須項目です。';
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $dbh->prepare('SELECT * FROM agents WHERE login_id = :email');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $agent = $stmt->fetch();

        if($agent && password_verify($password, $agent['password'])) {
            session_start();
            $_SESSION['agent_id'] = $agent['id'];
            header('Location: ../index.php');
            exit();
        } else {
            $message = 'ログイン情報が間違っています。';
        }
    }
}


// session_start();

// // if($_POST){
// //     $loginID = $_SESSION['login_id'];
// //     $oldPassword = $_SESSION['old_password'];
// //     $newPassword = $_SESSION['new_password'];
// //     $confirmationNewPassword = $_SESSION['confirmation_new_password'];

// if ($_POST) {
//     if (isset($_SESSION['login_id'], $_SESSION['old_password'],
//           $_SESSION['new_password'], $_SESSION['confirmation_new_password'])) {
//       $loginID = $_SESSION['login_id'];
//       $oldPassword = $_SESSION['old_password'];
//       $newPassword = $_SESSION['new_password'];
//       $confirmationNewPassword = $_SESSION['confirmation_new_password'];
  
//       // Process the login credentials (e.g., validate password, update database)
//     } else {
//       // Handle the case where session variables are missing
//       echo "Error: Required session data not found.";
//     }
//     $_SESSION['login_id'] = $_POST['login_id'];
//     $_SESSION['old_password'] = $_POST['old_password'];
//     $_SESSION['new_password'] = $_POST['new_password'];
//     $_SESSION['confirmation_new_password'] = $_POST['confirmation_new_password'];
//   }




// if(isset($_SESSION['login_id']) && !empty($_SESSION['login_id'])) {
//     $loginId = $_SESSION['login_id'];
//     $oldPassword = $_SESSION['old_password'];
//     $newPassword = $_SESSION['new_password'];
//     $confirmationNewPassword = $_SESSION['confirmation_new_password'];

//     // Check if new passwords match
//     if($newPassword === $confirmationNewPassword) {
//         $stmt = $dbh->prepare('SELECT * FROM agents WHERE login_id = :email');
//         if($stmt) {
//             $stmt->bindValue(':email', $loginId);
//             $stmt->execute();
//             $agent = $stmt->fetch();

//             if($agent && password_verify($oldPassword, $agent['password'])) {
//                 $stmt = $dbh->prepare('UPDATE agents SET password = :password WHERE login_id = :email');
//                 if($stmt) {
//                     $stmt->bindValue(':password', password_hash($newPassword, PASSWORD_DEFAULT));
//                     $stmt->bindValue(':email', $loginId);
//                     $stmt->execute();
//                     session_destroy();
//                     header('Location: ../index.php');
//                     exit();
//                 } else {
//                     // Handle prepare error
//                     $message = 'データベースエラーが発生しました。';
//                     echo $message;
//                 }
//             } else {
//                 $message = 'ログイン情報が間違っています。';
//                 echo $message;
//             }
//         } else {
//             // Handle prepare error
//             $message = 'データベースエラーが発生しました。';
//             echo $message;
//         }
//     } else {
//         $message = '新しいパスワードが一致しません。';
//         echo $message;
//     }
// }

// require(dirname(__FILE__)) . '/../../dbconnect.php';

// session_start();

// if(isset($_SESSION['login_id'])) {
//     if($_SESSION['login_id']){
//         $loginId = $_SESSION['login_id'];
//         $oldPassword = $_SESSION['old_password'];
//         $newPassword = $_SESSION['new_password'];
//         $confirmationNewPassword = $_SESSION['confirmation_new_password'];

//         $stmt = $dbh->prepare('SELECT * FROM agents WHERE login_id = :login_id');
//         $stmt->bindValue(':login_id', $loginId);
//         $stmt->execute();
//         $agent = $stmt->fetch();

//         if($agent && password_verify($oldPassword, $agent['password'])) {
//             $stmt = $dbh->prepare('UPDATE agents SET password = :password WHERE login_id = :login_id');
//             $stmt->bindValue(':password', password_hash($newPassword, PASSWORD_DEFAULT));
//             $stmt->bindValue(':login_id', $loginId);
//             $stmt->execute();
//             session_destroy();
//             header('Location: ../index.php');
//             exit();
//         } else {
//             $message = 'ログイン情報が間違っています。';
//             echo $message;
//         }
//     }
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン CRAFT for Agent 就活エージェント比較サイト</title>
    <link rel="stylesheet" href="../../assets/css/agent.css">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
<?php include(dirname(__FILE__) . '../../../components/agent/header2.php'); ?>
    <main>
        <div class="header-go"></div>
        <div class="login-padding">
            <div>
                <p class="login-title">エージェント企業用ログイン</p>
                <p class="error-message">
                    <?= $message?>
                </p>
            </div>
            <form action="" class="login-form" method="POST">
            <div>
                <p class="login-form-top">ログインID(emailアドレス)</p>
                <p class="error-message">
                    <?= $message1?>
                </p>
                    <input type="text" name="email" id="email"><p class="form_error_message"></p>
            </div>
            <div>
                <p class="login-form-top">パスワード</p>
                <p class="error-message"> <?= $message2?></p>
                <br>
                <input type="password" name="password" id="password">
                </div>
                <div class="login-button-block">
                    <button class="login-button">ログイン</button>
                    <a href="change_password.php" class="password-changeButton">パスワードの新規更新</a>
                </div>
            </form>
        </div>
    </main>
    <script src="/../../assets/js/agent.js"></script>
</body>
</html>