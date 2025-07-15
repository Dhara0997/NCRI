<div id="nav-panel">
	
	<div class="nav-panel__container">
		<div class="nav-panel__logo">
			<a href="/">
				<?php $nav_logo = get_field('logo','option'); ?>
				<img src="<?php echo $nav_logo['sizes']['medium']; ?>" alt="NCRI logo">
			</a>
		</div>
		
		<nav id="mobile-menu" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
			<a class="button" href="/contact">Contact Us</a>
		</nav>
		
		<div class="nav-panel__extra">
			<form role="search" method="get" class="searchform" action="/">
				<div>
					<label class="screen-reader-text" for="s">Search for:</label>
					<input type="text" value="" id="s" name="s" aria-label="Mobile Search Input" placeholder="Search">
					<!--<input type="hidden" value="post" name="post_type" id="post_type" />-->
					<button type="submit"><i class="fas fa-search"></i></button>
				</div>
			</form>
		</div>
		
		<?php get_template_part('parts/social_links'); ?>
		
		<div class="nav-panel__bottom">
			<p>&copy; <?php echo date("Y"); ?> Network Contagion Research Institute</p>
		</div>
	</div>
	
	<div class="nav-panel__overlay"></div>
	
</div>