<?php $this->assign('content_title', 'リスト登録'); ?>
<?php $this->start('menu_list'); ?>
  <li class="breadcrumb-item"><a href="<?= $this->Url->build(['action' => 'index']); ?>">一覧</a></li>
  <li class="breadcrumb-item active"><span><?= ($data['id'] > 0)? '編集': '新規登録'; ?></span></li>
<?php $this->end(); ?>

<?php $this->start('content_header'); ?>
  <h2 class="card-title"><?= ($data["id"] > 0)? '編集': '新規登録'; ?></h2>
<?php $this->end(); ?>



<!--コンテンツ 開始-->
<?= $this->Form->create($entity, array('type' => 'file', 'context' => ['validator' => 'default'], 'name' => 'fm', 'templates' => $form_templates));?>
<?= $this->Form->input('id', array('type' => 'hidden', 'value' => $entity->id));?>
<?= $this->Form->hidden('position'); ?>
<?= $this->Form->input('sys_cd', array('type' => 'hidden'));?>

<div class="table_edit_area">

  <?= $this->element('edit_form/item-start', ['title' => 'リスト名', 'required' => true]); ?>
<?php if(!empty($query['slug'])): ?>
  <?php if($this->Common->isUserRole('develop')):?>
    <?= $this->Form->input('name',['type' => 'text','maxlength' => 20, 'style' => 'width:250px;', 'value' => $data['name'], 'class' => 'form-control']) ?>
  <?php else:?>
    <?= $this->Form->input('name',['type' => 'text', 'value' => $data['name'], 'readonly' => true,
            'class' => 'form-control-plaintext']) ?>
  <?php endif;?>
<?php else:?>
  <?= $this->Form->input('name',['type' => 'text','maxlength' => 20, 'style' => 'width:250px;', 'class' => 'form-control']) ?>
<?php endif;?>
  <?= $this->element('edit_form/item-end'); ?>

<?php if ($this->Common->isUserRole('develop')): ?>
  <?= $this->element('edit_form/item-start', ['title' => '識別子', 'required' => true]); ?>
      <?= $this->Form->input('slug', array('type' => 'text', 'maxlength' => 40, 'class' => 'form-control'));?>
      <span>※40文字以内で入力してください</span>
      <span>※半角英字で入力してください</span>
  <?= $this->element('edit_form/item-end'); ?>

  <?= $this->element('edit_form/item-start', ['title' => '値', 'required' => true]); ?>
      <?= $this->Form->input('ltrl_cd', array('type' => 'text', 'maxlength' => 10, 'class' => 'form-control'));?>
      <span>※半角数字で入力してください</span>
  <?= $this->element('edit_form/item-end'); ?>
<?php else:?>
  <?= $this->element('edit_form/item-start', ['title' => '識別子', 'required' => true]); ?>
      <?= $this->Form->input('slug', array('type' => 'text', 'maxlength' => 40, 'readonly' => true,
          'class' => 'form-control-plaintext'));?>
  <?= $this->element('edit_form/item-end'); ?>

  <?= $this->element('edit_form/item-start', ['title' => '値', 'required' => true]); ?>
    <?php if (empty($data['id'])): ?>
      <?= $this->Form->input('ltrl_cd', ['type' => 'text', 'maxlength' => '40', 'class' => 'form-control']); ?>
    <?php else: ?>
      <?= $this->Form->input('ltrl_cd', array('type' => 'text', 'maxlength' => 40, 'readonly' => true,
        'class' => 'form-control-plaintext'));?>
    <?php endif; ?>
  <?= $this->element('edit_form/item-end'); ?>
<?php endif;?>

  <?= $this->element('edit_form/item-start', ['title' => '選択肢', 'required' => true]); ?>
      <?= $this->Form->input('ltrl_val', array('type' => 'text', 'maxlength' => 40, 'class' => 'form-control'));?>
  <?= $this->element('edit_form/item-end'); ?>

  <?= $this->element('edit_form/item-start', ['title' => '予備キー']); ?>
      <?= $this->Form->input('ltrl_sub_val', array('type' => 'text', 'maxlength' => 100, 'class' => 'form-control'));?>
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


<script>

$(function() {


})
</script>
<?php $this->end();?>
