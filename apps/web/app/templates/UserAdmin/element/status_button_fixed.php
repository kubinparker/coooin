<?php if (!isset($enable_text)){$enable_text = '有効';} ?>
<?php if (!isset($disable_text)){$disable_text = '無効';} ?>
<?php if (!isset($btn_class)){$btn_class = 'success';} ?>
<?php if (!isset($enable_class)){$enable_class = $btn_class;} ?>
<?php if (!isset($disable_class)){$disable_class = 'danger';} ?>
<a role="button" type="button" class="btn w-100 btn-sm btn-<?= ($status ? $enable_class : $disable_class); ?> text-decoration-none" style="cursor: not-allowed !important;" href="javascript:void(0);">
  <?= ($status ? $enable_text : $disable_text); ?>
</a>