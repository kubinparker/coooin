<ul class="ctrlis">
<?php if(/*!$this->Paginator->hasPrev() &&*/ $key == 0): ?>
  <li class="non">&nbsp;</li>
  <li class="non">&nbsp;</li>
<?php else: ?>
  <li class="cttop"><?= $this->Html->link('top', array('action' => 'position', $data->id, 'top', '?' => (!empty($query) ? $query : null)) )?></li>
  <li class="ctup"><?= $this->Html->link('top', array('action' => 'position', $data->id, 'up', '?' => (!empty($query) ? $query : null)) )?></li>
<?php endif; ?>

<?php if(/*!$this->Paginator->hasNext() &&*/ $key == $data_query->count()-1): ?>
  <li class="non">&nbsp;</li>
  <li class="non">&nbsp;</li>
<?php else: ?>
  <li class="ctdown"><?= $this->Html->link('top', array('action' => 'position', $data->id, 'down', '?' => (!empty($query) ? $query : null)) )?></li>
  <li class="ctend"><?= $this->Html->link('bottom', array('action' => 'position', $data->id, 'bottom', '?' => (!empty($query) ? $query : null)) )?></li>
<?php endif; ?>
</ul>