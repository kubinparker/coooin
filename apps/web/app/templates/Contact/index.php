<!DOCTYPE html>
<html lang="ja">
  <head>
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
  <body class="<?= ($this->Common->isMemberLogin() ? 'is-login is-note' : ''); ?>">
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
          <div class="row h-adr">
            <span class="p-country-name" style="display: none;">Japan</span>
            <h2 class="page-tl">お問い合わせ</h2>
            <div class="contact__head">
              <p class="contact__head--txt">こちらはお問い合わせフォームです。必要事項をご入力の上、送信してください。<br>内容を確認の上、担当者より折り返しご連絡させていただきます。</p>
              <p class="contact__head--note note--alert">すべて必須入力です</p>
            </div>
            <?= $this->Form->create($contact_form, ['type' => 'post', 'name' => 'fm', 'class' => 'frm', 'templates' => $form_templates]); ?>
            <?= $this->Form->input('action', ['type' => 'hidden', 'value' => 'confirm']); ?>

              <div class="frm-row">
                <label class="frm-lb" for="name">名前</label>
                <?= $this->Form->input('name', ['type' => 'text', 'class' => 'frm-input']); ?>
              </div>
              <div class="frm-row">
                <label class="frm-lb" for="name1">フリガナ</label>
                <?= $this->Form->input('kana', ['type' => 'text', 'class' => 'frm-input']); ?>
              </div>
              <div class="frm-row">
                <label class="frm-lb">郵便番号</label>
                <div class="frm-code">
                  <?= $this->Form->input('postcode', ['type' => 'text', 'class' => 'frm-input p-postal-code', 'id' => 'idPostcode', 'maxlength' => '8', 'error' => false]); ?>
                  <button class="frm-btn-search btn btn__black" type="button" id="btnPostcode"><span class="txt">住所検索</span><i class="icon__svg icon-search"></i></button>
                  <?= $this->Form->error('postcode'); ?>
                </div>
              </div>
              <div class="frm-row">
                <label class="frm-lb">都道府県</label>
                <div class="c-select">
                  <?= $this->Form->input('prefecture', ['type' => 'select', 'options' => $prefecture_list, 'class' => 'frm__slt p-region']); ?>
                </div>
              </div>
              <div class="frm-row">
                <label class="frm-lb">市区町村・番地</label>
                <?= $this->Form->input('address1', ['type' => 'text', 'class' => 'frm-input p-locality p-street-address', 'maxlength' => '50']); ?>
              </div>
              <div class="frm-row">
                <label class="frm-lb">建物名</label>
                <?= $this->Form->input('address2', ['type' => 'text', 'class' => 'frm-input p-extended-address', 'maxlength' => '50']); ?>
              </div>
              <div class="frm-row">
                <label class="frm-lb">TEL</label>
                <?= $this->Form->input('tel', ['type' => 'text', 'class' => 'frm-input', 'maxlength' => '20', 'id' => 'idTel']); ?>
              </div>
              <div class="frm-row">
                <label class="frm-lb">メール<br class="show_pc">アドレス</label>
                <?= $this->Form->input('email', ['type' => 'text', 'class' => 'frm-input', 'maxlength' => '255']); ?>
              </div>
              <div class="frm-row frm-row__start">
                <label class="frm-lb">お問い合わせ<br class="show_pc">内容</label>
                <?= $this->Form->input('content', ['type' => 'textarea', 'class' => 'frm-input']); ?>
              </div>
              <div class="frm-privacy">
                <?= $this->Form->hidden('chk_privacy', ['value' => '0']); ?>
                <div class="frm-privacy__inner">
                  <?= $this->Form->input('chk_privacy', ['type' => 'checkbox', 'value' => '1', 'hiddenFiend' => false, 'id' => 'privacy', 'error' => false]); ?>
                  <label for="privacy"> <a href="/privacy/">ブライバシーポリシー</a>に同意する</label>
                  <?= $this->Form->error('chk_privacy'); ?>
                </div>
              </div>
              <div class="frm-btn">
                <button class="btn" type="button", onclick="document.fm.submit();"><span class="txt">確認画面へ</span><span class="icon"> <i class="icon__svg icon-arrow"></i></span></button>
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
    <script src="/user/common/js/cleave/cleave.min.js"></script>
    <script src="/user/common/js/cleave/addons/cleave-phone.jp.js"></script>
    <script src="/user/common/js/yubinbango-click.js"></script>
    <script>
      function pageInit() {
        new Cleave('#idPostcode', {
          blocks: [3, 4],
          delimiter: '-',
          uppercase: true
        });

        new Cleave('#idTel', {
          phone: true,
          phoneRegionCode: 'JP',
          delimiter: '-'
        });
      }
      document.addEventListener("DOMContentLoaded", function() {
        pageInit();
      });
    </script>
  </body>
</html>