<div class="table__row first-dir item_block" id="block_no_<?= h($rownum); ?>" data-sub-block-move="1">
  <div class="table__column">
    <div class="block_header">
      <?= $this->Form->input("info_contents.{$rownum}.id", ['type' => 'hidden', 'value' => h($content['id']), 'id' => "idBlockId_" . h($rownum)]); ?>
      <?= $this->Form->input("info_contents.{$rownum}.position", ['type' => 'hidden', 'value' => h($content['position'])]); ?>
      <?= $this->Form->input("info_contents.{$rownum}.block_type", ['type' => 'hidden', 'value' => h($content['block_type']), 'class' => 'block_type']); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.title", ['type' => 'hidden', 'value' => '']); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.content", ['type' => 'hidden', 'value' => '']); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.image", ['type' => 'hidden', 'value' => '']); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.image_pos", ['type' => 'hidden', 'value' => '']); ?>
      <?= $this->Form->input("info_contents.{$rownum}.section_sequence_id", ['type' => 'hidden', 'value' => h($content['section_sequence_id']), 'class' => 'section_no']); ?>
      <?= $this->Form->input("info_contents.{$rownum}._block_no", ['type' => 'hidden', 'value' => h($rownum)]); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.option_value", ['type' => 'hidden', 'value' => '']); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.option_value2", ['type' => 'hidden', 'value' => '']); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.option_value3", ['type' => 'hidden', 'value' => '']); ?>
    </div>
    
    <div class="block_title">
      
    </div>

    <div class="block_content">
      <?php $_column = 'file'; ?>
        <ul>
        <?php if (!empty($content['attaches'][$_column]['0'])) :?>
          <li class="<?= h($content['attaches'][$_column]['extention']); ?>">
            <?= $this->Form->input("info_contents.{$rownum}.file_name", ['type' => 'text', 'maxlength' => '50', 'style' => 'width:300px;', 'placeholder' => '添付ファイル']); ?>.<?= h($content['file_extension']); ?>
            <?= $this->Form->input("info_contents.{$rownum}.file_size", ['type' => 'hidden', 'value' => h($content['file_size'])]); ?>
            <div><?= $this->Html->link('ダウンロード', $content['attaches'][$_column]['0'], array('target' => '_blank'))?></div>
          </li>
          <?= $this->Form->input("info_contents.{$rownum}._old_{$_column}", array('type' => 'hidden', 'value' => h($content[$_column]))); ?>
          <?= $this->Form->input("info_contents.{$rownum}.file_extension", ['type' => 'hidden']); ?>
        <?php endif;?>

          <li>
            <?= $this->Form->input("info_contents.{$rownum}.file", array('type' => 'file', 'class' => 'attaches'));?>
            <div class="remark">※PDF、Office(.doc, .docx, .xls, .xlsx)ファイルのみ</div>
            <div>※ファイルサイズ５MB以内</div>
          </li>
        </ul>
    </div>
  </div>

  <div class="table__column table__column-sub">
    <span style="font-size:0.9rem;"><?= (h($rownum) + 1); ?>.ファイル添付</span>
    <div class="table__row-config">
      <?= $this->element('UserInfos/sort_handle2'); ?>
      <?= $this->element('UserInfos/item_block_buttons', ['rownum' => $rownum, 'disable_config' => true]); ?>
    </div>
  </div>
</div>