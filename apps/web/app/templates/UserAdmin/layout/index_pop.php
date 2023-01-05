<?php $this->extend((isset($baseLayout) ? $baseLayout : 'user')); ?>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><?= $this->fetch('content_title'); ?></h1>
      </div><!-- /.col -->

    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="content">
    <?= $this->element('error_message'); ?>

  <div class="container-fluid">
<!--    検索条件-->
    <div class="row">
      <div class="col-12">
        <div class="card <?= ($this->fetch('search_box_open') == 'on' ? '' : 'collapsed-card'); ?>">
          <div class="card-header bg-gray-dark">
            <h2 class="card-title"><?= $this->fetch('search_box_title', '検索条件'); ?></h2>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse"><i class="fas fa-<?= ($this->fetch('search_box_open') == 'on' ? 'minus' : 'plus'); ?>"></i></button>
            </div>
          </div>

          <div class="card-body">

            <?= $this->fetch('search_box'); ?>

          </div>
        </div><!--/.card-->
      </div><!--/.col-12-->
    </div><!--/.row-->

<!--    リスト-->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-gray-dark">
            <h2 class="card-title">登録一覧　<span class="count"><?= $this->fetch('data_count'); ?>件の登録</span></h2>
          </div>

          <div class="card-body">

            <?php if($this->Common->isUserRole('admin') && $this->fetch('create_url')): ?>
              <div class="btn_area center">
                <a href="<?= $this->fetch('create_url'); ?>" class="btn_confirm btn_post"><?= $this->fetch('create_label','新規登録');?></a>
              </div>
            <?php endif; ?>

              <?= $this->fetch('content'); ?>

            <?php if($this->Common->isUserRole('admin') && $this->fetch('create_url')): ?>
              <div class="btn_area center">
                <a href="<?= $this->fetch('create_url'); ?>" class="btn_confirm btn_post"><?= $this->fetch('create_label','新規登録');?></a>
              </div>
            <?php endif; ?>
          </div>
        </div><!--/.card-->
      </div><!--/.col-12-->
    </div><!--/.row-->

  </div>
</div>
