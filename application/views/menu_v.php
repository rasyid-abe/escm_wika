<?php
	$uri = $this->uri->segment(1);
	$uri2 = $this->uri->segment(2);
	$uri3 = $this->uri->segment(3);

	foreach ($main_menu as $key => $value) {
		$parent = $value['child'];
		$class = "";

		if (isset($uri)) {
			$class = ($uri == $key) ? "active" : "";
		}

		if (empty($parent)) { ?>
			<li class="nav-item <?php echo $class ?>">
				<a href="<?php echo site_url() ?>/<?php echo $key ?>">
					<i class="<?php echo $value['icon'] ?>"></i>
					<span class="menu-title"><?php echo $value['label'] ?></span>
				</a>
			</li>

		<?php } else {
			$buka = false;
			if (isset($uri) && !$buka) {
				$buka = ($uri == $key) ? true : false;
			}
		?>
			<li class="has-sub nav-item <?php echo ($buka) ? '' : '' ?>">
				<a href="#">
					<i class="<?php echo $value['icon'] ?>"></i>
					<span class="menu-title"><?php echo $value['label'] ?></span>
				</a>
				<ul class="menu-content <?php echo ($buka) ? 'in' : '' ?>">
					<?php
					foreach ($parent as $key2 => $value2) {
						$parent2 = $value2['child'];
						$class2 = "";
						if (isset($uri2)) {
							$class2 = ($uri . "/" . $uri2 == $key2) ? "active" : "";
						}
						if (empty($parent2)) { ?>
							<li class="<?php echo $class2 ?>">
								<a href="<?php echo site_url() ?>/<?php echo $key2 ?>" data-toggle="tooltip" data-placement="right" title="<?php echo $value2['label'] ?>">
									<i class="<?php echo $value2['icon'] ?>"></i>
									<?php echo $value2['label'] ?>
								</a>
							</li>
						<?php } else {
							$buka2 = false;
							if (isset($uri2) && !$buka2) {
								$buka2 = ($uri . "/" . $uri2 == $key2) ? true : false;
							}
						?>
							<li class="has-sub <?php echo ($buka2) ? '' : '' ?>">
								<a href="#" data-toggle="tooltip" data-placement="right" title="<?php echo $value2['label'] ?>">
									<i class="<?php echo $value2['icon'] ?>"></i>
									<?php echo $value2['label'] ?>
								</a>
								<ul class="menu-content <?php echo ($buka2) ? 'in' : '' ?>">
									<?php foreach ($parent2 as $key3 => $value3) {
										$class3 = "";
										if (isset($uri3)) {
											$class3 = ($uri . "/" . $uri2 . "/" . $uri3 == $key3) ? "active" : "";
										}
									?>
										<li class="<?php echo $class3 ?>">
											<a href="<?php echo site_url() ?>/<?php echo $key3 ?>" data-toggle="tooltip" data-placement="right" title="<?php echo $value3['label'] ?>">
												<i class="<?php echo $value3['icon'] ?>"></i>
												<?php echo $value3['label'] ?>
											</a>
										</li>
									<?php } ?>
								</ul>
							</li>
					<?php }
					} ?>
				</ul>
			</li>
	<?php }
	} ?>

<script type="text/javascript">
	$('a').click(function(e){
		var url = $(this).attr('href');
		var url_parts = url.replace(/\/\s*$/,'').split('/');
		if ( $.inArray('panduan', url_parts) > -1 ) {
			e.preventDefault();
			window.open($(this).attr('href'),'_blank')
		}

	})
</script>
