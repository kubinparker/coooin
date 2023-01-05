<!--ファイル型-->
<?= $this->element('edit_form/append_item-start', [
        'title' => $append['name'],
        'slug' => $append['slug'],
        'required' => ($append['is_required'] ? true : false),
        'num' => $num,
        'data' => $data,
        'append' => $append
]); ?>


<?php $_column = 'file'; ?>
  <div class="manu">
    <ul>

      <?php if (!empty($data['info_append_items'][$num]['attaches'][$_column]['0'])) : ?>
        <?php
        $file_data = $data['info_append_items'][$num]['attaches'][$_column];
        ?>
        <li class="<?= h($file_data['extention']); ?>">
          <?= $this->Form->input("info_append_items.{$num}.file_name", ['type' => 'hidden']); ?>
          <?= h($data['info_append_items'][$num]['file_name']); ?>
          .<?= h($data['info_append_items'][$num]['file_extension']); ?>
          <?= $this->Form->input("info_append_items.{$num}.file_size", ['type' => 'hidden', 'value' => h($data['info_append_items'][$num]['file_size'])]); ?>
          <div><?= $this->Html->link('ダウンロード', $file_data['0'], array('target' => '_blank')) ?></div>
        </li>
        <?= $this->Form->input("info_append_items.{$num}._old_{$_column}", array('type' => 'hidden', 'value' => h($data['info_append_items'][$num][$_column]))); ?>
        <?= $this->Form->input("info_append_items.{$num}.file_extension", ['type' => 'hidden']); ?>
      <?php endif; ?>

      <li>
        <?= $this->Form->input("info_append_items.{$num}.file", array('type' => 'file', 'class' => 'attaches', 'accept' => '.pdf')); ?>
        <div class="remark">※PDFファイルのみ</div>
        <div>※ファイルサイズ５MB以内</div>
        <?= $this->Html->view($append['attention'], ['before' => '<br><span>', 'after' => '</span>']); ?>
      </li>


    </ul>
    <?= $this->Form->error("{$slug}.{$append['slug']}") ?>
  </div>

<?= $this->element('edit_form/append_item-end'); ?>