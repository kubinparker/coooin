<?php $this->assign('content_title', '追加項目'); ?>
<?php $this->start('menu_list'); ?>
  <li class="breadcrumb-item"><a href="<?= $this->Url->build(['action' => 'index','?' => ['page_id'=>$page_config->id]]); ?>">追加項目</a></li>
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
  
  <?= $this->element('edit_form/item-start', ['title' => '追加項目名(name)', 'required' => true]); ?>
  <?= $this->Form->input('name', array('type' => 'text', 'maxlength' => 40, 'class' => 'form-control'));?>
  <?= $this->element('edit_form/item-end'); ?>

  <?= $this->element('edit_form/item-start', ['title' => '追加項目名(slug)', 'required' => true]); ?>
      <?= $this->Form->input('slug', array('type' => 'text', 'maxlength' => 40, 'class' => 'form-control'));?>
      <span>※英数字で入力してください</span>
  <?= $this->element('edit_form/item-end'); ?>
  
  <?= $this->element('edit_form/item-start', ['title' => '追加項目の注意事項', 'required' => false]); ?>
      <?= $this->Form->input('attention', array('type' => 'text', 'class' => 'form-control'));?>
  <?= $this->element('edit_form/item-end'); ?>
  
  <?= $this->element('edit_form/item-start', ['title' => '入力必須', 'required' => false]); ?>
  <?= $this->Form->input('is_required', ['type' => 'checkbox', 'value' => 1, 'label' => '入力を必須にする', 'hiddenField' => true]); ?>
  <?= $this->element('edit_form/item-end'); ?>
  
  <?= $this->element('edit_form/item-start', ['title' => 'データ型', 'required' => true]); ?>
    <?= $this->Form->select('value_type',$value_type_list, ['class' => 'form-control']); ?>
  <?= $this->element('edit_form/item-end'); ?>

  <?= $this->element('edit_form/item-start', ['title' => '文字数制限', 'required' => false]); ?>
    <?= $this->Form->input('max_length',['type'=>'text','maxlength' => 5, 'style' => 'width:100px;', 'class' => 'form-control']); ?>
  <?= $this->element('edit_form/item-end'); ?>

  <?= $this->element('edit_form/item-start', ['title' => '使用リスト', 'required' => false]); ?>
    <?= $this->Form->select("mst_list_slug", $target_list,[ 'empty' => ['0' => '--'], 'class' => 'form-control' ]) ?>
  <?= $this->element('edit_form/item-end'); ?>

  <?= $this->element('edit_form/item-start', ['title' => '初期値', 'required' => false]); ?>
    <?= $this->Form->input('value_default', array('type' => 'text', 'class' => 'form-control'));?>
  <?= $this->element('edit_form/item-end'); ?>

  <?= $this->element('edit_form/item-start', ['title' => '表示位置', 'required' => false]); ?>
    <?= $this->Form->input('edit_pos', array('type' => 'select', 'options' => $edit_pos_list, 'class' => 'form-control'));?>
  <?= $this->element('edit_form/item-end'); ?>

</div>
<?= $this->Form->end();?>

<div class="btn_area center">
<?php if (!empty($data['id']) && $data['id'] > 0){ ?>
    <a href="#" onclick="document.fm.submit();" class="btn btn-danger btn_post submitButton">変更する</a>
  <?php if ($this->Common->isUserRole('admin')): ?>
    <a href="javascript:kakunin('データを完全に削除します。よろしいですか？','<?= $this->Url->build(array('action' => 'delete', $data['id'], 'content', '?' => $query))?>')" class="btn btn_post btn_delete"><i class="far fa-trash-alt"></i> 削除する</a>
  <?php endif; ?>
<?php }else{ ?>
    <a href="#" onclick="document.fm.submit();" class="btn btn-danger btn_post submitButton">登録する</a>
<?php } ?>
</div>

<div id="deleteArea" style="display: hide;"></div>

<?php $this->start('beforeBodyClose');?>
<link rel="stylesheet" href="/user/common/css/cms.css">


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
