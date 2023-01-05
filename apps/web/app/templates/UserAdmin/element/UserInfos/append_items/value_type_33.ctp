<!--画像WordPress連携-->
<?= $this->element('edit_form/append_item-start', [
        'title' => $append['name'],
        'slug' => $append['slug'],
        'required' => ($append['is_required'] ? true : false),
        'num' => $num,
        'data' => $data,
        'append' => $append
]); ?>

<?php $image_column = 'value_text'; ?>

<dl>
  <?php if (!in_array($slug, ['voice'])): ?>
    <dt></dt>
  <?php else: ?>
  <?php endif; ?>
  <dd>
    <button type="button" class="media-upload" data-slug="<?= $append['slug']; ?>"><?= __('ファイル選択'); ?></button>
    <div class="wrap" id="append_block_image_<?= $append['slug']; ?>">
      <?php if (!empty($data['info_append_items'][$num]['value_text'])): ?>
        <p><img class="image-view" src="<?= $data['info_append_items'][$num]['value_text']; ?>" width="260"></p>
      <?php else: ?>
        <p class="image-view-block"></p>
      <?php endif; ?>
      <p><?= $this->Form->input("info_append_items.{$num}.value_text", ['type' => 'hidden', 'class' => 'image-url']); ?></p>
    </div>

    <div style="clear: both;"></div>
  </dd>

  <?= $this->Form->input("info_append_items.{$num}.value_int", ['type' => 'hidden', 'value' => '0']) ?>
  <?= $this->Form->input("info_append_items.{$num}.value_textarea", ['type' => 'hidden', 'value' => '']) ?>

</dl>

<?= $this->element('edit_form/append_item-end'); ?>