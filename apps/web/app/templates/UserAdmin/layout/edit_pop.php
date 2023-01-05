<?php
$this->extend('pop');
?>
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

      <?= $this->fetch('content_prepend'); ?>

      <div class="row">
        <div class="col-12">
          <div class="card" id="edit_block">
            <div class="card-header bg-gray-dark">
              <?= $this->fetch('content_header'); ?>
            </div>
            <div class="card-body" id="edit_block_body">
                <?= $this->fetch('content'); ?>
            </div><!--/.card-body-->
          </div><!--/.card-->
        </div>
      </div><!--/.row-->
    </div>
</div>

