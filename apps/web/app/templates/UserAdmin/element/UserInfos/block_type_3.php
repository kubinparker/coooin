<div class="table__row first-dir item_block" id="block_no_<?= h($rownum); ?>" data-sub-block-move="1">
  <div class="table__column">
    <div class="block_header">
      <?= $this->Form->input("info_contents.{$rownum}.id", ['type' => 'hidden', 'value' => h($content['id']), 'id' => "idBlockId_" . h($rownum)]); ?>
      <?= $this->Form->input("info_contents.{$rownum}.position", ['type' => 'hidden', 'value' => h($content['position'])]); ?>
      <?= $this->Form->input("info_contents.{$rownum}.block_type", ['type' => 'hidden', 'value' => h($content['block_type']), 'class' => 'block_type']); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.title", ['type' => 'hidden', 'value' => '']); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.image_pos", ['type' => 'hidden', 'value' => '']); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.file", ['type' => 'hidden', 'value' => '']); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.file_size", ['type' => 'hidden', 'value' => '0']); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.file_name", ['type' => 'hidden', 'value' => '']); ?>
      <?= $this->Form->input("info_contents.{$rownum}.section_sequence_id", ['type' => 'hidden', 'value' => h($content['section_sequence_id']), 'class' => 'section_no']); ?>
      <?= $this->Form->input("info_contents.{$rownum}._block_no", ['type' => 'hidden', 'value' => h($rownum)]); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.option_value2", ['type' => 'hidden', 'value' => '']); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.option_value3", ['type' => 'hidden', 'value' => '']); ?>
    </div>
    
    <div class="block_title">
      
    </div>

    <div class="block_content">
      <?php $image_column = 'image'; ?>

      <label type="button" class="btn btn-light w-100 edit__image-button" style="min-height: 80px;">


        <?php if (!empty($content['attaches'][$image_column]['0'])) :?>
        <div class="thumbnail">
          <img
            src="<?= $this->Url->build($content['attaches'][$image_column]['0'])?>"
            style="max-width:500px; max-height: 400px;">
        </div>
        <?= $this->Form->input("info_contents.{$rownum}._old_{$image_column}", array('type' => 'hidden', 'value' => h($content[$image_column]))); ?>
        <?php else: ?>
        <div class="thumbnail">
          <div>
            <i class="fas fa-plus"></i>
            <i class="far fa-image"></i>
          </div>
        </div>
        <div>
            <div class="remark">※jpeg , jpg , gif , png ファイルのみ</div>
            <div><?= $this->Form->getRecommendSize('InfoContents', 'image', ['before' => '※', 'after' => '']); ?></div>
            <div>※ファイルサイズ５MB以内</div>
            <br />
          </div>
        <?php endif; ?>

        <?= $this->Form->input("info_contents.{$rownum}.{$image_column}", array('type' => 'file', 'class' => 'attaches image', 'accept' => '.jpeg, .jpg, .png, .gif'));?>
      </label>
      
    
          


    </div>

    <div class="modal fade" id="popupOption_<?= h($rownum); ?>"
      tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">オプション設定</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body table_area">
            <div></div>
            <dl>
              <?php if (false) :?>
              <dt>画像</dt>
              <dd>
                <div>
                  <?= $this->Form->input("info_contents.{$rownum}.{$image_column}", array('type' => 'file', 'class' => 'attaches'));?>
                  <div class="remark">※jpeg , jpg , gif , png ファイルのみ</div>
                  <div><?= $this->Form->getRecommendSize('PageContents', 'image', ['before' => '※', 'after' => '']); ?>
                  </div>
                  <div>※ファイルサイズ５MB以内</div>
                  <br />
                </div>
              </dd>
              <?php endif; ?>

              <dt style="margin-top: 10px;">リンク先
                <?= $this->Form->input("info_contents.{$rownum}.option_value", ['type' => 'select',
                    'options' => $link_target_list,
                    'value' => $content['option_value']
                ]); ?>
              </dt>
              <dd>
                <?= $this->Form->input("info_contents.{$rownum}.content", ['type' => 'text', 'maxlength' => '255', 'placeholder' => 'http://']); ?>

              </dd>
            </dl>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">保存する</button>
          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="table__column table__column-sub">
    <span style="font-size:0.9rem;"><?= (h($rownum) + 1); ?>.画像</span>
    <div class="table__row-config">
      <?= $this->element('UserInfos/sort_handle2'); ?>
      <?= $this->element('UserInfos/item_block_buttons', ['rownum' => $rownum, 'disable_config' => false]); ?>
    </div>
  </div>
</div>