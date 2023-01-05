<?php $this->assign('content_title', '追加入力項目管理'); ?>
<?php $this->start('menu_list'); ?>
  <li class="breadcrumb-item"><a href="<?= $this->Url->build(['controller' => 'page-configs', 'action' => 'index']); ?>">コンテンツ設定</a></li>
  <li class="breadcrumb-item active"><span>追加項目一覧</span></li>
<?php $this->end(); ?>

<?php
$this->assign('data_count', $data_query->count()); // データ件数
$this->assign('create_url', $this->Url->build(array('action' => 'edit', '?' => ['page_id' => $page_config->id]))); // 新規登録URL
$this->assign('create_label', '新規登録'); //新規登録ボタンの表示名（指定なければ「新規登録」）
?>

<!--search_box start-->
<!--search_box end-->
<div class="table_list_area">
  <table class="table table-sm table-hover table-bordered dataTable dtr-inline" style="table-layout: fixed;">
    <colgroup>
      <col style="width: 60px;">
      <col>
      <col style="width: 200px">
      <col style="width: 150px">
      <col style ="width:80px;">
      <col style="width: 150px">
    </colgroup>


    <thead class="bg-gray">
      <tr>
        <th >ID</th>
        <th style="text-align:left;">入力項目名</th>
        <th>データ型</th>
        <th>slug</th>
        <th >詳細</th>
        <th >順序の変更</th>
      </tr>
    </thead>

    <tbody>
      <?php
foreach ($data_query->toArray() as $key => $data):
$no = sprintf("%02d", $data->id);
$id = $data->id;
$scripturl = '';
$status = true;
?>
            <a name="m_<?= $id ?>"></a>
            <tr class="<?= $status ? "visible" : "unvisible" ?>" id="content-<?= $data->id ?>">

              <td title="">
                <?= $data->id?>
              </td>

              <td>
                <?= $this->Html->link($data->name, ['action' => 'edit', $data->id,'?' => ['page_id'=>$page_config->id]], ['class' => 'btn btn-light w-100 text-left'])?>
              </td>

              <td>
                <!-- todoデータ型 -->
                <?= $value_type_list[$data->value_type]; ?>
              </td>

              <td>
                <?= $data->slug; ?>
              </td>
              
              <td>
                <?= $this->Html->link('編集', ['action' => 'edit', $data->id,'?' => ['page_id'=>$page_config->id]],['class' =>'btn btn-success text-white'])?>
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