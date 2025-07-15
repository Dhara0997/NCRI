<?php get_header(); ?>
<section id="content" role="main">
	<div class="container">
		<header class="header">
            <h1 class="entry-title">Blog</h1>
        </header>
		<div class="row">
			<div class="col-lg-8">
			    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			    <?php get_template_part( 'entry' ); ?>
			    <?php comments_template(); ?>
			    <?php endwhile; endif; ?>
			    <?php get_template_part( 'nav', 'below' ); ?>
			</div>
			<div class="col-lg-4">
				<aside id="sidebar">
					<h2>Contact Us</h2>
					<?php echo do_shortcode( '[gravityform id="2" title="false" description="false"]' ); ?>
				</aside>
			</div>
		</div>
	</div>
</section>
<?php // get_sidebar(); ?>
<?php get_footer(); ?>