<?php if (!isset($enable_text)){$enable_text = __('有効');} ?>
<?php if (!isset($disable_text)){$disable_text = __('無効');} ?>
<?php if (!isset($enable_value)){$enable_value = 'publish';} ?>
<?php if (!isset($disable_value)){$disable_value = 'draft';} ?>
<?php if (!isset($enable_class)) {$enable_class = 'turquoise';} ?>
<?php if (!isset($disable_class)) {$disable_class = 'danger';} ?>
<?php if (!isset($column)){$column = 'status';} ?>
<?= $this->Form->hidden($column, ['value' => 0]); ?>
<?= $this->Form->control($column, ['type' => 'radio','options' => [$enable_value => $enable_text],'hiddenField' => false,
    'label' => false,
    'templates' => [
        'radioWrapper' => '<div class="radio icheck-' . $enable_class . ' d-inline mr-2">{{label}}</div>',
    ],
    ]); ?>
<?= $this->Form->control($column, ['type' => 'radio','options' => [$disable_value => $disable_text],'hiddenField' => false,
    'label' => false,
    'templates' => [
        'radioWrapper' => '<div class="radio icheck-' . $disable_class . ' d-inline mr-2">{{label}}</div>',
    ],
    ]); ?>
