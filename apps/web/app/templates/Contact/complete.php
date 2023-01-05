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
            <h2 class="page-tl page-tl__center">送信完了いたしました。</h2>
            <p class="frm-notice">
               お問い合わせいただきありがとうございます。<br>3営業日以内に返信がない場合、<br class="show_sp">恐れ入りますが、担当までお電話ください。<br>担当TEL:<a href="tel:0280000000">028-000-0000</a><br>受付時間：月〜金 9:00〜17:00（土日を除く）</p>
            <div class="frm-btn"><a class="btn" href="/"> <span class="txt">トップページへ</span><span class="icon"><i class="icon__svg icon-arrow"></i></span></a></div>
          </div>
        </section>
      </main>

      <?= $this->element('footer'); ?>

    </div>
    <script src="/assets/js/vendor.js?v=793a0dd4289ed833a7f82bc0244e4d52" defer></script>
    <script src="/assets/js/runtime.js?v=c6d069924d34828f16343c4f6ee98aa8" defer></script>
    <script src="/assets/js/bundle.js?v=dd511c06f5135bf5a57f52726f30071d" defer></script>
  </body>
</html>