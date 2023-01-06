<?php foreach ($menu_list['main'] as $m) : ?>

	<?php if (
		empty($m['role']) || empty($m['role']['role_type']) ||
		(!empty($m['role']) && !empty($m['role']['role_type']) &&
			$this->Common->isUserRole($m['role']['role_type'], (empty($m['role']['role_only']) ? false : true))
		)
	) : ?>

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header bg-gray-dark">
						<h2 class="card-title"><?= $m['title']; ?></h2>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>

					<div class="card-body">
						<div class="row">
							<?php foreach ($m['buttons'] as $b) : ?>

								<?php if (
									empty($b['role']) || empty($b['role']['role_type']) ||
									(!empty($b['role']) && !empty($b['role']['role_type']) && $this->Common->isUserRole(
										$b['role']['role_type'],
										(empty($m['role']['role_only']) ? false : true)
									))
								) : ?>

									<div class="col-12 col-md-4 mb-2">
										<a href="<?= $b['link']; ?>" class="btn btn-block btn-secondary btn-lg">
											<?= $b['name']; ?>
											<?= (!empty($b['right_icon'])) ? $b['right_icon'] : '<i class="btn-icon-right fas fa-angle-right"></i>'; ?>
										</a>
									</div>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
			<!-- /.col-md-6 -->
		</div>
	<?php endif; ?>
<?php endforeach; ?>
<!-- /.row -->