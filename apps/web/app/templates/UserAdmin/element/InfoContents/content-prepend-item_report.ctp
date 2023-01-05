<div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-gray-dark">
            <h2 class="card-title">商品情報</h2>
          </div>

          <div class="card-body">

            <div class="table__search">
              <ul class="search__row">
                <li>
                  <div class="search__title">商品コード</div>
                  <div class="search__column">
                    <?= $this->Form->hidden('item_id', ['value' => $item->id]); ?>
                    <?= $this->Form->input('item_code', ['type' => 'text',
                            'readonly' => true,
                            'class' => 'form-control-plaintext',
                            'value' => $item->item_no
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

          </div>
        </div><!--/.card-->
      </div><!--/.col-12-->
    </div><!--/.row-->