<div class="form-group row" id="append_block_<?= $slug; ?>">
  <?php if ($title !== false): ?>
    <label for="" class="col-12 col-md-3 col-form-label control_title"><?= $title; ?>
      <?php if (!empty($subTitle)): ?>
        <br><div><span><?= $subTitle; ?></span></div>
      <?php endif; ?>
        <?php if (!empty($required)): ?>
        <span class="attent">※必須</span>
        <?php endif; ?>
    </label>
  <?php endif; ?>
    <div class="col-12 col-md-9 control_value">
      <?= $this->Form->input("info_append_items.{$num}.id",['type' => 'hidden','value' => empty($data['info_append_items'][$num]['id'])?'':$data['info_append_items'][$num]['id']]);?>
      <?= $this->Form->input("info_append_items.{$num}.append_item_id",['type' => 'hidden','value' => $append['id']]);?>
      <?= $this->Form->input("info_append_items.{$num}.is_required",['type' => 'hidden','value' => $append['is_required'], 'id' => null]);?>
      <?= $this->Form->input("info_append_items.{$num}.value_text",['type' => 'hidden','value' => '', 'id' => null]);?>
      <?= $this->Form->input("info_append_items.{$num}.value_textarea",['type' => 'hidden','value' => '', 'id' => null]);?>
      <?= $this->Form->input("info_append_items.{$num}.value_date",['type' => 'hidden','value' => DATE_ZERO, 'id' => null]);?>
      <?= $this->Form->input("info_append_items.{$num}.value_datetime",['type' => 'hidden','value' => DATETIME_ZERO, 'id' => null]);?>
      <?= $this->Form->input("info_append_items.{$num}.value_time",['type' => 'hidden','value' => '0', 'id' => null]);?>
      <?= $this->Form->input("info_append_items.{$num}.value_int",['type' => 'hidden','value' => '0', 'id' => null]);?>
      <?= $this->Form->input("info_append_items.{$num}.value_key",['type' => 'hidden','value' => '', 'id' => null]);?>
      <?= $this->Form->input("info_append_items.{$num}.file",['type' => 'hidden','value' => '', 'id' => null]);?>
      <?= $this->Form->input("info_append_items.{$num}.file_size",['type' => 'hidden','value' => '0', 'id' => null]);?>
      <?= $this->Form->input("info_append_items.{$num}.file_extension",['type' => 'hidden','value' => '', 'id' => null]);?>
      <?= $this->Form->input("info_append_items.{$num}.image",['type' => 'hidden','value' => '', 'id' => null]);?>