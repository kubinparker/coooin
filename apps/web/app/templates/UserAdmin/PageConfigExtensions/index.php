<?php $this->assign('content_title', '拡張リンク'); ?>
<?php $this->start('menu_list'); ?>
  <li class="breadcrumb-item"><a href="<?= $this->Url->build(['controller' => 'page-configs', 'action' => 'index']); ?>">コンテンツ設定</a></li>
  <li class="breadcrumb-item active"><span>拡張リンク</span></li>
<?php $this->end(); ?>

<?php
$this->assign('data_count', $data_query->count()); // データ件数
$this->assign('create_url', $this->Url->build(array('action' => 'edit', '?' => ['page_id' => $page_config->id]))); // 新規登録URL
$this->assign('create_label', '新規登録'); //新規登録ボタンの表示名（指定なければ「新規登録」）
?>

<div class="table_list_area">
  <table class="table table-sm table-hover table-bordered dataTable dtr-inline" style="table-layout: fixed;">
    <colgroup>
      <col style="width: 90px;">
      <col style="width: 150px">
      <col style="width: 200px;">
      <col>
      <col style="width: 150px">
    </colgroup>

    <thead class="bg-gray">
      <tr>
        <th>状態</th>
        <th style="text-align:left;">種別</th>
        <th>名前</th>
        <th>リンク</th>
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


      <td >
        <?= $this->element('status_button', ['status' => $status, 'id' => $data->id, 'enable_text' => __('有効'), 'disable_text' => __('無効')]); ?>
      </td>


      <td>
        <?= $this->Html->link($data->type, ['action' => 'edit', $data->id, '?' => $query], ['class' => 'btn btn-light w-100 text-left'])?>
      </td>

      <td>
        <?= $this->Html->link($data->name, ['action' => 'edit', $data->id, '?' => $query], ['class' => 'btn btn-light w-100 text-left'])?>
      </td>

      <td>
        <?= $data->link; ?>
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