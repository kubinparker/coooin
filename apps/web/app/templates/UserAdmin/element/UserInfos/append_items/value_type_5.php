<!--日付時間型-->
<?= $this->element('edit_form/append_item-start',[
    'title' => $append['name'],
    'slug' => $append['slug'],
    'required' => ($append['is_required'] ? true : false),
    'num' => $num,
    'data' => $data,
    'append' => $append
]); ?>



<?= $this->Form->input("info_append_items.{$num}.value_datetime",[
        'type'=>'text','class' => 'form-control datetimepicker', 'default' => empty($append['value_default'])?'':h($append['value_default'])]); ?>
<?= $this->Html->view($append['attention'], ['before' => '<br><span>', 'after' => '</span>']); ?>
<?= $this->Form->error("{$slug}.{$append['slug']}") ?>
        
<?= $this->element('edit_form/append_item-end'); ?>