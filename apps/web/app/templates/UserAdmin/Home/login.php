<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>HOMEPAGE MANAGER <?= $__title__ ?></title>
	<link rel="stylesheet" href="/user/common/css/normalize.css">
	<link rel="stylesheet" href="/user/common/css/login.css">
	<link rel="stylesheet" href="/user/common/css/bootstrap-custom.css">
	<link rel="stylesheet" href="/user/plugins/toastr/toastr.min.css">

	<script src="/user/plugins/jquery/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="/user/plugins/toastr/toastr.min.js"></script>
	<style>
		#toast-container>div {
			width: auto;
		}
	</style>
</head>

<body>
	<?= $this->Flash->render('login_fail') ?>
	<div id="container">
		<div id="content">
			<div class="title-area"></div>
			<div id="error-message"> </div>
			<div class="content-inr">
				<div class="login-box">
					<h3 class="caption-img">ログイン</h3>
					<?= $this->Form->create($admin, ['id' => 'AdminIndexForm']); ?>
					<div class="table_area form_area login__table-area">
						<table class="vertical_table login__table">
							<tr>
								<td class="item-title">ユーザーID</td>
								<td><input name="username" type="text" id="id" placeholder="ユーザーID" style="width:100%;" /></td>
							</tr>
							<tr>
								<td class="item-title">パスワード</td>
								<td><input name="password" type="password" id="pw" placeholder="パスワード" style="width: 100%;" /></td>
							</tr>
						</table>
					</div>
					<div id="login-button"><button class="btn btn-dark">ログイン</button></div>
					<?= $this->Form->end(); ?>
				</div>
			</div>
			<footer>
				<div class="copy">© CATERS Inc. All Rights Reserved.</div>
			</footer>
		</div>
	</div>
</body>

</html>