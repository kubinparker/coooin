<?php use Cake\Utility\Inflector; ?>
<?php $this->assign('content_title', 'コンテンツ設定'); ?>
<?php $this->start('menu_list'); ?>
  <li class="breadcrumb-item"><a href="<?= $this->Url->build(['action' => 'index']); ?>">コンテンツ設定</a></li>
  <li class="breadcrumb-item active"><span><?= ($data['id'] > 0)? '編集': '新規登録'; ?></span></li>
<?php $this->end(); ?>

<?php $this->start('content_header'); ?>
  <h2 class="card-title"><?= ($data["id"] > 0)? '編集': '新規登録'; ?></h2>
<?php $this->end(); ?>

<!--コンテンツ 開始-->
<?= $this->Form->create($entity, array('type' => 'file', 'context' => ['validator' => 'default'], 'name' => 'fm', 'templates' => $form_templates));?>
<?= $this->Form->input('id', array('type' => 'hidden', 'value' => $entity->id));?>
<?= $this->Form->input('site_config_id', array('type' => 'hidden', 'value' => $site_config->id));?>
<?= $this->Form->input('description', ['type' => 'hidden', 'value' => '']); ?>
<?= $this->Form->input('keywords', ['type' => 'hidden', 'value' => '']); ?>
  <div class="table_edit_area">

    <?= $this->element('edit_form/item-start', ['title' => 'ページタイトル', 'required' => true]); ?>
        <?= $this->Form->input('page_title', array('type' => 'text', 'maxlength' => 100, 'class' => 'form-control'));?>
        <span>※100文字以内で入力してください</span>
    <?= $this->element('edit_form/item-end'); ?>

    <?= $this->element('edit_form/item-start', ['title' => '識別子', 'required' => true]); ?>
          <?= $this->Form->input('root_dir_type', ['type' => 'hidden' ]); ?>
        <div class="home_block">
          <?= $this->Form->input('slug', array('type' => 'text', 'maxlength' => 40, 'class' => 'form-control'));?>
          <span>※40文字以内で入力してください</span>
        </div>
    <?= $this->element('edit_form/item-end'); ?>

    <?= $this->element('edit_form/item-start', ['title' => '親コンテンツ']); ?>
        <?= $this->Form->input('parent_config_id', ['type' => 'select', 'options' => $page_config_list, 'empty' => ['0' => 'なし']]); ?>
    <?= $this->element('edit_form/item-end'); ?>

    <?= $this->element('edit_form/item-start', ['title' => '一覧の表示タイプ']); ?>
        <?= $this->Form->input('list_style', ['type' => 'select',
                                              'options' => $list_style_list,
                                            ]); ?>
    <?= $this->element('edit_form/item-end'); ?>

    <?php if ($this->Common->getCategoryEnabled()): ?>
    <?= $this->element('edit_form/item-start', ['title' => 'カテゴリ機能']); ?>
        <?php if ($this->Common->isUserRole($user_roles['develop'])): ?>
          <?= $this->Form->input('is_category', ['type' => 'radio',
                                                 'options' => ['N' => '使用しない', 'Y' => '使用する']
            ]); ?>
        <?php else: ?>
          <?= ($data['is_category'] == 'Y'?'使用する':'使用しない'); ?>
        <?php endif; ?>
    <?= $this->element('edit_form/item-end'); ?>
    <?php endif; ?>

    <?php if ($this->Common->getCategoryEnabled()): ?>
    <?= $this->element('edit_form/item-start', ['title' => 'カテゴリ複数選択機能']); ?>
      <?php if ($this->Common->isUserRole($user_roles['develop'])): ?>
        <?= $this->Form->input('is_category_multiple', ['type' => 'radio',
                                               'options' => ['0' => '使用しない', '1' => '使用する']
          ]); ?>
      <?php else: ?>
        <?= ($data['is_category_multiple'] == '1'?'使用する':'使用しない'); ?>
      <?php endif; ?>
    <?= $this->element('edit_form/item-end'); ?>
    <?php endif; ?>

    <?php if ($this->Common->getCategoryEnabled()): ?>
    <?= $this->element('edit_form/item-start', ['title' => 'カテゴリの多階層']); ?>
      <?php if ($this->Common->isUserRole($user_roles['develop'])): ?>
        <?= $this->Form->input('is_category_multilevel', ['type' => 'radio',
                                               'options' => ['0' => '使用しない', '1' => '使用する']
          ]); ?>
        最大階層：<?= $this->Form->input('max_multilevel', ['type' => 'number', 'style' => 'width: 60px;']); ?> 0:制限なし
      <?php else: ?>
        <?= ($data['is_category_multilevel'] == '1'?'使用する':'使用しない'); ?>
      <?php endif; ?>
    <?= $this->element('edit_form/item-end'); ?>
    <?php endif; ?>

    <?php if ($this->Common->getCategorySortEnabled()): ?>
    <?= $this->element('edit_form/item-start', ['title' => 'カテゴリ別ソート機能']); ?>
      <?php if ($this->Common->isUserRole($user_roles['develop'])): ?>
        <?= $this->Form->input('is_category_sort', ['type' => 'radio',
                                               'options' => ['N' => '使用しない', 'Y' => '使用する']
          ]); ?>
      <?php else: ?>
        <?= ($data['is_category_sort'] == 'Y'?'使用する':'使用しない'); ?>
      <?php endif; ?>
    <?= $this->element('edit_form/item-end'); ?>
    <?php endif; ?>

    <?php if ($this->Common->getCategoryEnabled()): ?>
    <?= $this->element('edit_form/item-start', ['title' => 'カテゴリの編集権限']); ?>
      <?= $this->Form->input('modified_category_role', ['type' => 'select',
                                             'options' => $role_type_list
        ]); ?>
    <?= $this->element('edit_form/item-end'); ?>
    <?php endif; ?>

    <?= $this->element('edit_form/item-start', ['title' => 'リンクカラー']); ?>
      <?= $this->Form->input('link_color', ['type' => 'color', 'style' => 'height: 30px;']); ?>
    <?= $this->element('edit_form/item-end'); ?>

    <?= $this->element('edit_form/item-start', ['title' => '管理メニュー自動表示']); ?>
      <?php if ($this->Common->isUserRole($user_roles['develop'])): ?>
        <?= $this->Form->input('is_auto_menu', ['type' => 'radio',
                                               'options' => ['0' => '表示しない', '1' => '表示する']
          ]); ?>
      <?php else: ?>
        <?= ($data['is_auto_menu'] == '1'?'表示する':'表示しない'); ?>
      <?php endif; ?>
    <?= $this->element('edit_form/item-end'); ?>

    <div class="form-group row">
      <div class="w-100 btn-light text-center">
        <h4>▼▼▼ callback メソッド一覧 ▼▼▼</h4>
      </div>
    </div>

    <?= $this->element('edit_form/item-start', ['title' => false]); ?>
    <div class="text-center">InfosController.phpに下記メソッド名で作成する</div>
    <?= $this->element('edit_form/item-end'); ?>

    <?= $this->element('edit_form/item-start', ['title' => 'index:cond,containの設定']); ?>
      <span style="color:#daa604;">readingConditionsHook<?= (empty($data['slug']) ? '{識別子}' : Inflector::camelize($data['slug'])); ?></span>
    (&$query, &$cond, &$contain) : <span style="color:#daa604;">void</span>
    <div></div>
    <?= $this->element('edit_form/item-end'); ?>

    <?= $this->element('edit_form/item-start', ['title' => 'index:_list()読込前']); ?>
      <span style="color:#daa604;">prependListsHook<?= (empty($data['slug']) ? '{識別子}' : Inflector::camelize($data['slug'])); ?></span>
    ($query, $options) : <span style="color:#daa604;">$options</span>
    <div></div>
    <?= $this->element('edit_form/item-end'); ?>

    <?= $this->element('edit_form/item-start', ['title' => 'index:_list()読込後']); ?>
      <span style="color:#daa604;">readedIndexHook<?= (empty($data['slug']) ? '{識別子}' : Inflector::camelize($data['slug'])); ?></span>
    () : <span style="color:#daa604;">void</span>
    <div></div>
    <?= $this->element('edit_form/item-end'); ?>

    <?= $this->element('edit_form/item-start', ['title' => '読込時(edit)']); ?>
    <span style="color:#daa604;">prependEditHook<?= (empty($data['slug']) ? '{識別子}' : Inflector::camelize($data['slug'])); ?></span>
    ($page_config, $options) : <span style="color:#daa604;">$options</span>
    <?= $this->element('edit_form/item-end'); ?>

    <?= $this->element('edit_form/item-start', ['title' => '保存前']); ?>
    <span style="color:#daa604;">savingHook<?= (empty($data['slug']) ? '{識別子}' : Inflector::camelize($data['slug'])); ?></span>
    ($page_config, $this->request->getData()) : <span style="color:#daa604;">$this->request->data</span>
    <?= $this->element('edit_form/item-end'); ?>

    <?= $this->element('edit_form/item-start', ['title' => '保存後']); ?>
    <span style="color:#daa604;">savedHook<?= (empty($data['slug']) ? '{識別子}' : Inflector::camelize($data['slug'])); ?></span>
    ($id, $this->request->getData()) : <span style="color:#daa604;">bool </span>(True:commit False:rollback)
    <?= $this->element('edit_form/item-end'); ?>

    <?= $this->element('edit_form/item-start', ['title' => '削除後リダイレクト']); ?>
    <span style="color:#daa604;">deletedRedirectHook<?= (empty($data['slug']) ? '{識別子}' : Inflector::camelize($data['slug'])); ?></span>
    () : <span style="color:#daa604;">$options['redirect']</span>
    <?= $this->element('edit_form/item-end'); ?>

    <?= $this->element('edit_form/item-start', ['title' => 'ステータス変更前']); ?>
    <span style="color:#daa604;">prependEnableHook<?= (empty($data['slug']) ? '{識別子}' : Inflector::camelize($data['slug'])); ?></span>
    ($data, $options) : <span style="color:#daa604;">$options</span>
    <?= $this->element('edit_form/item-end'); ?>

    <?= $this->element('edit_form/item-start', ['title' => 'ステータス変更後']); ?>
    <span style="color:#daa604;">changedStatusHook<?= (empty($data['slug']) ? '{識別子}' : Inflector::camelize($data['slug'])); ?></span>
    ($data) : <span style="color:#daa604;">void</span>
    <?= $this->element('edit_form/item-end'); ?>

    <div class="form-group row">
      <div class="w-100 btn-light text-center">
        <h4>▼▼▼ 管理画面一覧の機能 ▼▼▼</h4>
      </div>
    </div>

    <?= $this->element('edit_form/item-start', ['title' => '並び順']); ?>
      <?= $this->Form->input('disable_position_order', ['type' => 'hidden', 'value' => '0', 'id' => 'idDisablePositionOrderHide']); ?>
      <div class="checkbox icheck-midnightblue">
        <?= $this->Form->input('disable_position_order', ['type' => 'checkbox', 'value' => 1, 'label' => '並び替の表示をしない', 'class' => '']); ?>
      </div>
    <?= $this->element('edit_form/item-end'); ?>

    <?= $this->element('edit_form/item-start', ['title' => 'プレビューボタン']); ?>
      <?= $this->Form->input('disable_preview', ['type' => 'hidden', 'value' => '0', 'id' => 'idDisablePreviewHide']); ?>
      <div class="checkbox icheck-midnightblue">
        <?= $this->Form->input('disable_preview', ['type' => 'checkbox', 'value' => 1, 'label' => 'プレビューボタンを非表示にする', 'hiddenField' => false]); ?>
      </div>
    <?= $this->element('edit_form/item-end'); ?>


  </div>
<?= $this->Form->end();?>

<div class="btn_area center">
<?php if (!empty($data['id']) && $data['id'] > 0){ ?>
    <a href="#" onclick="document.fm.submit();" class="btn btn-danger btn_post submitButton">変更する</a>
  <?php if ($this->Common->isUserRole('admin')): ?>
    <a href="javascript:kakunin('データを完全に削除します。よろしいですか？','<?= $this->Url->build(array('action' => 'delete', $data['id'], 'content'))?>')" class="btn btn_post btn_delete"><i class="far fa-trash-alt"></i> 削除する</a>
  <?php endif; ?>
<?php }else{ ?>
    <a href="#" onclick="document.fm.submit();" class="btn btn-danger btn_post submitButton">登録する</a>
<?php } ?>
</div>

<div id="deleteArea" style="display: hide;"></div>


<!--コンテンツ 終了-->
<?php $this->start('beforeBodyClose');?>
<!--<link rel="stylesheet" href="/user/common/css/cms.css">-->


<script>

$(function() {


})
</script>
<?php $this->end();?>
