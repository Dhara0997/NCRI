<?php // Template Name: Homepage New ?>
<?php get_header(); ?>
<section id="content" role="main">
	<div class="container">
	    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	        <section class="entry-content">
	            <?php // if ( has_post_thumbnail() ) : the_post_thumbnail(); endif; ?>
	            
	            <?php 
		            
		        the_content();
				
				?>
	            
	            <div class="entry-links">
	                <?php wp_link_pages(); ?>
	            </div>
	        </section>
	    </article>
	    <?php if ( ! post_password_required() ) comments_template( '', true ); ?>
	    <?php endwhile; endif; ?>
	</div>
</section>
<?php // get_sidebar(); ?>
<?php get_footer(); ?>