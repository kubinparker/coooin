<?php use App\Model\Entity\PageConfigItem; ?>
<?php use App\Model\Entity\AppendItem; ?>

<?php $this->assign('content_title', $page_title); ?>
<?php $this->start('menu_list'); ?>
<?php if ($this->elementExists('InfoContents/edit-menu-list_' . $page_config->slug)): ?>
  <?= $this->element('InfoContents/edit-menu-list_' . $page_config->slug); ?>
<?php else: ?>
    <li class="breadcrumb-item"><a href="<?= $this->Url->build(['action' => 'index', '?' => ['sch_page_id' => $page_config->id]]); ?>"><?= h($page_title) ?></a></li>
    <li class="breadcrumb-item active"><span><?= ($data['id'] > 0)? '編集': '新規登録'; ?></span></li>
<?php endif; ?>
<?php $this->end(); ?>

<?php if ($this->elementExists('InfoContents/content-prepend-' . $page_config->slug)): ?>
<?php $this->start('content_prepend'); ?>
  <?= $this->element('InfoContents/content-prepend-' . $page_config->slug); ?>
<?php $this->end(); ?>
<?php endif; ?>

<?php $this->start('content_header'); ?>
  <h2 class="card-title"><?= ($data["id"] > 0)? '編集': '新規登録'; ?></h2>
<?php $this->end(); ?>

<?= $this->Form->create($entity, array('type' => 'file', 'context' => ['validator' => 'default'], 'name' => 'fm', 'templates' => $form_templates));?>
  <?= $this->Form->hidden('position'); ?>
  <?= $this->Form->input('id', array('type' => 'hidden', 'value' => h($entity->id)));?>
  <?= $this->Form->input('page_config_id', ['type' => 'hidden']); ?>
  <?= $this->Form->input('meta_keywords', ['type' => 'hidden']); ?>
  <?= $this->Form->input('postMode', ['type' => 'hidden', 'value' => 'save', 'id' => 'idPostMode']); ?>
<?php if (!empty($item)): ?>
<?= $this->Form->input('item_id', ['type' => 'hidden', 'value' => $item->id]); ?>
<?php endif; ?>
  <input type="hidden" name="MAX_FILE_SIZE" value="<?= (1024 * 1024 * 5); ?>">
  <div class="table_edit_area">

    <?= $this->element('UserInfos/append_items/append_item_block', ['pos' => 1]); ?>

    <!--記事番号-->
    <?= $this->element('edit_form/item-start', ['title' => '記事番号', 'required' => false]); ?>
      <?= ($data["id"])? sprintf('No. %04d', h($data["id"])) : "新規" ?>
    <?= $this->element('edit_form/item-end'); ?>
    <?= $this->element('UserInfos/append_items/append_item_block', ['pos' => 2]); ?>

    <!--親ページ設定-->
    <?php if($page_config->parent_config_id): ?>
      <?= $this->element('edit_form/item-start', ['title' => $parent_config->page_title, 'required' => false]); ?>
          <?= h($parent_info->title); ?>
          <?= $this->Form->input('parent_info_id', ['type' => 'hidden', 'value' => $parent_info->id]); ?>
      <?= $this->element('edit_form/item-end'); ?>
    <?php endif;?>

    <!--掲載期間-->
    <?php if ($page_config->is_public_date): ?>
      <?= $this->element('edit_form/item-start', ['title' => '掲載期間', 'required' => true]); ?>
        <?= $this->Form->input('start_at', array('type' => 'text', 'class' => 'datepicker', 'data-auto-date' => '1', 'default' => date('Y-m-d'), 'style' => 'width: 120px;'));?> ～
        <?= $this->Form->input('end_at', array('type' => 'text', 'class' => 'datepicker', 'style' => 'width: 140px;'));?>
        <span>※開始日のみ必須。終了日を省略した場合は下書きにするまで掲載されます。</span>
      <?= $this->element('edit_form/item-end'); ?>
    <?php else:?>
      <?= $this->element('edit_form/item-start', ['title' => '掲載日', 'required' => true]); ?>
        <div class="input-group">
          <div class="input-group-prepend">
            <?= $this->Form->input('_start_at_date', array('type' => 'text', 'class' => 'datepicker form-control', 'data-auto-date' => '1', 'default' => date('Y-m-d'), 'style' => 'width: 140px;'));?>
          </div>
          <div class="input-group-append">
            <?= $this->Form->time('_start_at_time', array('type' => 'time',
//               'class' => 'datepicker',
//                    'data-auto-date' => '1',
//                    'default' => date('H:i'),
//                    'style' => 'width: 120px;',
               'format' => 'H:i',
               'class' => 'form-control',

            ));?>
          </div>
        </div>

      <?= $this->element('edit_form/item-end'); ?>
    <?php endif;?>
    <?= $this->element('UserInfos/append_items/append_item_block', ['pos' => 3]); ?>

    <!--タイトル-->
    <?php if($this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_MAIN, 'title')): ?>
      <?php $_title = $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'title', 'title', 'タイトル'); ?>
      <?php $_sub_tilte = $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'title', 'sub_title', ''); ?>
      <?= $this->element('edit_form/item-start', ['title' => $_title, 'sub_title' => $_sub_tilte, 'required' => true]); ?>
        <?= $this->Form->input('title', array('type' => 'text', 'maxlength' => 200, 'class' => 'form-control'));?>
        <span>※200文字以内で入力してください</span>
      <?= $this->element('edit_form/item-end'); ?>
    <?php endif;?>
    <?= $this->element('UserInfos/append_items/append_item_block', ['pos' => 5]); ?>

    <!--カテゴリ-->
    <?php if($this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_MAIN, 'category')): ?>
      <?php $_title = $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'category', 'title', 'カテゴリ'); ?>
      <?php $_sub_tilte = $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'categry', 'sub_title', ''); ?>
      <?php if ($this->Common->isCategoryEnabled($page_config) && !$this->Common->isCategoryEnabled($page_config, 'category_multiple')): ?>
        <!-- 単カテゴリ -->
        <?= $this->element('edit_form/item-start', ['title' => $_title, 'sub_title' => $_sub_tilte, 'required' => true]); ?>
        <?= $this->Form->input('category_id', ['type' => 'select', 'options' => $category_list, 'empty' => ['0' => '選択してください'], 'class' => 'form-control']); ?>
        <?= $this->element('edit_form/item-end'); ?>
      <?php elseif ($this->Common->isCategoryEnabled($page_config) && $this->Common->isCategoryEnabled($page_config, 'category_multiple')): ?>
        <!-- 複数カテゴリ -->
        <?= $this->element('edit_form/item-start', ['title' => $_title, 'sub_title' => $_sub_tilte, 'required' => true]); ?>
        <div class="list-group" style="height: 200px; overflow:auto;">
          <?php foreach ($category_list as $cat_id => $cat_name): ?>
            <label class="list-group-item">
              <?= $this->Form->input("info_categories.{$cat_id}",
                  [
                    'type' => 'checkbox',
                    'value' => $cat_id,
                    'checked' => in_array((int)$cat_id, $info_category_ids, false),
                    'class' => 'form-check-input me-1',
                    'hiddenField' => false
                  ]); ?>
              <?= $cat_name; ?>
            </label>
          <?php endforeach; ?>
        </div>
        <?= $this->element('edit_form/item-end'); ?>
      <?php endif;?>
    <?php endif;?>
    <?= $this->element('UserInfos/append_items/append_item_block', ['pos' => 4]); ?>

    <!--概要-->
    <?php if($this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_MAIN, 'notes')): ?>
      <?php $_title = $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'notes', 'title', '概要'); ?>
      <?php $_sub_tilte = $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'notes', 'sub_title', '<div>(一覧と詳細に表示)</div>'); ?>
      <?= $this->element('edit_form/item-start', ['title' => $_title, 'sub_title' => $_sub_tilte]); ?>
        <?= $this->Form->input('notes', ['type' => 'textarea', 'maxlength' => '1000', 'class' => 'form-control']); ?>
        <span>※1000文字以内で入力してください</span>
      <?= $this->element('edit_form/item-end'); ?>
    <?php endif;?>
    <?= $this->element('UserInfos/append_items/append_item_block', ['pos' => 6]); ?>

    <!-- image -->
    <?php if($this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_MAIN, 'image')): ?>
      <?php $image_column = 'image'; ?>
      <?php $_title = $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'image', 'title', 'メイン画像'); ?>
      <?php $_sub_tilte = $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'image', 'sub_title', '<div>(一覧と詳細に表示)</div>'); ?>
      <?= $this->element('edit_form/item-start', ['title' => $_title, 'sub_title' => $_sub_tilte]); ?>
        <div class="edit_image_area">
          <ul>
            <?php if (!empty($data['attaches'][$image_column]['0'])) :?>
            <li>
              <a href="<?= $data['attaches'][$image_column]['0'];?>" class="pop_image_single">
                <img src="<?= $this->Url->build($data['attaches'][$image_column]['0'])?>" style="width: 300px;">
                <?= $this->Form->input("attaches.{$image_column}.0", ['type' => 'hidden']); ?>
              </a><br >
              <?= $this->Form->input("_old_{$image_column}", array('type' => 'hidden', 'value' => h($data[$image_column]))); ?>
              <div class="btn_area" style="width: 300px;">
                <a href="javascript:kakunin('画像を削除します。よろしいですか？','<?= $this->Url->build(array('action' => 'delete', $data['id'], 'image', $image_column, '?' => $query)) ?>')" class="btn_delete">画像の削除</a>
              </div>
            </li>
          <?php endif;?>

            <li>
              <?= $this->Form->input($image_column, array('type' => 'file','accept' => 'image/jpeg,image/png,image/gif', 'id' => 'idMainImage', 'class' => 'attaches'));?>
              <div class="remark">※jpeg , jpg , gif , png ファイルのみ</div>
                <div><?= $this->Form->getRecommendSize('Infos', 'image', ['before' => '※', 'after' => '']); ?></div>
              <div>※ファイルサイズ５MB以内</div>
              <br />
            </li>

          </ul>
          <?= $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'image', 'memo', ''); ?>
        </div>
      <?= $this->element('edit_form/item-end'); ?>
    <?php endif;?>
    <?= $this->element('UserInfos/append_items/append_item_block', ['pos' => 7]); ?>

    <!--画像の注釈-->
    <?php if($this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_MAIN, 'image_title')): ?>
      <?php $_title = $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'image_title', 'title', '画像の注釈'); ?>
      <?php $_sub_tilte = $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'image_title', 'sub_title', ''); ?>
      <?= $this->element('edit_form/item-start', ['title' => $_title, 'sub_title' => $_sub_tilte]); ?>
        <?= $this->Form->input('image_title', ['type' => 'textarea', 'maxlength' => '200', 'class' => 'form-control']); ?>
        <span>※200文字以内で入力してください</span>
        <span>※改行は反映されません</span>
      <?= $this->element('edit_form/item-end'); ?>
    <?php endif;?>
    <?= $this->element('UserInfos/append_items/append_item_block', ['pos' => 8]); ?>

    <!--TOP表示-->
    <?php if($this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_MAIN, 'index_type')): ?>
      <?php $_title = $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'index_type', 'title', 'TOP表示'); ?>
      <?php $_sub_tilte = $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'index_type', 'sub_title', ''); ?>
      <?= $this->element('edit_form/item-start', ['title' => $_title, 'sub_title' => $_sub_tilte]); ?>
        <?= $this->Form->input('index_type', ['type' => 'radio', 'options' => ['0' => '設定しない', '1' => '設定する']]); ?>
      <?= $this->element('edit_form/item-end'); ?>
    <?php endif;?>
    <?= $this->element('UserInfos/append_items/append_item_block', ['pos' => 9]); ?>

    <!-- ハッシュタグ -->
    <?php if($this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_MAIN, 'hash_tag')): ?>
      <?php $_title = $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'hash_tag', 'title', 'ハッシュタグ'); ?>
      <?php $_sub_tilte = $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'hash_tag', 'sub_title', ''); ?>
      <?= $this->element('edit_form/item-start', ['title' => $_title, 'sub_title' => $_sub_tilte]); ?>
        <div>
          <?= $this->Form->input('add_tag', [
              'type' => 'text',
              'style' => 'width: 200px;',
              'maxlength' => '40',
              'id' => 'idAddTag',
              'placeholder' => 'タグを入力',
              'class' => 'form-control'
          ]); ?>
          <span class="btn_area" style="display: inline;">
            <a href="#" class="btn_confirm small_menu_btn btn_orange" id="btnAddTag">追加</a>
            <a href="#" class="btn_confirm small_menu_btn" id="btnListTag">タグリスト</a>
          </span>
          <div>※タグを入力して追加ボタンで追加またはタグリストから選択する事もできます。</div>
          <div>※重複した場合は１つにまとめられます。</div>
        </div>
        <div>
          <ul id="tagArea">
            <?php $info_tag_count = 0; ?>
            <?php if (!empty($entity->info_tags)): ?>
              <?php $info_tag_count = count($entity->info_tags); ?>
              <?php foreach ($entity->info_tags as $k => $tag): ?>
                <?= $this->element('UserInfos/tag', ['num' => $k, 'tag' => $tag->tag->tag]); ?>
              <?php endforeach; ?>
            <?php endif; ?>
          </ul>
        </div>
      <?= $this->element('edit_form/item-end'); ?>
    <?php else: ?>
      <?php $info_tag_count = 0;?>
    <?php endif;?>

    <!--追加項目-->
    <?= $this->element('UserInfos/append_items/append_item_block', ['pos' => 0]); ?>

    <!--metaタグ-->
    <?php if($this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_MAIN, 'meta')): ?>
      <div class="form-group row">
        <div class="w-100 btn-light text-center">
          <button class="btn w-100 btn-light" type="button" data-toggle="collapse" data-target="#optionMetaItem" aria-expanded="false">
            <span>metaタグ</span> <i class="fas fa-angle-down"></i>
          </button>
        </div>
      </div>
    <?php endif; ?>

    <div id="optionMetaItem" class="collapse">

      <?php if($this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_MAIN, 'meta')): ?>
        <?= $this->element('edit_form/item-start', ['title' => 'meta', 'subTitle' => '（ページ説明文）']); ?>
          <?= $this->Form->input('meta_description', ['type' => 'textarea', 'maxlength' => '200', 'class' => 'form-control']); ?>
          <span class="attention">※200文字まで</span>
        <?= $this->element('edit_form/item-end'); ?>
      <?php endif; ?>

      <?php if($this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_MAIN, 'meta')): ?>
        <?= $this->element('edit_form/item-start', ['title' => 'meta', 'subTitle' => '（キーワード）']); ?>
          <?php for($i=0;$i<5;$i++): ?>
            <div><?= ($i + 1); ?>.<?= $this->Form->input("keywords.{$i}", ['type' => 'text', 'maxlength' => '20', 'class' => 'form-control']); ?></div>
          <?php endfor; ?>
          <span class="attention">※各20文字まで</span>
        <?= $this->element('edit_form/item-end'); ?>
      <?php endif; ?>

    </div>

    <?= $this->element('edit_form/item-start', ['title' => '記事表示']); ?>
      <?= $this->element('edit_form/item-status', ['enable_text' => '掲載する', 'disable_text' => '下書き']); ?>
    <?= $this->element('edit_form/item-end'); ?>

  </div>

  <!--コンテンツブロック-->
  <div class="editor__table mb-5">
    <div id="blockArea" class="table__body list_table">
    <?php if (!empty($contents) && array_key_exists('contents', $contents)): ?>
    <?php foreach ($contents['contents'] as $k => $v): ?>
      <?php if ($v['block_type'] != 13): ?>
      <?= $this->element("UserInfos/block_type_{$v['block_type']}", ['rownum' => h($v['_block_no']), 'content' => h($v)]); ?>
      <?php endif; ?>
    <?php endforeach; ?>
    <?php endif; ?>
    </div>

    <?= $this->element('UserInfos/dlg_select_block'); ?>
  </div>

  <div id="blockWork"></div>

  <div id="deleteArea" style="display: hide;"></div>
<?= $this->Form->end(); ?>

<div class="btn_area center">
<?php if (!empty($data['id']) && $data['id'] > 0){ ?>
    <a href="javascript:void(0)" onclick="document.fm.submit();" class="btn btn-danger btn_post submitButton">変更する</a>
  <?php if ($this->Common->isUserRole('admin')): ?>
    <a href="javascript:kakunin('データを完全に削除します。よろしいですか？','<?= $this->Url->build(array('action' => 'delete', $data['id'], 'content', null, '?' => $query))?>')" class="btn btn_post btn_delete"><i class="far fa-trash-alt"></i> 削除する</a>
  <?php endif; ?>
<?php }else{ ?>
    <a href="javascript:void(0)" onclick="document.fm.submit();" class="btn btn-danger btn_post submitButton">登録する</a>
<?php } ?>
</div>



<?php $this->start('beforeBodyClose');?>
<!--<link rel="stylesheet" href="/user/common/css/cms.css">-->
<script src="/user/common/js/jquery.ui.datepicker-ja.js"></script>
<script src="/user/common/js/cms.js"></script>
<script src="/user/common/js/ckeditor/ckeditor.js"></script>
<script src="/user/common/js/ckeditor/translations/ja.js"></script>

<?= $this->Html->script('/user/common/js/system/pop_box'); ?>
<script>
var rownum = 0;
var tag_num = <?= $info_tag_count; ?>;
var max_row = 100;
var pop_box = new PopBox();
var out_waku_list = <?= json_encode($out_waku_list); ?>;
var block_type_waku_list = <?= json_encode($block_type_waku_list); ?>;
var block_type_relation = 14;
var block_type_relation_count = 0;
var max_file_size = <?= (1024 * 1024 * 5); ?>;
var total_max_size = <?= (1024 * 1024 * 30); ?>;
var form_file_size = 0;
var page_config_id = <?= $page_config->id; ?>;
var is_old_editor = <?= ($editor_old == 1 ? 1 : 0); ?>;
</script>
<?= $this->Html->script('/user/common/js/info/base'); ?>
<?= $this->Html->script('/user/common/js/info/edit'); ?>

<?php $this->end(); ?>
