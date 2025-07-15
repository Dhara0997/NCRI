<?php // Template Name: Landing Page ?>
<?php get_header(); ?>
<section id="content" role="main">
	
	<header class="header header--dw-landing-page">
		<div class="container">
			<div class="header__logo">
				<?php $site_logo = get_field('logo_inverse','option'); ?>
				<a class="logo-homepage-link" href="/">
					<img src="<?php echo $site_logo['url']; ?>" alt="NCRI Logo" />
				</a>
			</div>
			<p class="meta">MAY 2021</p>
			<h1><?php the_title(); ?></h1>
			<p class="subtitle">Uncovering Disinformation and Misinformation With the Potential to Impact Walmart Success 
</p>
		</div>
	</header>
	
	<div class="container">
	    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	        
	        <section class="entry-content">
	            <?php // if ( has_post_thumbnail() ) : the_post_thumbnail(); endif; ?>
	            
	            <?php 
		            
		        the_content();
		        
	            // Reports Archive Page
				if(is_page('337')): get_template_part('templates/reports');  endif;
				
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