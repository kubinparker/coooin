<?php $bodyClass = (isset($bodyClass) ? $bodyClass : ''); ?>
<div class="form-group row <?= (isset($elementClass) ? $elementClass : ''); ?>">
  <?php if ($title !== false): ?>
    <label for="" class="col-12 col-md-3 col-form-label control_title"><?= $title; ?>
      <?php if (!empty($subTitle)): ?>
        <br><div><span><?= $subTitle; ?></span></div>
      <?php endif; ?>
        <?php if (!empty($required)): ?>
        <span class="attent">※<?= ($required === true ? '必須' : $required);?></span>
        <?php endif; ?>
    </label>
    <div class="col-12 col-md-9 control_value <?= $bodyClass; ?>">
  <?php else: ?>
    <div class="col-12 control_value <?= $bodyClass; ?>">
  <?php endif; ?>
