<?php

require_once __DIR__ . '/functions/user.php';

// これを忘れない
session_start();

// セッションとCOOKIEにIDが保存されていなければ
// ログインページに移動
if (!isset($_SESSION['id']) && !isset($_COOKIE['id'])) {
    header('Location: ./login.php');
    exit();
}

// セッションにIDが保存されていればセッション
// ない場合はCOOKIEからIDを取得
$id = $_SESSION['id'] ?? $_COOKIE['id'];

$user = getUser($id);

// ユーザーが見つからなかったらログインページへ
if (is_null($user)) {
    header('Location: ./login.php');
    exit();
}

// 更新処理
if (isset($_POST['update-button'])) {
    $user['name'] = $_POST['name'];
    
    $user['password'] = $_POST['password'];
    $user['birthday'] = $_POST['birthday'];
    $user['residence'] = $_POST['residence'];

    // 保存処理（ここでは簡単にファイルに書き込む処理を行います）
    updateUser($user);

    // 更新後のメッセージ
    $updateMessage = 'ユーザー情報が更新されました！';
}

?>
<html>
    <head>
        <style>
            .error {
                color: red;
            }
            .success {
                color: green;
            }
        </style>
    </head>
    <body>
        <h1>マイページ</h1>
        <?php if (isset($updateMessage)): ?>
            <p class="success"><?php echo $updateMessage ?></p>
        <?php endif ?>
        <form action="./my-page.php" method="post">
            <table>
                <tr>
                    <td>ID</td>
                    <td>
                        <?php echo $user['id'] ?>
                    </td>
                </tr>
                <tr>
                    <td>名前</td>
                    <td>
                        <input type="text" name="name" value="<?php echo $user['name'] ?>">
                    </td>
                </tr>
                <tr>
                    <td>メールアドレス</td>
                    <td>
                        <?php echo $user['email'] ?>
                    </td>
                </tr>
                <tr>
                    <td>パスワード</td>
                    <td>
                        <input type="password" name="password" id="password" value="<?php echo $user['password'] ?>">
                        <label>
                            <input type="radio" name="show_password" value="show" onclick="document.getElementById('password').type='text'"> 表示
                        </label>
                        <label>
                            <input type="radio" name="show_password" value="hide" onclick="document.getElementById('password').type='password'" checked> 隠す
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>誕生日</td>
                    <td>
                        <input type="date" name="birthday" value="<?php echo $user['birthday'] ?>">
                    </td>
                </tr>
                <tr>
                    <td>住所</td>
                    <td>
                    <select name="residence">
    <option value="北海道" <?php echo $user['residence'] == '北海道' ? 'selected' : '' ?>>北海道</option>
    <option value="青森県" <?php echo $user['residence'] == '青森県' ? 'selected' : '' ?>>青森県</option>
    <option value="岩手県" <?php echo $user['residence'] == '岩手県' ? 'selected' : '' ?>>岩手県</option>
    <option value="宮城県" <?php echo $user['residence'] == '宮城県' ? 'selected' : '' ?>>宮城県</option>
    <option value="秋田県" <?php echo $user['residence'] == '秋田県' ? 'selected' : '' ?>>秋田県</option>
    <option value="山形県" <?php echo $user['residence'] == '山形県' ? 'selected' : '' ?>>山形県</option>
    <option value="福島県" <?php echo $user['residence'] == '福島県' ? 'selected' : '' ?>>福島県</option>
    <option value="茨城県" <?php echo $user['residence'] == '茨城県' ? 'selected' : '' ?>>茨城県</option>
    <option value="栃木県" <?php echo $user['residence'] == '栃木県' ? 'selected' : '' ?>>栃木県</option>
    <option value="群馬県" <?php echo $user['residence'] == '群馬県' ? 'selected' : '' ?>>群馬県</option>
    <option value="埼玉県" <?php echo $user['residence'] == '埼玉県' ? 'selected' : '' ?>>埼玉県</option>
    <option value="千葉県" <?php echo $user['residence'] == '千葉県' ? 'selected' : '' ?>>千葉県</option>
    <option value="東京都" <?php echo $user['residence'] == '東京都' ? 'selected' : '' ?>>東京都</option>
    <option value="神奈川県" <?php echo $user['residence'] == '神奈川県' ? 'selected' : '' ?>>神奈川県</option>
    <option value="新潟県" <?php echo $user['residence'] == '新潟県' ? 'selected' : '' ?>>新潟県</option>
    <option value="富山県" <?php echo $user['residence'] == '富山県' ? 'selected' : '' ?>>富山県</option>
    <option value="石川県" <?php echo $user['residence'] == '石川県' ? 'selected' : '' ?>>石川県</option>
    <option value="福井県" <?php echo $user['residence'] == '福井県' ? 'selected' : '' ?>>福井県</option>
    <option value="山梨県" <?php echo $user['residence'] == '山梨県' ? 'selected' : '' ?>>山梨県</option>
    <option value="長野県" <?php echo $user['residence'] == '長野県' ? 'selected' : '' ?>>長野県</option>
    <option value="岐阜県" <?php echo $user['residence'] == '岐阜県' ? 'selected' : '' ?>>岐阜県</option>
    <option value="静岡県" <?php echo $user['residence'] == '静岡県' ? 'selected' : '' ?>>静岡県</option>
    <option value="愛知県" <?php echo $user['residence'] == '愛知県' ? 'selected' : '' ?>>愛知県</option>
    <option value="三重県" <?php echo $user['residence'] == '三重県' ? 'selected' : '' ?>>三重県</option>
    <option value="滋賀県" <?php echo $user['residence'] == '滋賀県' ? 'selected' : '' ?>>滋賀県</option>
    <option value="京都府" <?php echo $user['residence'] == '京都府' ? 'selected' : '' ?>>京都府</option>
    <option value="大阪府" <?php echo $user['residence'] == '大阪府' ? 'selected' : '' ?>>大阪府</option>
    <option value="兵庫県" <?php echo $user['residence'] == '兵庫県' ? 'selected' : '' ?>>兵庫県</option>
    <option value="奈良県" <?php echo $user['residence'] == '奈良県' ? 'selected' : '' ?>>奈良県</option>
    <option value="和歌山県" <?php echo $user['residence'] == '和歌山県' ? 'selected' : '' ?>>和歌山県</option>
    <option value="鳥取県" <?php echo $user['residence'] == '鳥取県' ? 'selected' : '' ?>>鳥取県</option>
    <option value="島根県" <?php echo $user['residence'] == '島根県' ? 'selected' : '' ?>>島根県</option>
    <option value="岡山県" <?php echo $user['residence'] == '岡山県' ? 'selected' : '' ?>>岡山県</option>
    <option value="広島県" <?php echo $user['residence'] == '広島県' ? 'selected' : '' ?>>広島県</option>
    <option value="山口県" <?php echo $user['residence'] == '山口県' ? 'selected' : '' ?>>山口県</option>
    <option value="徳島県" <?php echo $user['residence'] == '徳島県' ? 'selected' : '' ?>>徳島県</option>
    <option value="香川県" <?php echo $user['residence'] == '香川県' ? 'selected' : '' ?>>香川県</option>
    <option value="愛媛県" <?php echo $user['residence'] == '愛媛県' ? 'selected' : '' ?>>愛媛県</option>
    <option value="高知県" <?php echo $user['residence'] == '高知県' ? 'selected' : '' ?>>高知県</option>
    <option value="福岡県" <?php echo $user['residence'] == '福岡県' ? 'selected' : '' ?>>福岡県</option>
    <option value="佐賀県" <?php echo $user['residence'] == '佐賀県' ? 'selected' : '' ?>>佐賀県</option>
    <option value="長崎県" <?php echo $user['residence'] == '長崎県' ? 'selected' : '' ?>>長崎県</option>
    <option value="熊本県" <?php echo $user['residence'] == '熊本県' ? 'selected' : '' ?>>熊本県</option>
    <option value="大分県" <?php echo $user['residence'] == '大分県' ? 'selected' : '' ?>>大分県</option>
    <option value="宮崎県" <?php echo $user['residence'] == '宮崎県' ? 'selected' : '' ?>>宮崎県</option>
    <option value="鹿児島県" <?php echo $user['residence'] == '鹿児島県' ? 'selected' : '' ?>>鹿児島県</option>
    <option value="沖縄県" <?php echo $user['residence'] == '沖縄県' ? 'selected' : '' ?>>沖縄県</option>
</select>

                    </td>
                </tr>
            </table>
            <div>
                <input type="submit" value="更新" name="update-button">
            </div>
        </form>
        <div>
            <a href="./logout.php">
                ログアウト
            </a>
        </div>
    </body>
</html>
