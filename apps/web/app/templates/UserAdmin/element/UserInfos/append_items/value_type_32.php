<!--画像型-->
<?= $this->element('edit_form/append_item-start',[
    'title' => $append['name'],
    'slug' => $append['slug'],
    'required' => ($append['is_required'] ? true : false),
    'num' => $num,
    'data' => $data,
    'append' => $append
]); ?>

        <?php $image_column = 'image'; ?>

<dl>
<?php if(!in_array($slug,['voice'])): ?>
  <dt><?= __('画像'); ?></dt>
<?php else:?>
<?php endif;?>
  <dd>
    <?php if (!empty($data['info_append_items'][$num]['attaches'][$image_column]['0'])) :?>
    <div>
      <a href="<?= h($data['info_append_items'][$num]['attaches'][$image_column]['0']);?>" class="pop_image_single">
        <img src="<?= $this->Url->build($data['info_append_items'][$num]['attaches'][$image_column]['0'])?>" style="width: 300px; float: left;">
        <?= $this->Form->input("info_append_items.{$num}.attaches.{$image_column}.0", ['type' => 'hidden']); ?>
      </a><br >
      <?= $this->Form->input("info_append_items.{$num}._old_{$image_column}", array('type' => 'hidden', 'value' => h($data['info_append_items'][$num][$image_column]))); ?>
    </div>
  <?php endif;?>

    <div>
      <?= $this->Form->input("info_append_items.{$num}.{$image_column}", array('type' => 'file', 'class' => 'attaches'));?>
      <div class="remark">※jpeg , jpg , gif , png ファイルのみ</div>
      <?php if($append['slug'] == 'company_image'): ?>
      <div>※横幅240×縦幅240で作成した画像を登録ください。</div>
      <?php endif;?>
      <div>※ファイルサイズ５MB以内</div>
      <?= $this->Html->view($append['attention'], ['before' => '<br><span>', 'after' => '</span>']); ?>
      <?= $this->Form->error("{$slug}.{$append['slug']}") ?>
      <br />
    </div>

    <div style="clear: both;"></div>
  </dd>
  <?php if(false): ?>
  <dt style="margin-top: 10px;">２．リンク先
    <?= $this->Form->input("info_append_items.{$num}.value_int", ['type' => 'select', 
                                                                    'options' => $list,
                                                                    'value' => $data['info_append_items'][$num]['value_int']
                                                                  ]); ?>
  </dt>
  <dd>
    <?= $this->Form->input("info_append_items.{$num}.value_textarea", ['type' => 'text', 'maxlength' => '255', 'placeholder' => 'http://']); ?>
  </dd>
<?php else:?>
  <?= $this->Form->input("info_append_items.{$num}.value_int",['type' => 'hidden', 'value' => '0']) ?>
  <?= $this->Form->input("info_append_items.{$num}.value_textarea",['type' => 'hidden', 'value' => '']) ?>
<?php endif;?>    
</dl>

<?= $this->element('edit_form/append_item-end'); ?>

