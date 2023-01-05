<?php $this->assign('content_title', "「{$page_config->page_title}」のカテゴリ"); ?>
<?php $this->start('menu_list'); ?>
<li class="breadcrumb-item"><a href="<?= $this->Url->build(['controller' => 'page-configs']); ?>">コンテンツ設定</a></li>
<li class="breadcrumb-item"><a
          href="<?= $this->Url->build(['controller' => 'page-configs', 'action' => 'edit', $page_config->id]); ?>"><?= $page_config->page_title; ?></a>
</li>
<li class="breadcrumb-item active"><span>カテゴリ</span></li>
<?php $this->end(); ?>

<?php
$this->assign('data_count', $data_query->count()); // データ件数
$this->assign('create_url', $this->Url->build(array('action' => 'edit', '?' => $query))); // 新規登録URL
?>

<div class="table_list_area">
  <?php if ($page_config->is_category_multilevel == 1): ?>
    <nav aria-label="breadcrumb">
      <ul class="breadcrumb">
        <li class="breadcrumb-item"><a
                  href="<?= $this->Url->build(['action' => 'index', '?' => ['sch_page_id' => $query['sch_page_id']]]); ?>">ルート</a>
        </li>
        <?php $parent_categories = $parent_category; ?>
        <?php while ($pcat = array_pop($parent_categories)): ?>
          <?php if ($query['parent_id'] == $pcat->id): ?>
            <li class="breadcrumb-item active"><?= $pcat->name; ?></li>
          <?php else: ?>
            <li class="breadcrumb-item"><a
                      href="<?= $this->Url->build(['action' => 'index', '?' => ['sch_page_id' => $query['sch_page_id'], 'parent_id' => $pcat->id]]); ?>"><?= $pcat->name; ?></a>
            </li>
          <?php endif; ?>
        <?php endwhile; ?>
      </ul>
    </nav>
  <?php endif; ?>

  <table class="table table-sm table-hover table-bordered dataTable dtr-inline" style="table-layout: fixed;">
    <colgroup class="show_pc">
      <col style="width: 70px;">
      <col style="width: 100px;">
      <col>

      <?php if ($page_config->is_category == 'Y' && $page_config->is_category_multilevel == 1): ?>
        <col style="width: 170px;">
      <?php endif; ?>
      <col style="width: 150px;">

    </colgroup>

    <thead class="bg-gray">
    <tr>
      <th>掲載</th>
      <th>表示番号</th>
      <th style="text-align:left;">カテゴリ名</th>
      <?php if ($page_config->is_category == 'Y' && $page_config->is_category_multilevel == 1): ?>
        <th>操作</th>
      <?php endif; ?>
      <th>並び順</th>
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
        <td>
          <a name="m_<?= $id ?>"></a>
          <?= $this->element('status_button', ['id' => $id, 'status' => $status]); ?>
        </td>

        <td title="" data-label="表示番号">
          <?= $data->position ?>
        </td>

        <td>
          <?= $this->Html->link($data->name, ['action' => 'edit', $data->id, '?' => $query], ['class' => 'btn btn-light w-100 text-left']) ?>
        </td>

        <?php if ($page_config->is_category == 'Y' && $page_config->is_category_multilevel == 1): ?>
          <td>
            <a href="<?= $this->Url->build(array('controller' => 'categories', 'action' => 'index', 'sch_page_id' => $query['sch_page_id'], 'parent_id' => $data->id)); ?>"
               class="btn btn-success text-white">下層カテゴリ</a>
          </td>
        <?php endif; ?>

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
