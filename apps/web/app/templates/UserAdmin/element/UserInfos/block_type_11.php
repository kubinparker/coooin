<div class="table__row first-dir item_block" id="block_no_<?= h($rownum); ?>" data-sub-block-move="0">
  <div class="table__column">
<tr>
  <td>
    <div class="sort_handle"></div>
    <?= $this->Form->input("info_contents.{$rownum}.id", ['type' => 'hidden', 'value' => h($content['id']), 'id' => "idBlockId_" . h($rownum)]); ?>
    <?= $this->Form->input("info_contents.{$rownum}.position", ['type' => 'hidden', 'value' => h($content['position'])]); ?>
    <?= $this->Form->input("info_contents.{$rownum}.block_type", ['type' => 'hidden', 'value' => h($content['block_type']), 'class' => 'block_type']); ?>
    <?= $this->Form->input("info_contents.{$rownum}.title", ['type' => 'hidden', 'value' => '']); ?>
    <?= $this->Form->input("info_contents.{$rownum}.file", ['type' => 'hidden', 'value' => '']); ?>
    <?= $this->Form->input("info_contents.{$rownum}.file_size", ['type' => 'hidden', 'value' => '0']); ?>
    <?= $this->Form->input("info_contents.{$rownum}.file_name", ['type' => 'hidden', 'value' => '']); ?>
    <?= $this->Form->input("info_contents.{$rownum}.section_sequence_id", ['type' => 'hidden', 'value' => h($content['section_sequence_id']), 'class' => 'section_no']); ?>
    <?= $this->Form->input("info_contents.{$rownum}._block_no", ['type' => 'hidden', 'value' => h($rownum)]); ?>
    <?= $this->Form->input("info_contents.{$rownum}.option_value", ['type' => 'hidden', 'value' => '']); ?>
    <?= $this->Form->input("info_contents.{$rownum}.option_value2", ['type' => 'hidden', 'value' => '']); ?>
  </td>

  <td colspan="2">
    <div class="sub-unit__wrap">
      <h4></h4>

            
            <?php $image_column = 'image'; ?>
            <dl style="border:1px solid #cbcbcb;padding: 10px;">
              <dt>１．回り込み位置</dt>
              <dd>
              <?= $this->Form->input("info_contents.{$rownum}.image_pos", ['type' => 'radio',
                                                                        'value' => h($content['image_pos']),
                                                                        'options' => ['left' => '<img src="/user/common/images/cms/align_left.gif">', 'right' => '<img src="/user/common/images/cms/align_right.gif">'],
                                                                        'separator' => '　',
                                                                        'escape' => false,
                                                                        'defaultValue' => 'left'
                                                                      ]); ?>
              </dd>

              <dt>２．画像</dt>
              <dd>
              <?php if (!empty($content['attaches'][$image_column]['0'])) :?>
              <div>
                <a href="<?= h($content['attaches'][$image_column]['0']);?>" class="pop_image_single">
                  <img src="<?= $this->Url->build($content['attaches'][$image_column]['0'])?>" style="width: 300px; float: left;">
                  <?= $this->Form->input("info_contents.{$rownum}.attaches.{$image_column}.0", ['type' => 'hidden']); ?>
                </a><br >
                <?= $this->Form->input("info_contents.{$rownum}._old_{$image_column}", array('type' => 'hidden', 'value' => h($content[$image_column]))); ?>
              </div>
            <?php endif;?>

              <div>
                <?= $this->Form->input("info_contents.{$rownum}.{$image_column}", array('type' => 'file', 'class' => 'attaches'));?>
                <div class="remark">※jpeg , jpg , gif , png ファイルのみ</div>
                <div><?= $this->Form->getRecommendSize('InfoContents', 'image', ['before' => '※', 'after' => '']); ?></div>
                <div>※ファイルサイズ５MB以内</div>
                <br />
              </div>
              <div style="clear: both;"></div>
              </dd>
            
              <dt style="margin-top: 10px;">３．画像リンク</dt>
              <dd>
                <?= $this->Form->input("info_contents.{$rownum}.option_value3", ['type' => 'text',
                                                                                      'style' => 'width:500px;',
                                                                                      'value' => $content['option_value3'],
                                                                                      'placeholder' => 'http://'
                                                                                    ]); ?>

              </dd>
              
              <dt style="margin-top: 10px;">４．本文</dt>
              <dd>
                <?= $this->Form->input("info_contents.{$rownum}.content", ['type' => 'textarea', 'class' => 'editor']); ?>
              </dd>
            </dl>
    </div>
  </td>
</tr>
  </div>

  <div class="table__column table__column-sub">
    <span style="font-size:0.9rem;"><?= (h($rownum) + 1); ?>.画像回り込み用</span>
    <div class="table__row-config">
      <?= $this->element('UserInfos/sort_handle2'); ?>
      <?= $this->element('UserInfos/item_block_buttons', ['rownum' => $rownum, 'disable_config' => true]); ?>
    </div>
  </div>
</div>