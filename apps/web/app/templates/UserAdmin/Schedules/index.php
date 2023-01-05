<?php $this->assign('content_title', '営業カレンダー'); ?>
<?php $this->start('menu_list'); ?>
<li class="breadcrumb-item active"><span>営業カレンダー </span></li>
<?php $this->end(); ?>

<?php
$this->assign('data_count', $query['sch_year'] . '年'); // データ件数
$this->assign('create_url', ''); // 新規登録URL
?>

<!--search_box start-->
<?php $this->assign('search_box_open', 'on'); ?>
<?php $this->start('search_box'); ?>
  <?= $this->Form->create(null, ['type' => 'get', 'id' => 'fm_search', 'url' => ['action' => 'index'], 'class' => '', 'templates' => $form_templates]); ?>
    <div class="table__search">
      <ul class="search__row">
        <li>
          <div class="search__title">対象年</div>
          <div class="search__column">
            <?= $this->Form->input('sch_year', ['type' => 'select', 'options' => $year_list, 'value' => $query['sch_year'], 'onchange' => 'change_search();']); ?>
          </div>
        </li>
      </ul>
    </div>
  <?= $this->Form->end(); ?>


<?php $this->end(); ?>
<!--/ search_box end-->

<div class="table_list_area">
  <div class="table_area">
    <ul id="calendars">
      <!-- 1か月分 カレンダー -->
      <?php foreach ($calendars as $_key => $calendar): ?>
        <li class="calendar">
          <dl>
            <dt><?= $calendar_title[$_key]; ?></dt>
            <dd>
              <table>
                <thead>
                <tr>
                  <th style="padding:0px;border: solid 1px;">日</th>
                  <th style="padding:0px;border: solid 1px;">月</th>
                  <th style="padding:0px;border: solid 1px;">火</th>
                  <th style="padding:0px;border: solid 1px;">水</th>
                  <th style="padding:0px;border: solid 1px;">木</th>
                  <th style="padding:0px;border: solid 1px;">金</th>
                  <th style="padding:0px;border: solid 1px;">土</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($calendar->days() as $weeks): ?>
                  <tr>
                    <?php foreach ($weeks as $day => $_): ?>
                      <!-- 当月以外 -->
                      <?php if (!$_['in_month']): ?>
                        <td class="out_month">　</td>
                      <?php else: ?>
                        <td id="date_<?= $_['date']; ?>"
                            class="status_<?= (array_key_exists('schedule_status', $_) ? $_['schedule_status'] : '0'); ?>">
                          <a href="javascript:void(0);" class="status_change"
                             data-date="<?= $_['date']; ?>"><?= $_['mday']; ?></a></td>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            </dd>
          </dl>
        </li>
      <?php endforeach; ?>
    </ul>
    <div class="clearfix"></div>
  </div>
</div>

<?= $this->Form->create(null, ['type' => 'post', 'url' => ['action' => 'ajax_status.json']]); ?>
<?= $this->Form->end(); ?>

<?php $this->start('beforeHeadClose'); ?>
<link rel="stylesheet" href="/admin/common/css/cms.css">
<link rel="stylesheet" href="/user/common/css/calendar.css">
<?php $this->end(); ?>

<?php $this->start('beforeBodyClose'); ?>

<script>
  function change_search() {
    $("#fm_search").submit();

  }

  $(function () {


  })
  // カレンダー　クリック
  $(".status_change").on('click', function(){
    var url = "<?= $this->Url->build('/v1/schedules/ajax-status'); ?>";
    var date = $(this).data('date');
    var csrf = $('input[name="_csrfToken"]').val();

    var params = {
      "date": date
    };

    jQuery.ajax(url,
      {
        type: "post",
        data: params,
        dataType:'json',
        async: true,
        beforeSend: function(xhr) {
          xhr.setRequestHeader('X-CSRF-Token', csrf);
        },
        success: function(a){
          if (a.error.code == 0) {
            $("#date_" + date).removeClass('status_0');
            $("#date_" + date).removeClass('status_1');
            $("#date_" + date).removeClass('status_2');
            $("#date_" + date).addClass('status_'+a.result.status);
          }

        },
        error:function(XMLHttpRequest, textStatus, errorThrown){
          console.log()
        }
    });
  });
</script>
<?php $this->end(); ?>
