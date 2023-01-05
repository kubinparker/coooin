<?php $this->assign('content_title', 'コンテンツ設定'); ?>
<?php $this->start('menu_list'); ?>
  <li class="breadcrumb-item active"><span>コンテンツ設定 </span></li>
<?php $this->end(); ?>

<?php
$this->assign('data_count', $data_query->count()); // データ件数
$this->assign('create_url', $this->Url->build(array('action' => 'edit'))); // 新規登録URL
?>

<div class="table_list_area">
  <table class="table table-sm table-hover table-bordered dataTable dtr-inline" style="table-layout: fixed;">
    <colgroup>
      <col style="width: 70px;">
      <col>
      <col style="width: 150px">
      <!-- <col style="width: 150px"> -->
      <?php if ($this->Common->getCategoryEnabled()): ?>
        <col style="width: 90px;">
      <?php endif; ?>

      <?php if ($this->Common->isUserRole('develop')): ?>
        <col style="width: 90px;">
        <col style="width: 90px;">
        <col style="width: 90px;">
      <?php endif; ?>

      <?php if ($this->Common->isUserRole('admin')): ?>
        <col style="width: 150px">
      <?php endif; ?>
    </colgroup>

    <thead class="bg-gray">
      <tr>
        <th >#</th>
        <th style="text-align:left;">ページ名</th>
        <th>識別子</th>
        <!-- <th>一覧表示タイプ</th> -->
        <?php if ($this->Common->getCategoryEnabled()): ?>
          <th>カテゴリ</th>
        <?php endif; ?>
        <?php if ($this->Common->isUserRole('develop')): ?>
          <th>項目設定</th>
          <th>追加項目</th>
          <th>拡張リンク</th>
        <?php endif; ?>

        <?php if ($this->Common->isUserRole('admin')): ?>
          <th >順序の変更</th>
        <?php endif; ?>
      </tr>
    </thead>

    <tbody>
      <?php
      foreach ($data_query->toArray() as $key => $data):
      $no = sprintf("%02d", $data->id);
      $id = $data->id;
      $scripturl = '';
      $status = true;

      $preview_url = "/" . $this->Common->session_read('data.username') . "/{$data->id}?preview=on";
      ?>

      <tr class="<?= $status ? "visible" : "unvisible" ?>" id="content-<?= $data->id ?>">

        <td title="">
            <a name="m_<?= $id ?>"></a>
          <?= $data->id?>
        </td>

        <td>
          <?= $this->Html->link($data->page_title, ['action' => 'edit', $data->id], ['class' => 'btn btn-light w-100 text-left'])?>
        </td>

        <td>
          <?php if ((int)$data->root_dir_type === 1): ?>
            <?= $site_config->slug; ?>/
          <?php else: ?>
            /<?= $data->slug; ?>/
          <?php endif; ?>
        </td>

        <?php if ($this->Common->getCategoryEnabled()): ?>
          <td>
          <?php if ($data->is_category == 'Y'): ?>
            <div class="btn_area">
              <a href="<?= $this->Url->build(array('controller' => 'categories', '?' => ['sch_page_id' => $data->id])); ?>" class="btn btn-warning btn-sm">カテゴリ</a>
            </div>
          <?php else: ?>
            ---
          <?php endif; ?>
          </td>
        <?php endif; ?>

        <?php if ($this->Common->isUserRole('develop')): ?>
          <td>
            <div class="btn_area">
              <a href="<?= $this->Url->build(array('controller' => 'page-config-items','action' => 'index','?' => ['page_id' => $data->id]));?>" class="btn btn-success btn-sm">項目設定</a>
            </div>
          </td>

          <td>
            <div class="btn_area">
              <a href="<?= $this->Url->build(array('controller' => 'append-items','action' => 'index','?' => ['page_id' => $data->id]));?>" class="btn btn-success btn-sm">追加項目</a>
            </div>
          </td>

          <td>
            <div class="btn_area">
              <a href="<?= $this->Url->build(array('controller' => 'page-config-extensions','action' => 'index','?' => ['page_id' => $data->id]));?>" class="btn btn-success btn-sm">拡張</a>
            </div>
          </td>
        <?php endif; ?>


        <?php if ($this->Common->isUserRole('admin')): ?>
          <td>
            <ul class="ctrlis">
            <?php if(!$this->Paginator->hasPrev() && $key == 0): ?>
              <li class="non">&nbsp;</li>
              <li class="non">&nbsp;</li>
            <?php else: ?>
              <li class="cttop"><?= $this->Html->link('top', array('action' => 'position', $data->id, 'top') )?></li>
              <li class="ctup"><?= $this->Html->link('top', array('action' => 'position', $data->id, 'up') )?></li>
            <?php endif; ?>

            <?php if(!$this->Paginator->hasNext() && $key == $data_query->count()-1): ?>
              <li class="non">&nbsp;</li>
              <li class="non">&nbsp;</li>
            <?php else: ?>
              <li class="ctdown"><?= $this->Html->link('top', array('action' => 'position', $data->id, 'down') )?></li>
              <li class="ctend"><?= $this->Html->link('bottom', array('action' => 'position', $data->id, 'bottom') )?></li>
            <?php endif; ?>
            </ul>
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
