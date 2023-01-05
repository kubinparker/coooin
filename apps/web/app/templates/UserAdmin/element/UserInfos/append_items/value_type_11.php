<!--チェックボックス-->
<?= $this->element('edit_form/append_item-start',[
    'title' => $append['name'],
    'slug' => $append['slug'],
    'required' => ($append['is_required'] ? true : false),
    'num' => $num,
    'data' => $data,
    'append' => $append
]); ?>

<?php 
if(empty($append['max_length']) || $append['max_length'] == 0){
$length = '';
}else{
$length = $append['max_length'];
}
?>
<?php if (empty($append['mst_list_slug'])): ?>
  <?= $this->Form->hidden("info_append_items.{$num}.value_int", ['value' => '0']); ?>
<div class="checkbox icheck-midnightblue">
  <?= $this->Form->input("info_append_items.{$num}.value_int",['type'=>'checkbox', 'hiddenField' => false,
          'value' => '1', 'id' => "append_{$num}_check", 'class' => '']); ?>
  <label for="append_<?= h($num) ?>_check"><?= h($append['name']) ?></label>
</div>
<?php else: ?>
  <?= $this->Form->input("info_append_items.{$num}._multiple", ['type' => 'select', 'multiple' => 'checkbox', 'options' => $list]); ?>
<?php endif; ?>
<?= $this->Html->view($append['attention'], ['before' => '<br><span>', 'after' => '</span>']); ?>
<?= $this->Form->error("{$slug}.{$append['slug']}") ?>

<?= $this->element('edit_form/append_item-end'); ?>
