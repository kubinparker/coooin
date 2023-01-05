<?php $this->assign('content_title', '拡張リンク'); ?>
<?php $this->start('menu_list'); ?>
  <li class="breadcrumb-item"><a href="<?= $this->Url->build(['action' => 'index','?' => ['page_id'=>$page_config->id]]); ?>">拡張リンク</a></li>
  <li class="breadcrumb-item active"><span><?= ($data['id'] > 0)? '編集': '新規登録'; ?></span></li>
<?php $this->end(); ?>

<?php $this->start('content_header'); ?>
  <h2 class="card-title"><?= ($data["id"] > 0)? '編集': '新規登録'; ?></h2>
<?php $this->end(); ?>

<?= $this->Form->create($entity, array('type' => 'file', 'context' => ['validator' => 'default'], 'name' => 'fm', 'templates' => $form_templates));?>
<?= $this->Form->input('id', array('type' => 'hidden', 'value' => $entity->id));?>
<?= $this->Form->input('page_config_id', array('type' => 'hidden', 'value' => $page_config->id));?>
<?= $this->Form->hidden('position'); ?>


<div class="table_edit_area">

  <?= $this->element('edit_form/item-start', ['title' => '種別', 'required' => true]); ?>
    <?= $this->Form->input('type', array('type' => 'select', 'options' => $type_list, 'class' => 'form-control'));?>
  <?= $this->element('edit_form/item-end'); ?>

  <?= $this->element('edit_form/item-start', ['title' => '名前', 'required' => true]); ?>
  <?= $this->Form->input('name', array('type' => 'text', 'maxlength' => 40, 'class' => 'form-control'));?>
  <?= $this->element('edit_form/item-end'); ?>

  <?= $this->element('edit_form/item-start', ['title' => 'リンク', 'required' => true]); ?>
      <?= $this->Form->input('link', array('type' => 'text', 'class' => 'form-control'));?>
  <?= $this->element('edit_form/item-end'); ?>
  
  <?= $this->element('edit_form/item-start', ['title' => 'オプション', 'required' => false]); ?>
      <?= $this->Form->input('option_value', array('type' => 'text', 'class' => 'form-control'));?>
  <?= $this->element('edit_form/item-end'); ?>
  
  <?= $this->element('edit_form/item-start', ['title' => '状態']); ?>
      <?= $this->element('edit_form/item-status'); ?>
  <?= $this->element('edit_form/item-end'); ?>
  
  

  </div>
<?= $this->Form->end();?>

<div class="btn_area center">
<?php if (!empty($data['id']) && $data['id'] > 0){ ?>
    <a href="javascript:void(0)" onclick="document.fm.submit();" class="btn btn-danger btn_post submitButton">変更する</a>
  <?php if ($this->Common->isUserRole('admin')): ?>
    <a href="javascript:kakunin('データを完全に削除します。よろしいですか？','<?= $this->Url->build(array('action' => 'delete', $data['id'], 'content'))?>')" class="btn btn_post btn_delete"><i class="far fa-trash-alt"></i> 削除する</a>
  <?php endif; ?>
<?php }else{ ?>
    <a href="javascript:void(0)" onclick="document.fm.submit();" class="btn btn-danger btn_post submitButton">登録する</a>
<?php } ?>
</div>

<div id="deleteArea" style="display: hide;"></div>


<!--コンテンツ 終了-->
<?php $this->start('beforeBodyClose');?>
<link rel="stylesheet" href="/user/common/css/cms.css">

<script src="/user/common/js/jquery.ui.datepicker-ja.js"></script>
<script src="/user/common/js/cms.js"></script>

<script>
function changeHome() {
  var is_home = $("#idIsHome").prop('checked');
  if (is_home) {
    $("#idSlug").val('');
    $("#idSlug").prop('readonly', true);
    $("#idSlug").css('backgroundColor', "#e9e9e9");
  } else {
    $("#idSlug").prop('readonly', false);
    $("#idSlug").css('backgroundColor', "#ffffff");
  }
}

function changeSlug() {
  var slug = $("#idSlug").val();
  if (slug != "") {
    $("#idIsHome").prop('checked', false);
  }
}

$(function() {

  changeHome();
  
  $("#idIsHome").on('change', function() {
    changeHome();
  });

  $("#idSlug").on('change', function() {
    changeSlug();
  });
})
</script>
<?php $this->end();?>
