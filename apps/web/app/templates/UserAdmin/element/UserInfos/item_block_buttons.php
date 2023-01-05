<div class="btn-group">
  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="clickItemConfig(this);" data-no="<?= h($rownum); ?>"><i class="fas fa-cog"></i></button>
  <div class="dropdown-menu" style="width: 200px;">
    <button type="button" class="dropdown-item btn btn-light up" onclick="clickSort(<?= h($rownum); ?>, 'first');">最上段に移動</button>
    <button type="button" class="dropdown-item btn btn-light up" onclick="clickSort(<?= h($rownum); ?>, 'up');">１つ上に移動</button>
    <div class="dropdown-divider up down"></div>
    <button type="button" class="dropdown-item btn btn-light down" onclick="clickSort(<?= h($rownum); ?>, 'down');">１つ下に移動</button>
    <button type="button" class="dropdown-item btn btn-light down" onclick="clickSort(<?= h($rownum); ?>, 'last');">最下段に移動</button>
    <div class="dropdown-divider"></div>
    <div class="text-center">

    <?php if (empty($disable_config)): ?>
      <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#popupOption_<?= h($rownum); ?>"><i class="fas fa-cog"></i> オプション</button>
    <?php endif; ?>
      <button type="button" class="btn btn-sm btn-secondary btn_list_delete" data-row="<?= h($rownum); ?>"><i class="far fa-trash-alt"></i> 削除</button>
      <!-- <a href="javascript:void(0);" class="btn_confirm small_btn btn_list_delete size_min" data-row="<?= h($rownum);?>" style='text-align:center; width:auto;'>削除</a> -->
    </div>
  </div>
</div>