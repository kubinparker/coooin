<div class="table__row relation-dir" id="block_no_<?= h($rownum); ?>" data-sub-block-move="1">
  <div class="table__column">
<tr>
  <td>
    <div class="sort_handle"></div>
    <?= $this->Form->input("info_contents.{$rownum}.id", ['type' => 'hidden', 'value' => h($content['id']), 'id' => "idBlockId_" . h($rownum)]); ?>
    <?= $this->Form->input("info_contents.{$rownum}.position", ['type' => 'hidden', 'value' => h($content['position'])]); ?>
    <?= $this->Form->input("info_contents.{$rownum}.block_type", ['type' => 'hidden', 'value' => h($content['block_type']), 'class' => 'block_type']); ?>
    <?= $this->Form->input("info_contents.{$rownum}.title", ['type' => 'hidden', 'value' => '']); ?>
    <?= $this->Form->input("info_contents.{$rownum}.image_pos", ['type' => 'hidden', 'value' => '']); ?>
    <?= $this->Form->input("info_contents.{$rownum}.file", ['type' => 'hidden', 'value' => '']); ?>
    <?= $this->Form->input("info_contents.{$rownum}.file_size", ['type' => 'hidden', 'value' => '0']); ?>
    <?= $this->Form->input("info_contents.{$rownum}.file_name", ['type' => 'hidden', 'value' => '']); ?>
    <?= $this->Form->input("info_contents.{$rownum}.section_sequence_id", ['type' => 'hidden', 'value' => h($content['section_sequence_id']), 'class' => 'section_no']); ?>
    <?= $this->Form->input("info_contents.{$rownum}._block_no", ['type' => 'hidden', 'value' => h($rownum)]); ?>
    <?= $this->Form->input("info_contents.{$rownum}.option_value2", ['type' => 'hidden', 'value' => '']); ?>
    <?= $this->Form->input("info_contents.{$rownum}.option_value3", ['type' => 'hidden', 'value' => '']); ?>
  </td>
  <td class="head"></td>
  <td>

    <dl>
      <dt>１．タイトル</dt>
      <dd>
        <?= $this->Form->input("info_contents.{$rownum}.content", ['type' => 'textarea', 'style' => 'height:80px;width:100%;', 'maxlength' => '200']); ?>
      </dd>

      <dt>２．画像</dt>
      <dd>
        <?php $image_column = 'image'; ?>
        <?php if (!empty($content['attaches'][$image_column]['0'])) :?>
        <div>
          <a href="<?= h($content['attaches'][$image_column]['0']);?>" class="pop_image_single">
            <img src="<?= $this->Url->build($content['attaches'][$image_column]['0'])?>" style="width: 300px;">
            <?= $this->Form->input("info_contents.{$rownum}.attaches.{$image_column}.0", ['type' => 'hidden']); ?>
          </a><br >
          <?= $this->Form->input("info_contents.{$rownum}._old_{$image_column}", array('type' => 'hidden', 'value' => h($content[$image_column]))); ?>
        </div>
      <?php endif;?>
        <div>
          <?= $this->Form->input("info_contents.{$rownum}.{$image_column}", array('type' => 'file'));?>
          <div class="remark">※jpeg , jpg , gif , png ファイルのみ</div>
          <div><?= $this->Form->getRecommendSize('InfoContents', 'image', ['before' => '※', 'after' => '']); ?></div>
          <br />
        </div>
      </dd>

      <dt>３．リンク先</dt>
      <dd>
        <?= $this->Form->input("info_contents.{$rownum}.option_value", ['type' => 'text', 'placeholder' => 'http://']); ?>
      </dd>
    </dl>

  </td>

</tr>
  </div>

  <div class="table__column table__column-sub">
    <span style="font-size:0.9rem;"><?= (h($rownum) + 1); ?>.関連記事</span>
    <div class="table__row-config">
      <?= $this->element('UserInfos/sort_handle2'); ?>
      <?= $this->element('UserInfos/item_block_buttons', ['rownum' => $rownum, 'disable_config' => true]); ?>
    </div>
  </div>
</div>
