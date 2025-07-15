		<footer id="footer" role="contentinfo">
			<div class="container">
				<div class="row">
					<div class="col-md-3 footer__left text-center text-lg-left">
						<div class="footer__logo">
							<?php $site_logo = get_field('logo_inverse','option'); ?>
							<a href="/" aria-label="Go to homepage"><img src="<?php echo $site_logo['url']; ?>" alt="NCRI Logo" /></a>
						</div>
					</div>
					<div class="col-md-9 footer__col-right">
						<div class="footer__right text-center text-md-right">
							<nav id="footer__main-menu">
								<div>
									<a class="button button--footer" href="/ncri-inc">NCRI Inc.</a>
									<a class="button button--footer" href="/contact">CONTACT US</a>
								</div>
								<?php wp_nav_menu( array( 'theme_location' => 'main-menu','depth' => 1 ) ); ?>
							</nav>
							<p>&copy; <?php echo date("Y"); ?> Network Contagion Research Institute</p>
						</div>
					</div>
				</div>
			</div>
		</footer>
		
		<?php get_template_part( '/parts/mobile-nav-panel' ); ?>
		
		<?php wp_footer(); ?>
		
	</body>
	
<? // $-Init for on scroll animation ?>
<script>
document.addEventListener('DOMContentLoaded', function(){
  var trigger = new ScrollTrigger({
    toggle: {
      visible: 'visible',
      hidden: 'hidden'
    },
    offset: {
      x: 0,
      y: 100
    },
    centerVertical: false,
    once: true
  }, document.body, window);
});
</script>

</html>