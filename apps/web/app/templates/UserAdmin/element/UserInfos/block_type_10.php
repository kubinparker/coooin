<div class="table__row first-dir item_block" id="block_no_<?= h($rownum); ?>" data-sub-block-move="0">
  <div class="table__column">
    <div class="block_header">
      <?= $this->Form->input("info_contents.{$rownum}.id", ['type' => 'hidden', 'value' => h($content['id']), 'id' => "idBlockId_" . h($rownum)]); ?>
      <?= $this->Form->input("info_contents.{$rownum}.position", ['type' => 'hidden', 'value' => h($content['position'])]); ?>
      <?= $this->Form->input("info_contents.{$rownum}.block_type", ['type' => 'hidden', 'value' => h($content['block_type']), 'class' => 'block_type']); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.title", ['type' => 'hidden', 'value' => '']); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.content", ['type' => 'hidden', 'value' => '']); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.image", ['type' => 'hidden', 'value' => '']); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.image_pos", ['type' => 'hidden', 'value' => '']); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.file", ['type' => 'hidden', 'value' => '']); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.file_size", ['type' => 'hidden', 'value' => '0']); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.file_name", ['type' => 'hidden', 'value' => '']); ?>
      <?= $this->Form->input("info_contents.{$rownum}.section_sequence_id", ['type' => 'hidden', 'value' => h($content['section_sequence_id']), 'class' => 'section_no']); ?>
      <?= $this->Form->input("info_contents.{$rownum}._block_no", ['type' => 'hidden', 'value' => h($rownum)]); ?>
    </div>

    <div class="block_title">
      <h4></h4>
    </div>
    
    <?php $waku_csses = [$content['option_value'], $content['option_value2'], ($content['option_value3'] ? 'waku_width_'.$content['option_value3']:'')]; ?>
    <div class="block_content sub-unit__wrap <?= implode(' ', $waku_csses); ?>">
      <div class="editor__table" data-section-no="<?= h($content['section_sequence_id']);?>" data-block-type="<?= h($content['block_type']); ?>">
        
        <div class="table__header">
<?php if (false): ?>
          <div class="table__row">
            <div style="text-align: right;float: right;">
                <span>
                枠スタイル：<?= $this->Form->input("info_contents.{$rownum}.option_value", ['type' => 'select',
                                                                'options' => $waku_style_list,
                                                                'empty' => ['' => '指定なし'],
                                                                'value' => h($content['option_value']),
                                                                'style' => 'background-color:#FFF;',
                                                                'class' => "optionValue",
                                                                'onChange' => 'changeStyle(this, ' . h($rownum) . ', "sub-unit__wrap", "waku_style_");changeSelectStyle(this, ' . h($rownum) . ');'
                                                              ]
                                                            ); ?>
                </span>

                <span id="idWakuColorCol_<?= h($rownum); ?>" style="<?= ($content['option_value'] == 'waku_style_6'?'display: none;':''); ?>">
                色：<?= $this->Form->input("info_contents.{$rownum}.option_value2", ['type' => 'select',
                                                                'options' => $waku_color_list,
                                                                'empty' => ['' => '指定なし'],
                                                                'value' => h($content['option_value2']),
                                                                'style' => 'background-color:#FFF;',
                                                                'class' => "optionValue2",
                                                                'onChange' => 'changeStyle(this, ' . h($rownum) . ', "sub-unit__wrap", "waku_color_");',
                                                                'disabled' => ($content['option_value'] == 'waku_style_6'?true:false),
                                                                'id' => "InfoContents{$rownum}OptionValue2_1"
                                                              ]
                                                            ); ?>　
                </span>

                <span id="idWakuBgColorCol_<?= h($rownum); ?>" style="<?= ($content['option_value'] == 'waku_style_6'?'':'display: none;'); ?>">
                背景色：<?= $this->Form->input("info_contents.{$rownum}.option_value2", ['type' => 'select',
                                                                'options' => $waku_bgcolor_list,
                                                                'empty' => ['' => '指定なし'],
                                                                'value' => h($content['option_value2']),
                                                                'style' => 'background-color:#FFF;',
                                                                'class' => "optionValue2",
                                                                'onChange' => 'changeStyle(this, ' . h($rownum) . ', "sub-unit__wrap", "waku_bgcolor_");',
                                                                'disabled' => ($content['option_value'] == 'waku_style_6'?false:true),
                                                                'id' => "InfoContents{$rownum}OptionValue2_2"
                                                              ]
                                                            ); ?>
                </span>

                <span>
                太さ：<?= $this->Form->input("info_contents.{$rownum}.option_value3", ['type' => 'select',
                                                                'options' => $line_width_list,
                                                                'style' => 'background-color:#FFF;',
                                                                'class' => "optionValue3",
                                                                'onChange' => 'changeStyle(this, ' . h($rownum) . ', "sub-unit__wrap", "waku_width_");',
                                                                'disabled' => ($content['option_value'] == 'waku_style_6' ? true : false)
                                                              ]
                                                            ); ?>
                </span>
            </div>
          </div>
<?php else: ?>
          <?= $this->Form->input("info_contents.{$rownum}.option_value", ['type' => 'hidden', 'value' => 'waku_style_1']); ?>
          <?= $this->Form->input("info_contents.{$rownum}.option_value2", ['type' => 'hidden', 'value' => 'waku_color_6']); ?>
          <?= $this->Form->input("info_contents.{$rownum}.option_value3", ['type' => 'hidden', 'value' => '2']); ?>
<?php endif; ?>
        </div>


        <div class="table__body " data-waku-block-type="<?= $content['block_type'];?>">
          <div class="table__row">
            <div colspan="4" class="td__movable old-style" style="border-bottom: 1px solid #cbcbcb;">ここへブロックを移動できます</div>
          </div>
          
          <div class="table__row">

            <div class="table__column list_table_sub" id="wakuId_<?= h($content['section_sequence_id']);?>" 
            data-section-no="<?= h($content['section_sequence_id']);?>" data-block-type="<?= h($content['block_type']); ?>">

              <?php if (array_key_exists('sub_contents', $content) ): ?>
                <?php foreach ($content['sub_contents'] as $sub_key => $sub_val): ?>
                  <?php $block_type = h($sub_val['block_type']); ?>
                  <?= $this->element("UserInfos/block_type_{$block_type}", ['rownum' => h($sub_val['_block_no']), 'content' => h($sub_val)]); ?>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
          
        </div>

      </div>  
    </div>
  </div>

  <div class="table__column table__column-sub">
    <span style="font-size:0.9rem;"><?= (h($rownum) + 1); ?>.枠</span>
    <div class="table__row-config">
      <?= $this->element('UserInfos/sort_handle2'); ?>
      <?= $this->element('UserInfos/item_block_buttons', ['rownum' => $rownum, 'disable_config' => true]); ?>
    </div>
  </div>
</div>