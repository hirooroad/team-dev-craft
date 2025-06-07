<?php
require(dirname(__FILE__)) . '/../../dbconnect.php';

$message = '';
$message1 = '';
$message2 = '';
$message3 = '';
$message4 = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(empty($_POST['login_id'])) {
        $message1 = 'メールアドレスは必須項目です。';
        $message = '入力した内容に間違いがあります。';
    } elseif (!filter_var($_POST['login_id'], FILTER_VALIDATE_EMAIL)) {
        $message1 = '正しいEメールアドレスを指定してください。';
        $message = '入力した内容に間違いがあります。';
    }
    if (empty($_POST['old_password'])) {
        $message2 = 'パスワードは必須項目です。';
        $message = '入力した内容に間違いがあります。';
    }
    if(empty($_POST['new_password'])) {
        $message3 = '新しいパスワードは必須項目です。';
        $message = '入力した内容に間違いがあります。';
    }

    if (empty ($_POST['confirmation_new_password'])) {
        $message4 = '新しいパスワード(確認)は必須項目です。';
        $message = '入力した内容に間違いがあります。';
    }else if ($_POST['new_password'] !== $_POST['confirmation_new_password']) {
        $message4 = '新しいパスワードが一致しません。';
        $message = '入力した内容に間違いがあります。';
    }

  // エラーがない場合のみ処理続行
    if (empty($message1) && empty($message2) && empty($message3) && empty($message4)) {
    // // データベース接続
    // $dbh = new PDO(DSN, USERNAME, PASSWORD);

    // ユーザー情報取得
    $stmt = $dbh->prepare('SELECT * FROM agents WHERE login_id = :email');
    $stmt->bindValue(':email', $_POST['login_id']);
    $stmt->execute();
    $agent = $stmt->fetch();

    // ログイン情報確認
    if ($agent && password_verify($_POST['old_password'], $agent['password'])) {
      // トランザクション開始
    $dbh->beginTransaction();

      // パスワード更新
    $stmt = $dbh->prepare('UPDATE agents SET password = :password WHERE login_id = :login_id');
    $stmt->bindValue(':password', password_hash($_POST['new_password'], PASSWORD_DEFAULT));
    $stmt->bindValue(':login_id', $_POST['login_id']);
    $stmt->execute();

      // トランザクションコミット
    $dbh->commit();

      // セッション破棄
    // session_destroy();

      // トップページへリダイレクト
    header('Location: ./index.php');
    exit();
    } else {
      // ログイン情報が間違っている場合
    $message = 'ログイン情報が間違っています。';
    }
  }
}



//     if(!empty($message1) || !empty($message2) || !empty($message)){
//         $message = '入力した内容に間違いがあります。';
//     }
//     else{ $login_id = $_POST['login_id'];
//         $old_password = $_POST['old_password'];

//         $stmt = $dbh->prepare('SELECT * FROM agents WHERE login_id = :email');
//         $stmt->bindValue(':email', $login_id);
//         $stmt->execute();
//         $agent = $stmt->fetch();

//         if($agent && password_verify($old_password, $agent
//         ['password'])) {
//             session_start();
//             $_SESSION['agent'] = $agent;
//             // header('Location: ../index.php');
//             exit();
//         }
//         //  else {
//         //     $message = 'ログイン情報が間違っています。';
//         // }
//     }
//     if(!empty($message3) || !empty($message4)){
//         $message = '入力した内容に間違いがあります。';
//     }else {
//         $new_password = $_POST['new_password'];
//         $confirmation_new_password = $_POST['confirmation_new_password'];

//         $stmt = $dbh->prepare('UPDATE agents SET password = :password WHERE login_id = :login_id');
//         $stmt->bindValue(':password', password_hash($new_password, PASSWORD_DEFAULT));
//         $stmt->bindValue(':login_id', $login_id);
//         $stmt->execute();
//         // session_destroy();
//         header('Location: ./index.php');
//         exit();
//     }
// }


// session_start();

// // Initialize variables to avoid undefined variable warnings
// $loginId = isset($_SESSION['login_id']) ? $_SESSION['login_id'] : '';
// $oldPassword = isset($_SESSION['old_password']) ? $_SESSION['old_password'] : '';
// $newPassword = isset($_SESSION['new_password']) ? $_SESSION['new_password'] : '';
// $confirmationNewPassword = isset($_SESSION['confirmation_new_password']) ? $_SESSION['confirmation_new_password'] : '';

// // Proceed if the login ID is set and not empty
// if(!empty($loginId)) {
//     // Check if new passwords match
//     if($newPassword === $confirmationNewPassword) {
//         $stmt = $dbh->prepare('SELECT * FROM agents WHERE login_id = :login_id');
//         if($stmt) {
//             $stmt->bindValue(':login_id', $loginId);
//             if($stmt->execute()) {
//                 $agent = $stmt->fetch();

//                 if($agent && password_verify($oldPassword, $agent['password'])) {
//                     $stmt = $dbh->prepare('UPDATE agents SET password = :password WHERE login_id = :login_id');
//                     if($stmt) {
//                         $stmt->bindValue(':password', password_hash($newPassword, PASSWORD_DEFAULT));
//                         $stmt->bindValue(':login_id', $loginId);
//                         if($stmt->execute()) {
//                             session_destroy();
//                             header('Location: ./index.php');
//                             exit();
//                         } else {
//                             // Handle execution error
//                             $message = 'パスワードの更新中にエラーが発生しました。';
//                             echo $message;
//                         }
//                     } else {
//                         // Handle prepare error
//                         $message = 'データベースエラーが発生しました。';
//                         echo $message;
//                     }
//                 } else {
//                     $message = 'ログイン情報が間違っています。';
//                     echo $message;
//                 }
//             } else {
//                 // Handle execution error
//                 $message = 'データベースエラーが発生しました。';
//                 echo $message;
//             }
//         } else {
//             // Handle prepare error
//             $message = 'データベースエラーが発生しました。';
//             echo $message;
//         }
// }
// }


// session_start();

// if(isset($_SESSION['login_id'])) {
//     if($_SESSION['login_id']){
//         $loginId = $_SESSION['login_id'];
//         $oldPassword = $_SESSION['old_password'];
//         $newPassword = $_SESSION['new_password'];
//         $confirmationNewPassword = $_SESSION['confirmation_new_password'];
//     }
// } else{
//     $loginId = '';
//     $oldPassword = '';
//     $newPassword = '';
//     $confirmationNewPassword = '';
// }

// if(isset($_SESSION['login_id']) && !empty($_SESSION['login_id'])) {
//     $loginId = $_SESSION['login_id'];
//     $oldPassword = $_SESSION['old_password'];
//     $newPassword = $_SESSION['new_password'];
//     $confirmationNewPassword = $_SESSION['confirmation_new_password'];

//     // Check if new passwords match
//     if($newPassword === $confirmationNewPassword) {
//         $stmt = $dbh->prepare('SELECT * FROM agents WHERE login_id = :login_id');
//         if($stmt) {
//             $stmt->bindValue(':login_id', $loginId);
//             $stmt->execute();
//             $agent = $stmt->fetch();

//             if($agent && password_verify($oldPassword, $agent['password'])) {
//                 $stmt = $dbh->prepare('UPDATE agents SET password = :password WHERE login_id = :login_id');
//                 if($stmt) {
//                     $stmt->bindValue(':password', password_hash($newPassword, PASSWORD_DEFAULT));
//                     $stmt->bindValue(':login_id', $loginId);
//                     $stmt->execute();
//                     session_destroy();
//                     header('Location: ./index.php');
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
    <title>パスワード変更 CRAFT for Agent 就活エージェント比較サイト</title>
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
                <p class="login-title">パスワードを更新する</p>
                <p class="error-message">
                <?= $message?>
                </p>
            </div>
            <!-- <form> -->
            <form action="" class="login-form" method="POST">
            <div>
                <p class="login-form-top">ログインID(emailアドレス)</p>
                <p class="error-message">
                <?= $message1?>
                </p>
                <label action="" class="login-form"><p class="form_error_message"></p>
                    <input type="text" name="login_id" id="login_id">
                </label>
            </div>
            <div>
                <p class="login-form-top">旧パスワード</p>
                <p class="error-message">
                <?= $message2?>
                </p>
                <label action="" class="login-form"><p class="form_error_message"></p>
                    <input type="password" name="old_password" id="old_password">
                </label>
            </div>
            <div>
                <p class="login-form-top">新パスワード</p>
                <p class="error-message">
                <?= $message3?>
                </p>
                <label action="" class="login-form"><p class="form_error_message"></p>
                    <input type="password" name="new_password" id="new_password">
                </label>
            </div>
            <div>
                <p class="login-form-top">新パスワード(確認)
                </p>
                <p class="error-message">
                <?= $message4?>
                </p>
                <label action="" class="login-form"><p class="form_error_message"></p>
                    <input type="password" name="confirmation_new_password" id="confirmation_new_password">
                </label>
            </div>
            <div class="login-button-block">
                <button class="login-button" type="submit">更新</button>
            </div>
            </form>
        </div>
    </main>
    <script>
    // const submitButton = document.querySelector('.login-button');
    // const errorMessage = document.querySelectorAll('.form_error_message');
    // const loginIdInput = document.getElementById('login_id');
    // const oldPasswordInput = document.getElementById('old_password');
    // const newPasswordInput = document.getElementById('new_password');
    // const confirmationNewPasswordInput = document.getElementById('confirmation_new_password');
    // let error = "";
    // let errorNumber = 0;

    // submitButton.addEventListener('click', () => {
    //     errorNumber = 0;

        // const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // if (loginIdInput.value === '') {
        //     error = 'ログインID(メールアドレス)が入力されていません';
        //     console.log(error);
        //     console.log(errorMessage[0]);
        //     errorMessage[0].textContent = error;
        //     errorNumber++;
        // } else if (!emailRegex.test(loginIdInput.value)) {
        //     error = 'ログインID(メールアドレス)の形式が正しくありません';
        //     errorMessage[0].textContent = error;
        //     errorNumber++;
        // }else {
        //     errorMessage[0].textContent = "";
        // }

        // if (oldPasswordInput.value === "") {
        //     error = "現在登録されているパスワードが入力されていません";
        //     console.log(error);
        //     console.log(errorMessage[1]);
        //     errorMessage[1].textContent = error;
        //     errorNumber++;
        // } else {
        //     errorMessage[1].textContent = "";
        // }

        // if (newPasswordInput.value === "") {
        //     error = "新しいパスワードが入力されていません";
        //     console.log(error);
        //     console.log(errorMessage[0]);
        //     errorMessage[0].textContent = error;
        //     errorNumber++;
        // } else {
        //     errorMessage[0].textContent = "";
        // }

        // if (confirmationNewPasswordInput.value === "") {
        //     error = "新しいパスワードが入力されていません";
        //     console.log(error);
        //     console.log(errorMessage[1]);
        //     errorMessage[1].textContent = error;
        //     errorNumber++;
        // }else if (newPasswordInput.value !== confirmationNewPasswordInput.value) {
        //         error = "パスワードが一致しません";
        //         console.log(error);
        //         console.log(errorMessage[1]);
        //         errorMessage[1].textContent = error;
        //         errorNumber++;
        // } else {
        //     errorMessage[1].textContent = "";
        // }


        // console.log(errorNumber);


    //     if (errorNumber === 0) {
    //         location.href = './index.php';
    //     }
    // });
    </script>
</body>
</html>