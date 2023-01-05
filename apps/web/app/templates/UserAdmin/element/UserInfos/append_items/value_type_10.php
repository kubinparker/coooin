<!--list型-->
<?= $this->element('edit_form/append_item-start',[
    'title' => $append['name'],
    'slug' => $append['slug'],
    'required' => ($append['is_required'] ? true : false),
  'num' => $num,
  'data' => $data,
  'append' => $append
]); ?>

<?php
    $value_default = $append['value_default'] ?? '';
?>
<?php if($append['is_required'] == 1):?>
    <?= $this->Form->select("info_append_items.{$num}.value_int", $list,[
        'class' => 'form-control', 'default' => $value_default]) ?>
<?php else:?>
    <?= $this->Form->select("info_append_items.{$num}.value_int", $list, [
        'empty' => '--', 'class' => 'form-control', 'default' => $value_default]) ?>
<?php endif;?>
    <?= $this->Html->view($append['attention'], ['before' => '<br><span>', 'after' => '</span>']); ?>
    <?= $this->Form->error("{$slug}.{$append['slug']}") ?>

<?= $this->element('edit_form/append_item-end'); ?>