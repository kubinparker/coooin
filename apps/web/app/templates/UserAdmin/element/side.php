<?php $role_key = $this->Common->getUserRoleKey(); ?>
<?php $menu_list = $this->Common->getAdminMenu(); ?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="<?= $this->Url->build(['_name' => 'userTop']); ?>" class="brand-link" style="background-color:#FFF;height: 60px;">
		<img src="/user/common/images/caters.png" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light" style="color:#000;">ATERS CMS</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<?php foreach ($menu_list['side'] as $m) : ?>
					<?php $role_only = (!empty($m['role']) && !empty($m['role']['role_only'])) ? $m['role']['role_only'] : false; ?>

					<?php if (
						empty($m['role']) || empty($m['role']['role_type']) ||
						(!empty($m['role']) && !empty($m['role']['role_type']) && $this->Common->isUserRole($m['role']['role_type'], $role_only))
					) : ?>

						<li class="nav-item">
							<a href="#" class="nav-link">
								<p>
									<?= $m['title']; ?>
									<i class="right fas fa-angle-left"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<?php foreach ($m['buttons'] as $sub) : ?>
									<li class="nav-item">
										<?php
										$current_path = $this->Url->build();
										$pattern = '^' . $sub['link'] . '$|^' . $sub['link'] . '\/';
										$pattern = str_replace("?", "\?", $pattern);

										$side_menu_class = (preg_match('{' . $pattern . '}', $current_path)) ? 'active' : '';
										?>

										<a href="<?= $sub['link']; ?>" class="nav-link <?= $side_menu_class; ?>">
											<?php
											$_licon = (!empty($sub['icon']) && (!isset($sub['position']) || $sub['position'] != 'right')) ? __('<i class="{0}"></i>', $sub['icon']) : '';
											$_item = __('<p>{0}</p>', $sub['name']);
											$_ricon = (!empty($sub['icon']) && isset($sub['position']) && $sub['position'] == 'right') ? __('<i class="btn-icon-right {0}"></i>', $sub['icon']) : '<i class="btn-icon-right fas fa-angle-right"></i>';
											echo $_licon . $_item . $_ricon;
											?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>