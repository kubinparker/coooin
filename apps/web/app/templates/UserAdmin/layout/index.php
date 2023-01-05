<?php $this->extend('user'); ?>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1 class="m-0"><?= $this->fetch('content_title'); ?></h1>
      </div><!-- /.col -->
      <div class="col-sm-12">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="/user_admin/" class="icon-icn_home">HOME</a></li>
          <?= $this->fetch('menu_list'); ?>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="content">
    <?= $this->element('error_message'); ?>

  <div class="container-fluid">

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-gray-dark">
            <?php
            $data_count = $this->fetch('data_count'); ?>
            <?php if (is_numeric($data_count)): ?>
              <h2 class="card-title">登録一覧　<span class="count"><?= $this->fetch('data_count'); ?>件の登録</span></h2>
            <?php elseif ($data_count !== false): ?>
              <h2 class="card-title"><?= $data_count; ?></h2>
            <?php endif; ?>
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
        </div>
      </div>


    </div>
  </div>
</div>
