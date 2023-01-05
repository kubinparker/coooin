<?php use App\Model\Entity\PageConfigItem; ?>

<?php if($this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_BLOCK, 'all')): ?>
<div class="table__footer">
  <div class="editor__table-row">
    <button type="button" class="btn w-100 btnSelectBlockSection append_button" data-toggle="modal" data-target="#popupSelectBlock" data-layout-no="" style="">
      <i class="fas fa-plus" aria-hidden="true"></i>
    </button>
  </div>
</div>


<!-- ブロック選択ダイアログ -->
<div class="modal fade" id="popupSelectBlock" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">パーツを選択してください</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body table_area">

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header bg-gray-dark">
                <h2 class="card-title">ブロック追加</h2>
                <?= $this->Form->input('content_count', ['type' => 'hidden', 'value' => h($content_count), 'id' => 'idContentCount']); ?>
              </div>

              <div class="card-body row select_block_area">
                <?php foreach ($block_type_list as $k => $v): ?>
                  <div class="col-6 col-md-3 mb-2">
                    <button type="button" class="block_button btn btn-primary" onClick="addBlock(<?= h($k); ?>); return false;" data-dismiss="modal"><?= h($v); ?></button>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>

        <?php if($this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_BLOCK, 'all') && $this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_SECTION, 'all')): ?>
          <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header bg-gray-dark">
                    <h2 class="card-title">枠ブロック追加</h2>
                  </div>

                  <div class="card-body row select_block_area">
                    <?php foreach ($block_type_waku_list as $k => $v): ?>
                      <div class="col-6 col-md-3 mb-2">
                        <button type="button" class="block_button btn btn-primary" onClick="addBlock(<?= h($k); ?>); return false;" data-dismiss="modal"><?= h($v); ?></button>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            </div>
        <?php endif; ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
      </div>
    </div>
  </div>
</div>
<?php endif;?>