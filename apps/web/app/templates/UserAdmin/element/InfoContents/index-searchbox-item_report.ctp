<div class="table__search">
  <ul class="search__row">
    <li>
      <div class="search__title">商品ID</div>
      <div class="search__column">
        <?= $this->Form->input('item_id', ['type' => 'text',
                'readonly' => true,
                'class' => 'form-control-plaintext form-control',
                'value' => $item->id
        ]); ?>
      </div>
    </li>

    <li>
      <div class="search__title">商品名</div>
      <div class="search__column">
        <?= $this->Form->input('item_name', ['type' => 'text',
                'readonly ' => true,
                'class' => 'form-control-plaintext',
                'value' => $item->name,
                'style' => 'width:440px;'
        ]); ?>
      </div>
    </li>
  </ul>
</div>


