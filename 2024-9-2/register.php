<?php

date_default_timezone_set('Asia/Tokyo');

// 他のPHPファイルを読み込む
require_once __DIR__ . '/functions/user.php';

$errorMessages = [];
$successMessage = '';

// フォームが送信されたかチェックする
if (isset($_POST['submit-button'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $current_time = date('Y-m-d H:i:s');

    // メールアドレスの重複チェック
    $users = getUsers();
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            $errorMessages['email'] = 'このメールアドレスは既に登録されています';
            break;
        }
    }

    // パスワードの長さチェック
    if (strlen($password) < 6) {
        $errorMessages['password'] = 'パスワードは6文字以上で入力してください';
    }

    // エラーメッセージがない場合、ユーザーを保存
    if (empty($errorMessages)) {
        // 連想配列を作成
        $user = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'Time' => $current_time,
        ];

        // 関数を呼び出す
        saveUser($user);

        // 成功メッセージを設定
        $successMessage = '登録が成功しました！';

        // セッションにIDを保存
        $_SESSION['id'] = $user['id'];

        // my-page に移動させる（リダイレクト）
        header('refresh:3;url=./my-page.php');
        echo "<p style='color: green;'>$successMessage</p>";
        exit();
    }
}

?>
<html>
    <head>
        <style>
            .error {
                color: red;
            }
        </style>
    </head>
    <body>
        <h1>会員登録</h1>
        <!-- action: フォームの送信先 -->
        <!-- method: 送信方法（GET / POST） -->
        <form action="./register.php" method="post">
            <div>
                お名前<br>
                <input type="text" name="name" value="<?php echo isset($name) ? $name : '' ?>">
            </div>
            <div>
                メールアドレス<br>
                <input type="email" name="email" value="<?php echo isset($email) ? $email : '' ?>">
                <?php if (isset($errorMessages['email'])): ?>
                    <p class="error"><?php echo $errorMessages['email'] ?></p>
                <?php endif ?>
            </div>
            <div>
                パスワード<br>
                <input type="password" name="password">
                <?php if (isset($errorMessages['password'])): ?>
                    <p class="error"><?php echo $errorMessages['password'] ?></p>
                <?php endif ?>
            </div>
            <div>
                <!-- <button type="submit">登録</button> -->
                <input type="submit" value="登録" name="submit-button">
            </div>
        </form>
    </body>
</html>
