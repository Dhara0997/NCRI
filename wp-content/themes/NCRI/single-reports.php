<?php get_header(); ?>
<section id="content" role="main">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
			    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				    <header>
					    <p class="report-title">Contagion and Ideology Report</p>
					    <h1 class="entry-title"><?php the_title(); ?></h1>
					    <!-- <p class="contributors">Contributors:</p>
					    <p class="credits"><?php the_field('authors'); ?></p> -->
				    </header>
				    <section class="entry-content">
					    <?php // if ( has_post_thumbnail() ) : the_post_thumbnail(); endif; ?>
					    <?php the_content(); ?>
					    <div class="entry-links">
					        <?php wp_link_pages(); ?>
					    </div>
					</section>
				</article>
			    <?php if ( ! post_password_required() ) comments_template( '', true ); ?>
			    <?php endwhile; endif; ?>
			    <footer class="footer">
			        <?php get_template_part( 'nav', 'below-single' ); ?>
			    </footer>
			</div>
			<div class="col-lg-4">
				<?php // get_sidebar(); ?>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>