<table class="table table-sm table-hover table-bordered dataTable dtr-inline" style="table-layout: fixed;">
    <colgroup>
      <col style="width:100px;">
      <col style="width: 130px;">
      <col style="">
      <col style="width: 80px;">
      <col style="width: 100px;">
      <col style="width: 100px;">
      <col style="width: 100px;">
      <col style="width: 100px;">
    </colgroup>

    <thead class="bg-gray">
    <tr>
      <th>発送日</th>
      <th>注文番号</th>
      <th>商品名</th>
      <th>数量</th>
      <th>売上</th>
      <th>売上手数料</th>
      <th>送料</th>
      <th>追加送料</th>
    </tr>
    </thead>

    <tbody>
    <?php
    foreach ($order_items->toArray() as $key => $data):
      $status = true;
      ?>

      <tr class="<?= $status ? "visible" : "unvisible" ?>" id="content-<?= $data->id ?>">
        <!--発送日-->
        <td>
          <?= $data->shipment_date->format('m/d'); ?>
        </td>

        <!--注文番号-->
        <td>
          <?= $this->Html->link($data->order_item_head->order_no_sub, ['controller' => 'orders', 'action' => 'order-head', $data->order_item_head->id]); ?>
        </td>

        <!--商品名-->
        <td>
          [<?= h($data->item_code); ?>]<?= h($data->item_name); ?>
        </td>

        <!--数量-->
        <td class="text-right">
          <?= h($data->quan_sum); ?>
        </td>

        <!--売上額-->
        <td class="text-right">
          <?= $this->Html->view($data->amount_sum, ['price_format' => true]); ?>
        </td>

        <!--売上手数料-->
        <td class="text-right">
          <?= $this->Html->view($data->fee_sum, ['price_format' => true]); ?>
        </td>

        <!--送料-->
        <td class="text-right">
          <?= $this->Html->view($data->shipping_sum, ['price_format' => true]); ?>
        </td>

        <!--追加送料-->
        <td class="text-right">
          <?= $this->Html->view($data->add_shipping, ['price_format' => true]); ?>
        </td>

      </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
      <th colspan="4" class="text-right bg-gray">合計</th>
      <th class="text-right"><?= $this->Html->view($amount->amount_sum, ['price_format' => true]); ?></th>
      <th class="text-right"><?= $this->Html->view($amount->fee_sum, ['price_format' => true]); ?></th>
      <th class="text-right"><?= $this->Html->view($amount->shipping_sum, ['price_format' => true]); ?></th>
      <th class="text-right"><?= $this->Html->view($amount->add_shipping_sum, ['price_format' => true]); ?></th>
    </tr>
    </tfoot>
  </table>