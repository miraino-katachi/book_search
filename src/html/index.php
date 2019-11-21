<?php
    // サニタイジング
    $post = array();
    foreach ($_POST as $k => $v) {
        $post[$k] = htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
    }

    // ISBNを取得
    $isbn = '';
    if (isset($post['isbn'])) {
        $isbn = preg_replace('/[^0-9]/', '', $post['isbn']);
    }

    $resultCode = 0;    // 取得結果コード
    $errMsg = "";       // エラーメッセージ
    $info = array();    // 取得情報

    if ($isbn) {
        // Google Books APIのURL
        $url = "https://www.googleapis.com/books/v1/volumes?q=isbn:$isbn";

        // 習得したJSONデータ
        $json = file_get_contents($url);

        // JSONデータをデコードして連想配列に変換する
        // （第2引数をtrueにすることによって、連想配列で返却される）
        $src = json_decode($json, true);

        if (is_null($src)) {
            // デコードに失敗したとき
            $resultCode = 0;
            $errMsg = "情報の取得に失敗しました。";
        } elseif($src["totalItems"] == 0) {
            // 検索結果がなかったとき
            $resultCode = -1;
            $errMsg = "該当の書籍がありませんでした";
        } else {
            // 検索結果が見つかったとき
            $resultCode = 1;
            $info = $src['items'][0]['volumeInfo'];
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>書籍検索</title>
<link rel="stylesheet" href="./css/normalize.css">
<link rel="stylesheet" href="./css/main.css">
</head>
<body>
<div class="container">
<h1>書籍検索</h1>

<form action="./" method="post">
    ISBN：<input type="text" name="isbn">
    <input type="submit" value="検索">
    <input type="reset" value="リセット">
</form>
<?php
    // 結果コードにより、表示切り替え
    switch ($resultCode) {
        case 0:
        case -1:
            echo '<p class="caution">'.$errMsg.'</p>';
            break;
        case 1:
?>
<table>
    <caption>検索結果</caption>
    <tr>
        <th class="header">ISBN</th>
        <td class="data"><?php if (isset($info['industryIdentifiers'][0]['identifier'])) echo $info['industryIdentifiers'][0]['identifier']; ?></td>
        <?php if (isset($info['imageLinks']['thumbnail'])): ?>
        <td class="image" rowspan="6">
            <img src="<?= $info['imageLinks']['thumbnail'] ?>" alt="<?= $info['title'] ?>">
        </td>
        <?php endif ?>
    </tr>
    <tr>
        <th class="header">タイトル</th>
        <td class="data"><?php if (isset($info['title'])) echo $info['title']; ?></td>
    </tr>
    <tr>
        <th class="header">サブタイトル</th>
        <td class="data"><?php if (isset($info['subtitle'])) echo $info['subtitle']; ?></td>
    </tr>
    <tr>
        <th class="header">著者</th>
        <td class="data"><?php if (isset($info['authors'][0])) echo $info['authors'][0]; ?></td>
    </tr>
    <tr>
        <th class="header">出版日</th>
        <td class="data"><?php if (isset($info['publishedDate'])) echo $info['publishedDate']; ?></td>
    </tr>
    <tr>
        <th class="header">説明</th>
        <td class="data"><?php if (isset($info['description'])) echo $info['description']; ?></td>
</table>

<pre>
<!-- <?php var_dump($src) ?> -->
</pre>

<?php
    }
?>

</div>
</body>
</html>
