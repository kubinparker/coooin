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
    $placeholder = '';
    if(isset($placeholder_list[$append['slug']])){
        $placeholder = $placeholder_list[$append['slug']];
    }
    $notes = '';
    if(isset($notes_list[$append['slug']])){
        $notes = $notes_list[$append['slug']];
    }
  ?>

<?= $this->Form->input("info_append_items.{$num}.value_text",[
  'type'=>'text',
  'maxlength' => $length,
  'default' => empty($append['value_default'])?'':h($append['value_default']),
  'placeholder' => $placeholder,
  'class' => 'form-control'
]);
?>
        <?= empty($length)?'':'<div class="attention">※'.h($length).'文字以内で入力してください</div>';?>
        <?= empty($notes)?'':'<div class="attention">※'.h($notes).'</div>';?>
        <?= $this->Html->view($append['attention'], ['before' => '<div class="attention">', 'after' => '</div>']); ?>
        <?= $this->Form->error("{$slug}.{$append['slug']}") ?>
<?= $this->element('edit_form/append_item-end'); ?>