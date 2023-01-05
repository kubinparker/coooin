<!DOCTYPE html>
<html lang="ja">
  <head>
    <?= $this->element('gtm'); ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="format-detection" content="telephone=no">
    <title>お問い合わせ | <?= $this->element('site_title'); ?></title>
    <meta name="Description" content="<?= $this->element('site_description'); ?>">
    <meta property="og:type" content="website">
    <meta property="og:description" content="<?= $this->element('site_description'); ?>">
    <meta property="og:title" content="お問い合わせ | <?= $this->element('site_title'); ?>">
    <meta property="og:url" content="<?= $this->Url->build('/', ['fullBase' => true]); ?>">
    <meta property="og:image" content="<?= $this->element('site_ogimage'); ?>">
    <meta property="og:locale" content="ja_JP">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:description" content="<?= $this->element('site_description'); ?>">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arvo&amp;family=Noto+Sans+JP:wght@300;400;500;700&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/common.css?v=3e0d7359b807401708b676eb6d6370ef">
    <link rel="stylesheet" href="/assets/css/contact.css?v=66fb11184712150bd3a6f154a52a68d5">

    <script type="application/ld+json">
      {
        "@context": "https://schema.org/",
        "@type": "BreadcrumbList",
        "itemListElement": [{
          "@type": "ListItem",
          "position": 1,
          "item": {
            "@id": "<?= $this->Url->build('/', ['fullBase' => true]); ?>",
            "name": "トップ"
          }
        },{
          "@type": "ListItem",
          "position": 2,
          "item": {
            "@id": "<?= $this->Url->build('/contact/', ['fullBase' => true]); ?>",
            "name": "お問い合わせ"
          }
        }]
      }
    </script>

    <script>
      var bodyWidth = (document.body && document.body.clientWidth) || 0; document.documentElement.style.setProperty('--vw', (bodyWidth / 100) + 'px'); document.documentElement.style.setProperty('--vh', (window.innerHeight / 100) + 'px');

    </script>
  </head>
  <body class="is-login is-note">
    <div class="root page-contact" id="root">

      <?= $this->element('header'); ?>

      <main class="main" id="main">
        <div class="breadcrumb">
          <div class="row">
            <ul class="breadcrumb__list">
              <li><a href="/">TOP</a></li>
              <li><span>お問い合わせ</span>
              </li>
            </ul>
          </div>
        </div>
        <section class="contact">
          <div class="row">
            <h2 class="page-tl">お問い合わせ</h2>
            <div class="contact__head">
              <p class="contact__head--txt">ご入力内容をご確認のうえ、<br class="show_sp">「送信する」ボタンを押してください。</p>
            </div>
            <?= $this->Form->create($contact_form, ['type' => 'post', 'name' => 'fm', 'templates' => $form_templates, 'class' => 'frm frm--confirm']); ?>
            <?= $this->Form->input("token", ['type' => 'hidden', 'value' => $valid['token']]); ?>
            <?= $this->Form->input("action", ['type' => 'hidden', 'value' => 'post', 'id' => 'idAction']); ?>
            <?php foreach ($form_data as $col => $d): ?>
              <?= $this->Form->input($col, ['type' => 'hidden', 'value' => $d['value']]); ?>
            <?php endforeach; ?>
              <div class="frm-row">
                <p class="frm-lb" for="name">名前</p>
                <div class="frm-input">
                  <p><?= h($form_data['name']['value']); ?></p>
                </div>
              </div>
              <div class="frm-row">
                <p class="frm-lb" for="name1">フリガナ</p>
                <div class="frm-input">
                  <p><?= h($form_data['kana']['value']); ?></p>
                </div>
              </div>
              <div class="frm-row">
                <p class="frm-lb">郵便番号</p>
                <div class="frm-input">
                  <p><?= h($form_data['postcode']['value']); ?></p>
                </div>
              </div>
              <div class="frm-row">
                <p class="frm-lb">都道府県</p>
                <div class="frm-input">
                  <p><?= h($form_data['prefecture']['value']); ?></p>
                </div>
              </div>
              <div class="frm-row">
                <p class="frm-lb">市区町村・番地</p>
                <div class="frm-input">
                  <p><?= h($form_data['address1']['value']); ?></p>
                </div>
              </div>
              <div class="frm-row">
                <p class="frm-lb">建物名</p>
                <div class="frm-input">
                  <p><?= h($form_data['address2']['value']); ?></p>
                </div>
              </div>
              <div class="frm-row">
                <p class="frm-lb">TEL</p>
                <div class="frm-input">
                  <p><?= h($form_data['tel']['value']); ?></p>
                </div>
              </div>
              <div class="frm-row">
                <p class="frm-lb">メール<br class="show_pc">アドレス</p>
                <div class="frm-input">
                  <p><?= h($form_data['email']['value']); ?></p>
                </div>
              </div>
              <div class="frm-row">
                <p class="frm-lb">お問い合わせ<br class="show_pc">内容</p>
                <div class="frm-input">
                  <p><?= nl2br(h($form_data['content']['value'])); ?></p>
                </div>
              </div>
              <div class="frm-btn">
                <button class="btn" type="button" onclick="submitBack();"> <span class="icon"><i class="icon__svg icon-arrow"></i></span><span class="txt">戻る</span></button>
                <button class="btn" type="button" onclick="submitPost();"><span class="txt">送信する</span><span class="icon"><i class="icon__svg icon-arrow"></i></span></button>
              </div>
            <?= $this->Form->end(); ?>
          </div>
        </section>
      </main>
      <?= $this->element('footer'); ?>

    </div>
    <script src="/assets/js/vendor.js?v=793a0dd4289ed833a7f82bc0244e4d52" defer></script>
    <script src="/assets/js/runtime.js?v=c6d069924d34828f16343c4f6ee98aa8" defer></script>
    <script src="/assets/js/bundle.js?v=dd511c06f5135bf5a57f52726f30071d" defer></script>
    <script>
      function submitBack() {
        document.getElementById('idAction').value = 'input';
        document.fm.submit();
      }

      function submitPost() {
        document.getElementById('idAction').value = 'post';
        document.fm.submit();
      }
    </script>
  </body>
</html>