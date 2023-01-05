<!doctype html>
<html lang=jp>
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Cms-V6</title>
</head>
<body>

<h1>Cms-V6</h1>

<h2>参考資料</h2>
<ul>
  <li><a href="http://cms-v5-2023.caters.jp/admin_lte/" target="_blank">AdminLte</a></li>
  <li><a href="https://getbootstrap.com/docs/4.6/getting-started/introduction/" target="_blank">Bootstrap4</a></li>
</ul>

<h2>お問い合わせ</h2>
<div>
  <a href="/contact/">フォームはこちら</a>
</div>

<h2>お知らせ</h2>

<div>
  <ul>
    <?php foreach ($infos as $info): ?>
    <li>
      <div><span><?= $info->start_at->format('Y.m.d'); ?></span> <?= $info->title; ?></div>
    </li>
    <?php endforeach; ?>
  </ul>
</div>
</body>
</html>