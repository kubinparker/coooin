<div class="table__row first-dir item_block" id="block_no_<?= h($rownum); ?>" data-sub-block-move="1">
  <div class="table__column">
    <div class="block_header">
      <?= $this->Form->input("info_contents.{$rownum}.id", ['type' => 'hidden', 'value' => h($content['id']), 'id' => "idBlockId_" . h($rownum)]); ?>
      <?= $this->Form->input("info_contents.{$rownum}.position", ['type' => 'hidden', 'value' => h($content['position'])]); ?>
      <?= $this->Form->input("info_contents.{$rownum}.block_type", ['type' => 'hidden', 'value' => h($content['block_type']), 'class' => 'block_type']); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.image", ['type' => 'hidden', 'value' => '']); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.image_pos", ['type' => 'hidden', 'value' => '']); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.file", ['type' => 'hidden', 'value' => '']); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.file_size", ['type' => 'hidden', 'value' => '0']); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.file_name", ['type' => 'hidden', 'value' => '']); ?>
      <?= $this->Form->input("info_contents.{$rownum}.section_sequence_id", ['type' => 'hidden', 'value' => h($content['section_sequence_id']), 'class' => 'section_no']); ?>
      <?= $this->Form->input("info_contents.{$rownum}._block_no", ['type' => 'hidden', 'value' => h($rownum)]); ?>
      <?php // echo $this->Form->input("info_contents.{$rownum}.option_value3", ['type' => 'hidden', 'value' => '']); ?>
    </div>

    <div class="block_title"></div>

    <div class="block_content">
      <div class="btn_area" style="display: block;">
        <button type="button" id="idButtonTitle_<?= h($rownum); ?>"
          class="btn <?= (empty($content['option_value']) ? 'btn-primary' : $content['option_value']); ?>"
          data-toggle="modal"
          data-target="#popupOption_<?= h($rownum); ?>"><?= (empty($content['title']) ? 'ボタン名を設定' : $content['title']); ?></button>
      </div>

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
            <dl>
              <dt>１．ボタン名</dt>
              <dd>
                <?= $this->Form->input("info_contents.{$rownum}.title", [
                                                    'type' => 'text',
                                                    'style' => 'width: 100%;',
                                                    'maxlength' => 30,
                                                    'onchange' => 'changeButtonName(this);',
                                                    'data-row' => h($rownum)]); ?>
                <div>※30文字以内</div>
              </dd>

              <dt style="margin-top: 10px;">２．リンク先
                <?= $this->Form->input("info_contents.{$rownum}.option_value2", ['type' => 'select',
                    'options' => $link_target_list,
                    'value' => $content['option_value2']
                ]); ?>

              </dt>
              <dd>
                <?= $this->Form->input("info_contents.{$rownum}.content", ['type' => 'text', 'style' => 'width: 100%;', 'maxlength' => 255, 'placeholder' => 'http://']); ?>
              </dd>
<?php if (false): ?>
              <dt>３．ボタンの背景色</dt>
              <dd>
                <?= $this->Form->input("info_contents.{$rownum}.option_value", ['type' => 'select',
                                                                                    'options' => $button_color_list,
                                                                                    'empty' => ['' => '指定なし'],
                                                                                    'value' => $content['option_value'],
                                                                                    'escape' => false,
                                                                                  ]); ?>　
              </dd>
<?php else: ?>
              <dd><?= $this->Form->input("info_contents.{$rownum}.option_value", ['type' => 'hidden', 'value' => '']); ?></dd>
<?php endif; ?>

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
    <span style="font-size:0.9rem;"><?= (h($rownum) + 1); ?>.リンクボタン</span>
    <div class="table__row-config">
      <?= $this->element('UserInfos/sort_handle2'); ?>
      <?= $this->element('UserInfos/item_block_buttons', ['rownum' => $rownum, 'disable_config' => false]); ?>
    </div>
  </div>
</div>