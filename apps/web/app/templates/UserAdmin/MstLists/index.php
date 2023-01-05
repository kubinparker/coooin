<?php $this->assign('content_title', 'リスト一覧'); ?>
<?php $this->start('menu_list'); ?>
  <li class="breadcrumb-item active"><span>リスト一覧 </span></li>
<?php $this->end(); ?>

<?php
$this->assign('data_count', $data_query->count()); // データ件数
if (empty($query['slug'])) {
  $this->assign('create_url', ''); // 新規登録URL
} else {
  $this->assign('create_url', $this->Url->build(array('action' => 'edit', '?' => $query))); // 新規登録URL
}
$this->assign('create_label', 'リストへ追加'); //新規登録ボタンの表示名（指定なければ「新規登録」）
?>

<!--search_box start-->
<?php $this->assign('search_box_open', 'on'); ?>
<?php $this->start('search_box'); ?>
  <?= $this->Form->create(null, ['type' => 'get', 'id' => 'fm_search', 'url' => ['action' => 'index'], 'class' => '', 'templates' => $form_templates]); ?>
    <div class="table__search">
      <ul class="search__row">
        <li>
          <div class="search__title">システム区分</div>
          <div class="search__column">
            <?php if ($this->Common->isUserRole('develop')): ?>
              <?= $this->Form->select('sys_cd',$sys_list,['onChange' => 'change_category();','value' => $query['sys_cd']]) ?>
            <?php else: ?>
              <?= $this->Form->input('sys_cd', ['type' => 'hidden', 'value' => \App\Model\Entity\MstList::LIST_FOR_USER]); ?>
              <?= $sys_list[\App\Model\Entity\MstList::LIST_FOR_USER]; ?>
            <?php endif; ?>
          </div>
        </li>

        <li>
          <div class="search__title">リスト</div>
          <div class="search__column">
          <?= $this->Form->input('slug', ['type' => 'select',
                                                           'options' => $slug_list,
                                                           'onChange' => 'change_category();',
                                                           'value' => $query['slug'],
                                                           'empty' => '選択してください'
                                                         ]); ?>
          </div>
        </li>
      </ul>
    </div>
  <?= $this->Form->end(); ?>

  <?php if ($this->Common->isUserRole('develop')): ?>
  <div class="btn_area center">
    <a href="<?= $this->Url->build(['action' => 'edit', 0, '?' => ['sys_cd' => $query['sys_cd']]]); ?>" class="btn btn-danger rounded-pill mr-1">新規登録</a>
  </div>
  <?php endif; ?>
<?php $this->end(); ?>
<!--/ search_box end-->

<div class="input-group">
  <span class="input-group-text mr-1">識別子</span>
  <div class=""><?= $this->Form->input('slug', ['type' => 'text', 'readonly' => true, 'value' => $query['slug'], 'class' => 'form-control-plaintext']); ?></div>
</div>

<div class="table_list_area">
  <table class="table table-sm table-hover table-bordered dataTable dtr-inline" style="table-layout: fixed;">
    <colgroup>
      <col style="width: 70px;">
      <col style="width: 100px;">
      <col style="width: 120px;">
      <col>
      <col style="width: 150px;">
      <col style="width: 70px;">
      <col style="width: 150px">

    </colgroup>

    <thead class="bg-gray">
      <tr>
        <th >#</th>
        <th style="text-align:left;">リスト名</th>
        <th style="text-align:left;">値</th>
        <th style="text-align:left;">項目</th>
        <th style="text-align:left;">予備キー</th>
        <th style="text-align:left;">詳細</th>
        <th >順序の変更</th>
      </tr>
    </thead>

    <tbody>
      <?php
      foreach ($data_query->toArray() as $key => $data):
      $no = sprintf("%02d", $data->id);
      $id = $data->id;
      $status = ($data->status === 'publish' ? true : false);

      ?>

      <tr class="<?= $status ? "visible" : "unvisible" ?>" id="content-<?= $data->id ?>">


        <td title="">
          <?= $data->id?>
        </td>

        <td>
          <?= h($data->name) ?>
        </td>

        <td>
          <?= h($data->ltrl_cd) ?>
        </td>

        <td>
          <?= $this->Html->link($data->ltrl_val, ['action' => 'edit', $data->id, '?' => $query], ['class' => 'btn btn-light w-100 text-left'])?>
        </td>

        <td>
          <?= h($data->ltrl_sub_val) ?>
        </td>

        <td>
        <?= $this->Html->link("編集", ['action' => 'edit', $data->id], ['class' => 'btn btn-success'])?>
        </td>


        <?php if ($this->Common->isUserRole('admin')): ?>
          <td>
            <?= $this->element('position', ['key' => $key, 'data' => $data, 'data_query' => $data_query]); ?>
          </td>
        <?php endif; ?>

      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php $this->start('beforeBodyClose');?>
<link rel="stylesheet" href="/admin/common/css/cms.css">
<script>
function change_category() {
  $("#fm_search").submit();
}
$(function () {



})
</script>
<?php $this->end();?>
