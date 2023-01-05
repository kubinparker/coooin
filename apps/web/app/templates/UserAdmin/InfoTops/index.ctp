<?php $this->assign('content_title', "「{$page_config->page_title}」のトップ表示リスト"); ?>
<?php $this->start('menu_list'); ?>
<li class="breadcrumb-item">
  <a href="<?= $this->Url->build(['controller' => 'infos', 'action' => 'index', '?' => ['page_slug' => $page_config->slug]]); ?>"><?= $page_config->page_title; ?></a>
</li>
<li class="breadcrumb-item active"><span>トップ表示</span></li>
<?php $this->end(); ?>

<?php
$this->assign('data_count', $data_query->count()); // データ件数
$this->assign('create_url', false); // 新規登録URL
?>

<div class="table_list_area">

  <table class="table table-sm table-hover table-bordered dataTable dtr-inline" style="table-layout: fixed;">
    <colgroup class="show_pc">
      <col style="width: 75px;">
      <col>
      <col style="width: 150px;">

    </colgroup>

    <thead class="bg-gray">
    <tr>
      <th>ID</th>
      <th style="text-align:left;">タイトル</th>
      <th>並び順</th>
    </tr>
    </thead>

    <tbody>
    <?php
    foreach ($data_query->toArray() as $key => $data):
      $no = sprintf("%02d", $data->id);
      $id = $data->id;
      $status = true;
      ?>

      <tr class="<?= $status ? "visible" : "unvisible" ?>" id="content-<?= $data->id ?>">

        <td title="">
          <a name="m_<?= $id ?>"></a>
          <?= $data->info_id ?>
        </td>

        <td>
          <?= $this->Html->link($data->info->title, ['controller' => 'infos', 'action' => 'edit', $data->info_id, '?' => ['page_slug' => $query['slug']]], ['class' => 'btn btn-light w-100 text-left']) ?>
        </td>

        <td>
          <?= $this->element('position', ['key' => $key, 'data' => $data, 'data_query' => $data_query]); ?>
        </td>


      </tr>

    <?php endforeach; ?>
    </tbody>
  </table>

</div>


<?php $this->start('beforeBodyClose'); ?>
<link rel="stylesheet" href="/admin/common/css/cms.css">
<script>
  function change_category() {
    $("#fm_search").submit();

  }

  $(function () {


  })
</script>
<?php $this->end(); ?>
