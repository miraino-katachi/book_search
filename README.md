# book_search
## 【PHP】書籍検索

Google Books APIを使った書籍検索システムです。下記のことを練習できます。

- APIからJSONを受け取る
- 受け取ったJSONをデコードする

## 課題の仕様書について

doc/書籍検索.pdf

を御覧ください。

## 学習期間の目安（3.5日）

学習時間は1日4時間を想定しています。

1. 仕様書の把握 → 0.5日
2. Google Maps APIに対して問い合わせをした結果がどのような形で返ってくるのか、ブラウザからURLを入力して確認する → 0.5日
3. フォームからISBNコードを送信する、受け取ったISBNコードで Google Maps APIに問い合わせができるようにする → 1日
4. Google Books APIから受け取ったJSON形式のデータをデコードして連想配列に変換する → 0.5日
5. 連想配列の要素を表示できるようにする → 1日

## HTMLの雛形

doc/mock/

以下にあるファイルをご利用ください。

HTMLフィルの拡張子を「.php」に変えて、PHPのソースを埋め込むと、効率よく学習していただけます。

## サンプルソース

src/html

以下に、サンプルのソースを置いています。

## そのほか

ソースコードの中に、コメントで「ヒント」をたくさん書いてあります。 書き方がわからないときは、ソースコードを見て確認しましょう。
