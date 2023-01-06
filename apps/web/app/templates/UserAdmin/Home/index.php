<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">管理メニュー</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item active"><a href="<?= $this->Url->build(['_name' => 'userTop']); ?>">Home</a></li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">

	<?= $this->element('error_message'); ?>

	<div class="container-fluid">
		<?= $this->cell('AdminMenu::mainMenu'); ?>

	</div><!-- /.container-fluid -->
</div>
<!-- /.content -->


<?php $this->start('beforeBodyClose'); ?>
<script>
	$(function() {
		$(".btnUpdateContent").on('click', function() {
			var id = $(this).data('id');

			alert_dlg('現在のコンテンツを最新版にします。<br><span class="text-danger">自動的に表示端末のブラウザの再読み込みを実行します。</span><br>元に戻すことは出来ません。よろしいですか？', {
				buttons: [{
						text: 'いいえ',
						click: function() {
							$(this).dialog("close");
						}
					},
					{
						text: 'はい',
						click: function() {
							$("#fm_update_" + id).submit();
							$(this).dialog("close");
						}
					}
				]
			});

			return false;
		});

	});
</script>
<?php $this->end(); ?>