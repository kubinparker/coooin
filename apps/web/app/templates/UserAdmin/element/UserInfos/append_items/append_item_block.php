<?php if(!empty($append_list[$pos])):?>
  <?php foreach($append_list[$pos] as $n => $ap):?>
  <?php
  $ap_list = [];
  if(!empty($ap['mst_list_slug']) && isset($append_item_list[$ap['mst_list_slug']])){
    $ap_list = $append_item_list[$ap['mst_list_slug']];
  }
  ?>
  <?php if ($ap['value_type'] == \App\Model\Entity\AppendItem::TYPE_CUSTOM): ?>
    <?= $this->element("UserInfos/append_items/custom_{$ap['slug']}", ['num' => $ap->num, 'append' => $ap, 'list' => $ap_list, 'slug' => $page_config->slug, 'placeholder_list' => $placeholder_list, 'notes_list' => $notes_list]) ?>
  <?php else: ?>
    <?= $this->element("UserInfos/append_items/value_type_{$ap['value_type']}", ['num' => $ap->num, 'append' => $ap, 'list' => $ap_list, 'slug' => $page_config->slug, 'placeholder_list' => $placeholder_list, 'notes_list' => $notes_list]) ?>
  <?php endif; ?>
  <?php endforeach;?>
<?php endif;?>