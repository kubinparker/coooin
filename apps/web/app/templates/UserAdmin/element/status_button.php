<?php if (!isset($enable_text)){$enable_text = __('有効');} ?>
<?php if (!isset($disable_text)){$disable_text = __('無効');} ?>
<?php if (!isset($action)){$action = 'enable';} ?>
<?php if (!isset($class)){$class="";}; ?>
<?php if (!isset($enable_class)){$enable_class = 'success';} ?>
<?php if (!isset($disable_class)){$disable_class = 'secondary';} ?>
<a role="button" type="button" class="btn w-100 text-light btn-sm btn-<?= ($status ? $enable_class : $disable_class); ?> text-decoration-none <?= $class;?>" href="<?= $this->Url->build(['action' => $action, $id , '?' => ($query ?? [])]); ?>">
  <?= ($status ? $enable_text : $disable_text); ?>
</a>