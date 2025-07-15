<?php get_header(); ?>
<section id="content" role="main">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
			    <?php if ( have_posts() ) : ?>
			    <header class="header">
			        <h1 class="entry-title"><?php printf( __( 'Search Results for: %s', 'ncri' ), get_search_query() ); ?></h1>
			    </header>
			    <?php while ( have_posts() ) : the_post(); ?>
			    <?php get_template_part( 'entry' ); ?>
			    <?php endwhile; ?>
			    <?php get_template_part( 'nav', 'below' ); ?>
			    <?php else : ?>
			    <article id="post-0" class="post no-results not-found">
			        <header class="header">
			            <h2 class="entry-title"><?php _e( 'Nothing Found', 'ncri' ); ?></h2>
			        </header>
			        <section class="entry-content">
			            <p>
			                <?php _e( 'Sorry, nothing matched your search. Please try again.', 'ncri' ); ?>
			            </p>
			            <?php get_search_form(); ?>
			        </section>
			    </article>
			    <?php endif; ?>
			</div>
			<div class="col-lg-4">
				<?php //get_sidebar(); ?>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>