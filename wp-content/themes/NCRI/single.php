<?php get_header(); ?>
<section id="content" role="main">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
			    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			    <?php get_template_part( 'entry' ); ?>
			    <?php if ( ! post_password_required() ) comments_template( '', true ); ?>
			    <?php endwhile; endif; ?>
			    <footer class="footer">
			        <?php get_template_part( 'nav', 'below-single' ); ?>
			    </footer>
			</div>
			<div class="col-lg-4">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>