<!--WYSIWYG型-->
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
<?= $this->Form->input("info_append_items.{$num}.value_textarea",[
        'type'=>'textarea','maxlength' => $length, 'default' => empty($append['value_default'])?'':h($append['value_default']),
        'class' => 'form-control editor']); ?>
<?= empty($length)?'':'<br><span>※'.h($length).'文字以内で入力してください</span>';?>
<?= $this->Html->view($append['attention'], ['before' => '<br><span>', 'after' => '</span>']); ?>
<?= $this->Form->error("{$slug}.{$append['slug']}") ?>

<?= $this->element('edit_form/append_item-end'); ?>