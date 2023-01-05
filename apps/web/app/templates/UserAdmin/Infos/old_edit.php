<?php use App\Model\Entity\PageConfigItem; ?>
<?php use App\Model\Entity\AppendItem; ?>

<?php $this->start('beforeHeaderClose'); ?>
<link href="https://fonts.googleapis.com/css2?family=Kosugi+Maru&family=Noto+Sans+JP:wght@300&family=Noto+Serif+JP&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<link rel="stylesheet" href="/user/common/css/info.css">
<style>
  .ck.ck-editor {
    /* max-height: 500px; */
    /* overflow-y: scroll; */
  }
</style>
<?php $this->end(); ?>

<div class="title_area">
  <h1><?= h($page_title); ?></h1>
  <div class="pankuzu">
    <ul>
      <?= $this->element('pankuzu_home'); ?>
<?php if ($page_config->parent_config_id): ?>
          <li><a href="/user_admin/infos/?page_slug=<?= $parent_config->slug; ?>"><?= $parent_config->page_title; ?></a></li>
<?php endif; ?>
      <li><a href="<?= $this->Url->build(array('action' => 'index', '?' => $query)); ?>"><?= h($page_title); ?></a></li>
      <li><span><?= ($data['id'] > 0)? '編集': '新規登録'; ?></span></li>
    </ul>
  </div>
</div>

    <?= $this->element('error_message'); ?>
    <div class="content_inr">
      <div class="box">
        <h3><?= ($data["id"] > 0)? '編集': '新規登録'; ?></h3>
        <div class="table_area form_area">
<?= $this->Form->create($entity, array('type' => 'file', 'context' => ['validator' => 'default'], 'name' => 'fm'));?>
<?= $this->Form->hidden('position'); ?>
<?= $this->Form->input('id', array('type' => 'hidden', 'value' => h($entity->id)));?>
<?= $this->Form->input('page_config_id', ['type' => 'hidden']); ?>
<?= $this->Form->input('meta_keywords', ['type' => 'hidden']); ?>
<?= $this->Form->input('postMode', ['type' => 'hidden', 'value' => 'save', 'id' => 'idPostMode']); ?>
<?php if ($entity->is_old == 0): ?>
  <?= $this->Form->input('is_new_style', ['type' => 'hidden', 'value' => '1']); ?>
<?php endif; ?>
<input type="hidden" name="MAX_FILE_SIZE" value="<?= (1024 * 1024 * 5); ?>">
          <table class="vertical_table table__meta">

            <tr>
              <td>記事番号</td>
              <td><?= ($data["id"])? sprintf('No. %04d', h($data["id"])) : "新規" ?></td>
            </tr>

<?php if($page_config->parent_config_id): ?>
            <tr>
              <td><?= $parent_config->page_title; ?></td>
              <td>
                <?= $this->Form->input('parent_info_id', ['type' => 'hidden', 'value' => $parent_info->id]); ?>
                <?= h($parent_info->title); ?>
              </td>
            </tr>
<?php endif; ?>

            <?php if ($page_config->is_public_date): ?>
            <tr>
              <td>掲載期間<span class="attent">※必須</span></td>
              <td>
                <?= $this->Form->input('start_date', array('type' => 'text', 'class' => 'datepicker', 'data-auto-date' => '1', 'default' => date('Y-m-d'), 'style' => 'width: 120px;'));?> ～ 
                <?= $this->Form->input('end_date', array('type' => 'text', 'class' => 'datepicker', 'style' => 'width: 120px;'));?>
                <div>※開始日のみ必須。終了日を省略した場合は下書きにするまで掲載されます。</div>
              </td>
            </tr>
          <?php else: ?>
            <tr>
              <td>掲載日<span class="attent">※必須</span></td>
              <td>
                <?= $this->Form->input('_start_date', array('type' => 'text', 'class' => 'datepicker', 'data-auto-date' => '1', 'default' => date('Y-m-d'), 'style' => 'width: 120px;'));?>
                <?= $this->Form->input('_start_time', array('type' => 'time',
                                                          // 'class' => 'datepicker',
                                                          'data-auto-date' => '1',
                                                          'default' => date('H:i'),
                                                          'style' => 'width: 120px;',
                                                          'templates' => [
                                                            'dateWidget' => '{{hour}}{{minute}}'
                                                          ],
                                                          // 'interval' => 10
                                                        ));?>
              </td>
            </tr>
          <?php endif; ?>

<?php if($this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_MAIN, 'category')): ?>
          <?php if ($this->Common->isCategoryEnabled($page_config) && !$this->Common->isCategoryEnabled($page_config, 'category_multiple')): ?>
            <tr>
              <td>
                <?= $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'category', 'title', 'カテゴリ'); ?><span class="attent">※必須</span>
                <?= $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'category', 'sub_title', ''); ?>
            </td>
              <td>
                <?= $this->Form->input('category_id', ['type' => 'select', 'options' => $category_list, 'empty' => ['0' => '選択してください']]); ?>
              </td>
            </tr>
          <?php elseif ($this->Common->isCategoryEnabled($page_config) && $this->Common->isCategoryEnabled($page_config, 'category_multiple')): ?>
            <tr>
              <td>カテゴリ<span class="attent">※必須</span></td>
              <td>
                <div class="list-group" style="height: 200px; overflow:auto;">

                 <?php foreach ($category_list as $cat_id => $cat_name): ?>
                    <label class="list-group-item">
                      <?= $this->Form->input("info_categories.{$cat_id}", 
                          [
                            'type' => 'checkbox',
                            'value' => $cat_id,
                            'checked' => in_array((int)$cat_id, $info_category_ids, false),
                            'class' => 'form-check-input me-1',
                            'hiddenField' => false
                          ]); ?>
                      <?= $cat_name; ?>
                    </label>
                  <?php endforeach; ?>
                </div>
              </td>
            </tr>
          <?php endif; ?>
<?php endif; ?>

<?php if($this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_MAIN, 'title')): ?>
            <tr>
              <td>
                <?= $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'title', 'title', 'タイトル'); ?><span class="attent">※必須</span>
                <?= $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'title', 'sub_title', ''); ?>
              </td>
              <td>
                <?= $this->Form->input('title', array('type' => 'text', 'maxlength' => 200, 'style' => 'width:100%;'));?>
                <br><span>※200文字以内で入力してください</span>
              </td>
            </tr>
<?php endif; ?>

<?php if($this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_MAIN, 'notes')): ?>
            <tr>
              <td><?= $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'notes', 'title', '概要'); ?>
                <?= $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'notes', 'sub_title', '<div>(一覧と詳細に表示)</div>'); ?>
              </td>
              <td>
                <?= $this->Form->input('notes', ['type' => 'textarea', 'maxlength' => '1000', 'style' => '']); ?>
                <br><span>※1000文字まで</span>
              </td>
            </tr>
<?php endif;?>

<?php $image_column = 'image'; ?>

<?php if($this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_MAIN, 'image')): ?>
            <tr>
              <td><?= $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'image', 'title', 'メイン画像'); ?>
                <div><?= $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'image', 'sub_title', '(一覧と詳細に表示)'); ?></div>
              </td>
              <td class="edit_image_area">
                
                <ul>
                  <?php if (!empty($data['attaches'][$image_column]['0'])) :?>
                  <li>
                    <a href="<?= $data['attaches'][$image_column]['0'];?>" class="pop_image_single">
                      <img src="<?= $this->Url->build($data['attaches'][$image_column]['0'])?>" style="width: 300px;">
                      <?= $this->Form->input("attaches.{$image_column}.0", ['type' => 'hidden']); ?>
                    </a><br >
                    <?= $this->Form->input("_old_{$image_column}", array('type' => 'hidden', 'value' => h($data[$image_column]))); ?>
                    <div class="btn_area" style="width: 300px;">
                      <a href="javascript:kakunin('画像を削除します。よろしいですか？','<?= $this->Url->build(array('action' => 'delete', $data['id'], 'image', $image_column, '?' => $query)) ?>')" class="btn_delete">画像の削除</a>
                    </div>
                  </li>
                <?php endif;?>
                  
                  <li>
                    <?= $this->Form->input($image_column, array('type' => 'file','accept' => 'image/jpeg,image/png,image/gif', 'id' => 'idMainImage', 'class' => 'attaches'));?>
                    <div class="remark">※jpeg , jpg , gif , png ファイルのみ</div>
                      <div><?= $this->Form->getRecommendSize('Infos', 'image', ['before' => '※', 'after' => '']); ?></div>
                    <div>※ファイルサイズ５MB以内</div>
                    <br />
                  </li>
                
                </ul>
                <?= $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'image', 'memo', ''); ?>
              </td>
            </tr>
<?php else:?>
  <?= $this->Form->input($image_column, array('type' => 'hidden','value' => ''));?>
<?php endif;?>

<?php if($this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_MAIN, 'image_title')): ?>
            <tr>
              <td>画像注釈</td>
              <td>
                <?= $this->Form->input("image_title",['type' => 'textarea', 'maxlength' => 200] ) ?>
                <br><span>※200文字以内で入力してください</span>
                <br><span>※改行は反映されません</span>
              </td>
            </tr>
<?php endif;?>


<?php if($this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_MAIN, 'index_type')): ?>
            <tr>
              <td><?= $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'index_type', 'title', 'ページトップ'); ?>
              <?= $this->Common->infoItemTitle($page_config->id, PageConfigItem::TYPE_MAIN, 'index_type', 'sub_title', ''); ?>
              </td>
              <td>
                <?= $this->Form->input('index_type', ['type' => 'radio', 'options' => ['0' => '設定しない', '1' => '設定する']]); ?>
              </td>
            </tr>
<?php endif;?>

<?php if($this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_MAIN, 'hash_tag')): ?>
            <tr>
              <td rowspan="2">ハッシュタグ</td>
              <td>
                <?= $this->Form->input('add_tag', ['type' => 'text', 'style' => 'width: 200px;', 'maxlength' => '40', 'id' => 'idAddTag', 'placeholder' => 'タグを入力']); ?> 
                <span class="btn_area" style="display: inline;">
                  <a href="#" class="btn_confirm small_menu_btn btn_orange" id="btnAddTag">追加</a>
                  <a href="#" class="btn_confirm small_menu_btn" id="btnListTag">タグリスト</a>
                </span>
                <div>※タグを入力して追加ボタンで追加またはタグリストから選択する事もできます。</div>
                <div>※重複した場合は１つにまとめられます。</div>
              </td>
            </tr>
            <tr>
              <td style="display:none;"></td>
              <td>
                <ul id="tagArea">
                  <?php $info_tag_count = 0; ?>
                <?php if (!empty($entity->info_tags)): ?>
                  <?php $info_tag_count = count($entity->info_tags); ?>
                  <?php foreach ($entity->info_tags as $k => $tag): ?>
                    <?= $this->element('UserInfos/tag', ['num' => $k, 'tag' => $tag->tag->tag]); ?>
                  <?php endforeach; ?>
                <?php endif; ?>
                </ul>
              </td>
            </tr>
<?php else:?>
  <?php $info_tag_count = 0;?>
<?php endif;?>

<?php if ($page_config->is_map): ?>
            <tr>
              <td>地図</td>
              <td>
              
              <div style="margin-left: 10px;">
                   <div style="color: red;">マップの該当箇所をクリックして、赤いピンを表示させてください。</div>
                   <?= $this->Form->input('map_search', array('type' => 'text', 'id' => 'ItemMapSearch' ,'style' => 'width: 330px'));?>
                    <input type="button" id="map_search" value="マップ表示">
                    <div id="map" data-model="Infos" style="width:600px; height:450px;"></div>
                    <?= $this->Form->input('lat', array('type' => 'hidden', 'style' => 'width:150px;', 'readonly' => true, 'id' => 'idLat'));?>
                    <?= $this->Form->input('lng', array('type' => 'hidden', 'style' => 'width:150px;', 'readonly' => true, 'id' => 'idLng'));?>
                    <?= $this->Form->input('zoom', array('type' => 'hidden', 'style' => 'width:150px;', 'readonly' => true, 'id' => 'idZoom'));?>
              </div>
          
              </td>
            </tr>
<?php endif; ?>

            <?php if(!empty($append_list)):?>
              <?php foreach($append_list as $n => $ap):?>
              <?php
              $ap_list = [];
              if(!empty($ap['use_option_list']) && isset($append_item_list[$ap['use_option_list']])){
                $ap_list = $append_item_list[$ap['use_option_list']];
              }
              ?>
              <?php if ($ap['value_type'] == AppendItem::TYPE_CUSTOM): ?>
                <?= $this->element("UserInfos/append_items/custom_{$ap['slug']}", ['num' => $n, 'append' => $ap, 'list' => $ap_list, 'slug' => $page_config->slug, 'placeholder_list' => $placeholder_list, 'notes_list' => $notes_list]) ?>
              <?php else: ?>
                <?= $this->element("UserInfos/append_items/value_type_{$ap['value_type']}", ['num' => $n, 'append' => $ap, 'list' => $ap_list, 'slug' => $page_config->slug, 'placeholder_list' => $placeholder_list, 'notes_list' => $notes_list]) ?>
              <?php endif; ?>
              <?php endforeach;?>
            <?php endif;?>

<?php if($this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_MAIN, 'meta')): ?>
          </tbody>
            <tr>
              <td class="head m-0 p-0" colspan="2">
                <button class="btn w-100 btn-light" type="button" data-toggle="collapse" data-target="#optionMetaItem" aria-expanded="false">
                  <span>metaタグ</span> <i class="fas fa-angle-down"></i>
                </button>
              </td>
            </tr>

        <tbody id="optionMetaItem" class="collapse">
<?php endif;?>
<?php if($this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_MAIN, 'meta')): ?>
            <tr>
              <td>meta 
                <div>(ページ説明文)</div>
              </td>
              <td>
                <?= $this->Form->input('meta_description', ['type' => 'textarea', 'maxlength' => '200', 'style' => '']); ?>
                <br><span>※200文字まで</span>
              </td>
            </tr>
<?php endif;?>
<?php if($this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_MAIN, 'meta')): ?>
            <tr>
              <td>meta 
                <div>(キーワード)</div>
              </td>
              <td>
              <?php for($i=0;$i<5;$i++): ?>
                <div><?= ($i + 1); ?>.<?= $this->Form->input("keywords.{$i}", ['type' => 'text', 'maxlength' => '20', 'style' => '']); ?></div>
              <?php endfor; ?>
                <br><span>※各20文字まで</span>
              </td>
            </tr>
<?php endif;?>
            <?php if ($entity->is_old == 1): ?>
            <tr>
              <td>新style</td>
              <td>
                <?= $this->Form->input('is_new_style', ['type' => 'checkbox', 'value' => '1', 'hiddenField' => true, 'label' => '新しいスタイルを適用する']); ?>
                ※新しいパーツを使った場合に適用してください
              </td>
            </tr>
            <?php endif; ?>

            <tr>
              <td>記事表示</td>
              <td>
                <?= $this->Form->input('status', array('type' => 'select', 'options' => array('draft' => '下書き', 'publish' => '掲載する')));?>
              </td>
            </tr>
          </tbody>
        </table>

        <div class="editor__table mb-5">
          <div id="blockArea" class="table__body list_table">
          <?php if (!empty($contents) && array_key_exists('contents', $contents)): ?>
          <?php foreach ($contents['contents'] as $k => $v): ?>
            <?php if ($v['block_type'] != 13): ?>
            <?= $this->element("UserInfos/block_type_{$v['block_type']}", ['rownum' => h($v['_block_no']), 'content' => h($v)]); ?>
            <?php endif; ?>
          <?php endforeach; ?>
          <?php endif; ?>
          </div>
          
          

          <?= $this->element('UserInfos/dlg_select_block'); ?>
        </div>



<?php if($this->Common->enabledInfoItem($page_config->id, PageConfigItem::TYPE_SECTION, 'relation')): ?>
          <tbody id="recommendBlock">
          <?php if (!empty($contents) && array_key_exists('contents', $contents)): ?>
          <?php foreach ($contents['contents'] as $k => $v): ?>
            <?php if ($v['block_type'] == 13): ?>
            <?= $this->element("UserInfos/block_type_{$v['block_type']}", ['rownum' => h($v['_block_no']), 'content' => h($v)]); ?>
            <?php endif; ?>
          <?php endforeach; ?>
          <?php endif; ?>
          </tbody>
<?php endif; ?>



        <div id="blockWork"></div>

        <div class="btn_area btn_area--center" id="editBtnBlock">
        <?php if (!empty($data['id']) && $data['id'] > 0){ ?>
            <a href="#" class="btn_confirm submitButton" id="btnSave">変更する</a>
            <a href="javascript:kakunin('データを完全に削除します。よろしいですか？','<?= $this->Url->build(array('action' => 'delete', $data['id'], 'content', '?' => $query))?>')" class="btn_delete">削除する</a>
        <?php }else{ ?>
            <a href="#" class="btn_confirm submitButton" id="btnSave">登録する</a>
        <?php } ?>
        </div>

        <div id="deleteArea" style="display: hide;"></div>

        <?= $this->Form->end();?>

        </div> 
      </div>
    </div>


<?php $this->start('beforeBodyClose');?>
<link rel="stylesheet" href="/user/common/css/cms.css">
<script src="/user/common/js/jquery.ui.datepicker-ja.js"></script>
<script src="/user/common/js/cms.js"></script>

<!-- <script src="/user/common/js/redactor/inlinestyle-ja.js"></script> -->
<!-- <script src="/user/common/js/redactor/ckeditor.js"></script> -->


  <!-- <script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script> -->
<script src="/user/common/js/ckeditor/ckeditor.js"></script>
<script src="/user/common/js/ckeditor/translations/ja.js"></script>

<?= $this->Html->script('/user/common/js/system/pop_box'); ?>


<script>
var rownum = 0;
var tag_num = <?= $info_tag_count; ?>;
var max_row = 100;
var pop_box = new PopBox();
var out_waku_list = <?= json_encode($out_waku_list); ?>;
var block_type_waku_list = <?= json_encode($block_type_waku_list); ?>;
var block_type_relation = 14;
var block_type_relation_count = 0;
var max_file_size = <?= (1024 * 1024 * 5); ?>;
var total_max_size = <?= (1024 * 1024 * 30); ?>;
var form_file_size = 0;
var page_config_id = <?= $page_config->id; ?>;
var is_old_editor = <?= ($editor_old == 1 ? 1 : 0); ?>;
</script>

<script>

$(function() {


});
</script>

<?= $this->Html->script('/user/common/js/info/edit'); ?>

<?php if ($page_config->is_map): ?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?= GOOGLE_MAP_KEY; ?>"></script>
<script>
var map = null;
var cur_marker = null;
var $lat = $('#idLat');
var $lng = $('#idLng');
var $zoom = $('#idZoom');
function getMyPlace() {
  var output = document.getElementById("result");
  if (!navigator.geolocation){//Geolocation apiがサポートされていない場合
    output.innerHTML = "<p>お使いのブラウザーでサポートされておりません</p>";
    return;
  }
  function success(position) {
    var latitude  = position.coords.latitude;//緯度
    var longitude = position.coords.longitude;//経度
    output.innerHTML = '';
    // 位置情報
    var latlng = new google.maps.LatLng( latitude , longitude ) ;
    map.setCenter(latlng);
    createMarker(latitude , longitude);

  };
  function error() {
    //エラーの場合
    output.innerHTML = "座標位置を取得できません";
  };
  navigator.geolocation.getCurrentPosition(success, error);//成功と失敗を判断
}
function createMarker(lat,lng, zoom){
      var marker = new google.maps.Marker({
          position: new google.maps.LatLng(lat,lng),
          map: map,
          icon: null,
          shadow: null,
          draggable: true
      });
      $lat.val(lat);
      $lng.val(lng);
      $zoom.val(zoom);

      marker.setMap(map);

      google.maps.event.addListener(marker,'dragend',function(ev){
          $lat.val(ev.latLng.lat());
          $lng.val(ev.latLng.lng());
      });

      if(cur_marker != null){
          cur_marker.setOptions({
              visible:false
          });
      }
      cur_marker = marker;
}
$(function(){
    console.log($zoom.val());
   // google maps
    if ($('#map').length && typeof google !== 'undefined' && typeof google.maps !== 'undefined') {
      
      var $map = $('#map');

      // var lat = parseInt($lat.val()) ? $lat.val() : $lat.val(36.571294).val();
      var lat = parseInt($lat.val()) ? $lat.val() : $lat.val(35.6894875).val();
      // var lng = parseInt($lng.val()) ? $lng.val() : $lng.val(139.939553).val();
      var lng = parseInt($lng.val()) ? $lng.val() : $lng.val(139.6917).val();

      var zoom = parseInt($zoom.val()) ? parseInt($zoom.val()) : 15;

      var marker_point = new google.maps.LatLng(lat,lng);

      map = new google.maps.Map($map.get(0), {
          zoom: zoom,
          center: marker_point,
          scaleControl: true,
          scrollwheel: true,
          mapTypeId: google.maps.MapTypeId.ROADMAP
      });

      google.maps.event.addListener(map, 'zoom_changed', function(pos) {
          $zoom.val(map.getZoom());
      });

      // console.log(map);

      createMarker(lat,lng, zoom);

      // マーカー
      google.maps.event.addListener(map,'click',function(ev){

         createMarker(ev.latLng.lat(),ev.latLng.lng(), $zoom.val());
      });


      $('#map_search').click(function () {
          var address = $('#ItemMapSearch').val();
          new google.maps.Geocoder().geocode({address: address},
              function (result, status) {
                  if (status === google.maps.GeocoderStatus.OK) {
                      map.setCenter(result[0].geometry.location);
                  }
              }
          );
      });
    }
});
</script>
<?php endif; ?>
<?php $this->end();?>