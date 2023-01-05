<?php use App\Model\Entity\PageConfigItem; ?>
<?php $this->assign('content_title', $page_config->page_title); ?>
<?php $this->start('menu_list'); ?>
<?php if ($this->elementExists('InfoContents/index-menu-list_' . $page_config->slug)): ?>
  <?= $this->element('InfoContents/index-menu-list_' . $page_config->slug); ?>
<?php else: ?>
  <?php if ($page_config->parent_config_id): ?>
    <li class="breadcrumb-item"><a href="/user_admin/infos/?page_slug=<?= $parent_config->slug; ?>"><?= $parent_config->page_title; ?></a></li>
  <?php endif; ?>
  <li class="breadcrumb-item active"><span><?= h($page_title); ?> </span></li>
<?php endif; ?>
<?php $this->end(); ?>

<!--search_box start-->
<?php $this->assign('search_box_open', 'on'); ?>

<?php $this->start('search_box'); ?>
<?php if ($this->elementExists('InfoContents/index-searchbox-' . $page_config->slug)): ?>
  <?php $this->assign('search_box_title', '商品情報') ?>
  <?= $this->element('InfoContents/index-searchbox-' . $page_config->slug); ?>
<?php else: ?>
<!--多階層カテゴリ-->
<?php if ($this->Common->isCategorySort($page_config->id, $sch_category_id) && $page_config->is_category_multilevel == 1): ?>
  <nav aria-label="breadcrumb">
    <ul class="breadcrumb">
      <?php $category_level = 0;
      $prev_category_id = 0; ?>
      <?php foreach ($category_list as $clist): $category_level++; ?>
        <li class="breadcrumb-item">
          <?= $this->Form->create(null, ['type' => 'get', 'id' => 'fm_search_' . $clist['category']->id, 'style' => 'display:inline-block;']); ?>
          <?= $this->Form->input('sch_page_id', ['type' => 'hidden', 'value' => $sch_page_id]); ?>
          <?= $this->Form->input('sch_category_id', ['type' => 'select',
                  'options' => $clist['list'],
                  'onChange' => 'change_category("fm_search_' . $clist['category']->id . '");',
                  'value' => $clist['category']->id,
                  'empty' => $clist['empty']
          ]); ?>
          <?= $this->Form->end(); ?>
          <span class="btn_area" style="display: inline-block">
        <?php if (!empty($clist['category']->id)): ?>
          <!-- 編集ボタン -->
          <a href="<?= $this->Url->build(array(
                  'controller' => 'categories',
                  'action' => 'edit',
                  $clist['category']->id,
                  '?' => ['sch_page_id' => $clist['category']->page_config_id, 'parent_id' => $clist['category']->parent_category_id, 'redirect' => 'infos']
          )); ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="選択されているカテゴリの編集">
            <i class="fas fa-edit"></i>
          </a>
        <?php endif; ?>
          <!-- 追加ボタン -->
          <a href="<?= $this->Url->build(array(
                  'controller' => 'categories',
                  'action' => 'edit',
                  0,
                  '?' => ['sch_page_id' => $page_config->id, 'parent_id' => $prev_category_id, 'redirect' => 'infos']
          )); ?>" class="btn btn-sm btn-danger" style="margin-left:1px;" data-toggle="tooltip" data-placement="top"
             title="カテゴリを追加します">
            <i class="fas fa-plus"></i>
          </a>

        </span>
        </li>
        <?php $prev_category_id = $clist['category']->id; ?>
      <?php endforeach; ?>
      <?php if (!empty($clist['category']->id) && (!$page_config->max_multilevel || $category_level < $page_config->max_multilevel)): ?>
        <!-- 下層追加ボタン -->
        <li class="breadcrumb-item">
          <span class="btn_area" style="display: inline-block">
            <a href="<?= $this->Url->build(array(
                    'controller' => 'categories',
                    'action' => 'edit',
                    0,
                    '?' => ['sch_page_id' => $clist['category']->page_config_id, 'parent_id' => $clist['category']->id, 'redirect' => 'infos']
            )); ?>" class="btn btn-sm btn-warning" style="margin-left:1px;" data-toggle="tooltip" data-placement="top"
               title="下層カテゴリを追加します">
              <i class="fas fa-plus"></i> 下層カテゴリ
              </a>
            </span>
        </li>
      <?php endif; ?>
    </ul>
  </nav>
<?php else: ?>
  <!-- 多階層カテゴリ以外-->
  <?= $this->Form->create(null, ['type' => 'get', 'id' => 'fm_search', 'url' => ['action' => 'index'], 'class' => '', 'templates' => $form_templates]); ?>

  <div class="table__search">
    <ul class="search__row">
      <?php if ($this->Common->isCategoryEnabled($page_config)): ?>
      <li>
        <div class="search__title">カテゴリ</div>
        <div class="search__column">
          <?php if ($this->Common->isCategorySort($page_config->id, $sch_category_id)): ?>
            <?php if ($page_config->is_category_multilevel == 1): ?>

            <?php else: ?>
              <?= $this->Form->input('sch_category_id', ['type' => 'select',
                      'options' => $category_list,
                // 'onChange' => 'change_category("fm_search");',
                      'value' => $sch_category_id,
                      'class' => 'form-control'
              ]); ?>
            <?php endif; ?>

          <?php else: ?>
            <?= $this->Form->input('sch_category_id', ['type' => 'select',
                    'options' => $category_list,
              // 'onChange' => 'change_category("fm_search");',
                    'value' => $sch_category_id,
                    'empty' => ['0' => '全て'],
                    'class' => 'form-control'
            ]); ?>
          <?php endif; ?>
        </div>
      </li>
      <?php endif; ?>

      <li>
        <div class="search__title">掲載</div>
        <div class="search__column">
          <?= $this->Form->input('sch_status', ['type' => 'select',
                  'options' => ['publish' => '掲載中', 'draft' => '下書き'],
                  'empty' => ['' => '全て'],
                  'value' => $sch_status,
            // 'onChange' => 'change_category("fm_search");',
                  'style' => 'width:100%;',
                  'class' => 'form-control'
          ]); ?>
        </div>
      </li>

      <li>
        <div class="search__title">フリーワード</div>
        <div class="search__column width-2">
          <?= $this->Form->input('sch_words', ['type' => 'text',
                  'value' => $sch_words,
            //  'onChange' => 'change_category("fm_search");',
                  'class' => 'form-control'
          ]); ?>
        </div>
      </li>
    </ul>
  </div>
  <?= $this->Form->end(); ?>

  <div class="btn_area center">
    <button type="button" class="btn btn-secondary mr-2"
            onclick="document.fm_index.submit();"><?= __('条件クリア'); ?></button>
    <button type="button" class="btn btn-primary" onclick="document.fm_search.submit();"><i
              class="fas fa-search"></i> <?= __('検索開始'); ?></button>
  </div>

  <?= $this->Form->create(null, ['type' => 'get', 'name' => 'fm_index']); ?>
    <?= $this->Form->input('page_slug', ['type' => 'hidden', 'value' => $page_config->slug]); ?>
    <?php if (!empty($item)): ?>
      <?= $this->Form->input('item_id', ['type' => 'hidden', 'value' => $item->id]); ?>
    <?php endif; ?>
  <?= $this->Form->end(); ?>
<?php endif; ?>
<?php endif; ?>
<?php $this->end(); ?>
<!--/ search_box end-->

<?php
$this->assign('data_count', $data_query->count()); // データ件数
$this->assign('create_url', $this->Url->build(array('action' => 'edit',0 , '?' => $query))); // 新規登録URL
?>

<style>
  .breadcrumb-item + .breadcrumb-item::before { /*区切り線の変更*/
    /* content:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E"); */
    font-size: 1.5rem;
    content: '>';
  }
</style>


<div class="content_inr">

  <?php if ($is_data): ?>

    <?= $this->element('pagination'); ?>

    <div class="table_list_area">
      <?php if (!empty($page_buttons)): ?>
        <div style="display:flex; justify-content: space-between;">
          <div>
            <?php foreach ($page_buttons['left'] as $ex): ?>
              <a href="<?= $this->Url->build($ex->link); ?>"
                 class="btn btn-warning rounded-pill mr-1"><?= $ex->name; ?></a>
            <?php endforeach; ?>
          </div>
          <div class="btn_area" style="margin-top:10px;justify-content:right;margin-bottom:10px !important;">
            <?php foreach ($page_buttons['right'] as $ex): ?>
              <a href="<?= $this->Url->build($ex->link); ?>"
                 class="btn btn-warning rounded-pill mr-1"><?= $ex->name; ?></a>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
      <table class="table table-sm table-hover table-bordered dataTable dtr-inline">
        <colgroup class="show_pc">
          <col style="width: 75px;">
          <col style="width: 75px;">
          <col style="width: 135px">
          <col>
          <?php foreach ($list_buttons as $ex): ?>
            <col style="width: 100px">
          <?php endforeach; ?>
          <?php if ($this->Common->isViewPreviewBtn($page_config)): ?>
            <col style="width: 75px;">
          <?php endif; ?>
          <?php if ($this->Common->isViewSort($page_config, $sch_category_id)): ?>
            <col style="width: 150px">
          <?php endif; ?>
        </colgroup>

        <thead class="bg-gray">
          <tr>
            <th>掲載</th>
            <?php if ($page_config->slug == 'seminars'): ?>
              <th>状態</th>
            <?php else: ?>
              <th>記事ID</th>
            <?php endif; ?>
            <th>掲載日</th>
            <th style="text-align:left;">
              <?php if ($this->Common->isCategoryEnabled($page_config)) {
                echo 'カテゴリ/';
              } ?>
              <?php if ($this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_MAIN, 'title')): ?>
                <?= $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'title', 'title', 'タイトル'); ?>
              <?php endif; ?>
            </th>
            <?php foreach ($list_buttons as $ex): ?>
              <th style="text-align:left;"><?= $ex->name; ?></th>
            <?php endforeach; ?>

            <?php if ($this->Common->isViewPreviewBtn($page_config)): ?>
              <th style="text-align:left;">確認</th>
            <?php endif; ?>

            <?php if ($this->Common->isViewSort($page_config, $sch_category_id)): ?>
              <th>順序の変更</th>
            <?php endif; ?>

          </tr>
        </thead>

        <?php
        foreach ($data_query->toArray() as $key => $data):
          $data->appendInit();
          $no = sprintf("%02d", $data->id);
          $id = $data->id;
          $scripturl = '';
          if ($data['status'] === 'publish') {
            $status = true;
            $status_text = '掲載中';
            $status_class = 'visible';
            $status_btn_class = 'visi';
          } else {
            $status = false;
            $status_text = '下書き';
            $status_class = 'unvisible';
            $status_btn_class = 'unvisi';
          }

          if ($page_config->is_public_date && $data->status == 'publish') {
            $now = new \DateTime();
            if ($data->start_date->format('Y-m-d') > $now->format('Y-m-d')) {
              // 掲載待ち
              $status_class = 'unvisible';
              $status_text = '掲載待ち';

            } elseif ((!empty($data->end_date) && $data->end_date->format('Y-m-d') != DATE_ZERO) && $data->end_date->format('Y-m-d') < $now->format('Y-m-d')) {
              // 掲載終了
              $status_class = 'unvisible';
              $status_text = '掲載終了';
            }
          }
          $preview_url = "/" . $page_config->slug . "/{$data->id}?preview=on";
          ?>
          <a name="m_<?= $id ?>"></a>
          <tr class="<?= $status_class; ?>" id="content-<?= $data->id ?>">
            <td data-label="記事ID">
              <div class="show_pc">
                <?= $this->element('status_button', ['status' => $status, 'id' => $data->id, 'class' => 'scroll_pos', 'enable_text' => $status_text, 'disable_text' => $status_text]); ?>
              </div>
              <div class="show_sp">
                <?= $data->id; ?>
              </div>
            </td>

            <td data-label="記事ID" class="show_pc">
              <?= $data->id; ?>
            </td>

            <td style="text-align: center;" data-label="掲載日">
              <?= !empty($data->start_date) ? $data->start_date : "&nbsp;" ?>
            </td>

            <td>
              <?php if ($data->index_type == 1) {
                $is_map_txt = '<span class="badge badge-danger">おすすめ</span>';
              } else {
                $is_map_txt = '';
              }; ?>
              <?php if ($this->Common->isCategoryEnabled($page_config)): ?>
                <?php if ($page_config->is_category_multiple == 1): ?>
                  <?= $this->Html->view($this->Common->getInfoCategories($data->id, 'names'), ['before' => '【', 'after' => '】' . $is_map_txt . '<br>']); ?>
                <?php else: ?>
                  <?= $this->Html->view((!empty($data->category->name) ? $data->category->name : '未設定'), ['before' => '【', 'after' => '】' . $is_map_txt . '<br>']); ?>
                <?php endif; ?>
              <?php endif; ?>
              <?= $this->Html->link(h($data->title), ['action' => 'edit', $data->id, '?' => $query], ['escape' => false, 'class' => 'btn btn-light w-100 text-left']) ?>
            </td>

            <?php foreach ($list_buttons as $ex): ?>
              <td>
                <a href="<?= $this->Html->exUrl($ex->link, ['info_id' => $data->id, 'page_slug' => 'event_info']); ?>"
                   class="btn btn-success btn-sm text-white"><?= $ex->name; ?></a>
              </td>
            <?php endforeach; ?>

            <?php if ($this->Common->isViewPreviewBtn($page_config)): ?>
              <td>
                <?= $this->cell('Infos::preview_url', [$page_config->slug, $data, (empty($item) ? null : $item)]); ?>
              </td>
            <?php endif; ?>

            <?php if ($this->Common->isViewSort($page_config, $sch_category_id)): ?>
              <td>
                <ul class="ctrlis">
                  <?php if (!$this->Paginator->hasPrev() && $key == 0): ?>
                    <li class="non">&nbsp;</li>
                    <li class="non">&nbsp;</li>
                  <?php else: ?>
                    <li class="cttop"><?= $this->Html->link('top', array('action' => 'position', $data->id, 'top', '?' => $query), ['class' => 'scroll_pos']) ?></li>
                    <li class="ctup"><?= $this->Html->link('top', array('action' => 'position', $data->id, 'up', '?' => $query), ['class' => 'scroll_pos']) ?></li>
                  <?php endif; ?>

                  <?php if (!$this->Paginator->hasNext() && $key == count($datas) - 1): ?>
                    <li class="non">&nbsp;</li>
                    <li class="non">&nbsp;</li>
                  <?php else: ?>
                    <li class="ctdown"><?= $this->Html->link('top', array('action' => 'position', $data->id, 'down', '?' => $query), ['class' => 'scroll_pos']) ?></li>
                    <li class="ctend"><?= $this->Html->link('bottom', array('action' => 'position', $data->id, 'bottom', '?' => $query), ['class' => 'scroll_pos']) ?></li>
                  <?php endif; ?>
                </ul>
              </td>
            <?php endif; ?>
            <td class="show_sp">
              <?= $this->element('status_button', ['status' => $status, 'id' => $data->id, 'class' => 'scroll_pos', 'enable_text' => $status_text, 'disable_text' => $status_text]); ?>
            </td>
          </tr>

        <?php endforeach; ?>

      </table>

    </div>

  <?php endif; ?>
</div>
<?php $this->start('beforeBodyClose'); ?>
<link rel="stylesheet" href="/admin/common/css/cms.css">
<script>

  $(window).on('load', function () {
    $(window).scrollTop("<?= empty($query['pos']) ? 0 : $query['pos'] ?>");
  })

  function change_category(elm) {
    $("#" + elm).submit();

  }

  $(function () {

    $('.scroll_pos').on('click', function () {
      var sc = window.pageYOffset;
      var link = $(this).attr("href");

      window.location.href = link + "&pos=" + sc;


      return false;
    });

    $('[data-toggle="tooltip"]').tooltip();

  })
</script>
<?php $this->end(); ?>
