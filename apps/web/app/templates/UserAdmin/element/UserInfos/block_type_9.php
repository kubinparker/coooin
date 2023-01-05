<div class="table__row first-dir item_block" id="block_no_<?= h($rownum); ?>" data-sub-block-move="1">
  <div class="table__column">
    <div class="block_header">
      <?= $this->Form->input("info_contents.{$rownum}.id", ['type' => 'hidden', 'value' => h($content['id']), 'id' => "idBlockId_" . h($rownum)]); ?>
      <?= $this->Form->input("info_contents.{$rownum}.position", ['type' => 'hidden', 'value' => h($content['position'])]); ?>
      <?= $this->Form->input("info_contents.{$rownum}.block_type", ['type' => 'hidden', 'value' => h($content['block_type']), 'class' => 'block_type']); ?>
      <?= $this->Form->input("info_contents.{$rownum}.title", ['type' => 'hidden', 'value' => '']); ?>
      <?= $this->Form->input("info_contents.{$rownum}.content", ['type' => 'hidden', 'value' => '']); ?>
      <?= $this->Form->input("info_contents.{$rownum}.image", ['type' => 'hidden', 'value' => '']); ?>
      <?= $this->Form->input("info_contents.{$rownum}.image_pos", ['type' => 'hidden', 'value' => '']); ?>
      <?= $this->Form->input("info_contents.{$rownum}.file", ['type' => 'hidden', 'value' => '']); ?>
      <?= $this->Form->input("info_contents.{$rownum}.file_size", ['type' => 'hidden', 'value' => '0']); ?>
      <?= $this->Form->input("info_contents.{$rownum}.file_name", ['type' => 'hidden', 'value' => '']); ?>
      <?= $this->Form->input("info_contents.{$rownum}.section_sequence_id", ['type' => 'hidden', 'value' => h($content['section_sequence_id']),  'class' => 'section_no']); ?>
      <?= $this->Form->input("info_contents.{$rownum}._block_no", ['type' => 'hidden', 'value' => h($rownum)]); ?>
    </div>
    
    <div class="block_title"></div>

    <div class="block_content">
<?php if (false): ?>
      <div style="text-align: right;">
        スタイル：<?= $this->Form->input("info_contents.{$rownum}.option_value", ['type' => 'select',
                                                                              'options' => $line_style_list,
                                                                              'empty' => ['' => '指定なし'],
                                                                              'value' => $content['option_value'],
                                                                              'escape' => false,
                                                                              'onChange' => 'changeStyle(this,' . h($rownum) . ', "style_target", "line_style_")'
                                                                            ]); ?>　
        色：<?= $this->Form->input("info_contents.{$rownum}.option_value2", ['type' => 'select',
                                                                              'options' => $line_color_list,
                                                                              'empty' => ['' => '指定なし'],
                                                                              'value' => $content['option_value2'],
                                                                              'escape' => false,
                                                                              'onChange' => 'changeStyle(this,' . h($rownum) . ', "style_target", "line_color_")'
                                                                            ]); ?>　
        太さ：<?= $this->Form->input("info_contents.{$rownum}.option_value3", ['type' => 'select',
                                                                'options' => $line_width_list,
                                                                'empty' => ['' => '指定なし'],
                                                                'value' => h($content['option_value3']),
                                                                'onChange' => 'changeWidth(this, ' . h($rownum) . ', "style_target", "border-width");'
                                                              ]
                                                            ); ?>
      </div>
<?php endif; ?>
      <hr class="style_target <?= $content['option_value']; ?>" style="<?= $content['option_value2']; ?>">
    </div>

    <div class="modal fade" id="popupOption_<?= h($rownum); ?>" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">オプション設定</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body table_area">
            class：<?= $this->Form->input("info_contents.{$rownum}.option_value", ['type' => 'text', 'value' => $content['option_value']]); ?>
            style：<?= $this->Form->input("info_contents.{$rownum}.option_value2", ['type' => 'text', 'value' => $content['option_value2']]); ?>
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">保存する</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="table__column table__column-sub">
    <span style="font-size:0.9rem;"><?= (h($rownum) + 1); ?>.区切り線</span>
    <div class="table__row-config">
      <?= $this->element('UserInfos/sort_handle2'); ?>
      <?= $this->element('UserInfos/item_block_buttons', ['rownum' => $rownum, 'disable_config' => false]); ?>
    </div>
  </div>
</div>