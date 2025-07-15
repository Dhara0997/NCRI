<?php get_header(); ?>
<section id="content" role="main">
	<div class="container">
		<div class="row">
			<div class="col-lg-7 col-xl-8">
				<div class="meta-above-title">
					<span>Job Opportunity</span>
				</div>
			    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			    <?php get_template_part( 'entry' ); ?>
			    <?php if ( ! post_password_required() ) comments_template( '', true ); ?>
			    <?php endwhile; endif; ?>
			    <footer class="footer">
			        <?php get_template_part( 'nav', 'below-single' ); ?>
			    </footer>
			</div>
			<div class="col-lg-5 col-xl-4">
				<?php //get_sidebar(); ?>
				<div class="form-container">
					<h3>Apply Now</h3>
					<p>Fill out the form below to apply for the position of <strong><?php the_title(); ?></strong></p>
					<?php gravity_form( 8, false, false, false, '', false ); ?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>