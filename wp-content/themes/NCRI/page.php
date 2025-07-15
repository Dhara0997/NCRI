<?php get_header(); ?>
<section id="content" role="main">
	<div class="container">
	    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	        <header class="header alignfull">
				<div class="container">
	            	<h1 class="entry-title"><?php the_title(); ?></h1>
				</div>
	        </header>
	        <section class="entry-content">
	            <?php // if ( has_post_thumbnail() ) : the_post_thumbnail(); endif; ?>
	            
	            <?php 
		            
		        the_content();
		        
	            // Reports Archive Page
				//if(is_page('337')): get_template_part('templates/reports');  endif;
				
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