<!--日付型-->
<?= $this->element('edit_form/append_item-start',[
    'title' => $append['name'],
    'slug' => $append['slug'],
    'required' => ($append['is_required'] ? true : false),
    'num' => $num,
    'data' => $data,
    'append' => $append
]); ?>



        <?= $this->Form->input("info_append_items.{$num}.value_date",['type'=>'text',
                'class' => 'form-control datepicker', 'style' => 'width:140px;',
                'default' => empty($append['value_default'])?'':h($append['value_default'])]); ?>
        <?= $this->Html->view($append['attention'], ['before' => '<br><span>', 'after' => '</span>']); ?>
        <?= $this->Form->error("{$slug}.{$append['slug']}") ?>
        
<?= $this->element('edit_form/append_item-end'); ?>