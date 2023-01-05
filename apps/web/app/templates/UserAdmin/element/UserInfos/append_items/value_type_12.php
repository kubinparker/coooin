<!--raido型-->
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
<?php
$radio_list = [];
$defalut_value = $append['value_default'] ?? '';
foreach ($list as $k => $v) {
    $_ = [ 'value' => $k, 'text' => $v ];
    if ($defalut_value == $k) {
        $_['checked'] = true;
    }
    $radio_list[] = $_;
}
?>
<?= $this->Form->radio("info_append_items.{$num}.value_key", $radio_list); ?>
<?= $this->Html->view($append['attention'], ['before' => '<br><span>', 'after' => '</span>']); ?>
<?= $this->Form->error("{$slug}.{$append['slug']}") ?>

<?= $this->element('edit_form/append_item-end'); ?>
