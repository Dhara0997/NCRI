<?php /* Template Name: Sidebar Template */ ?>
<?php get_header(); ?>
<section id="content" role="main">
	<div class="container">
		<header class="header alignfull">
			<div class="container">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</div>
		</header>
		<div class="row">
			<div class="col-lg-8">
			    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				        <section class="entry-content">
				            <?php if ( has_post_thumbnail() ) : the_post_thumbnail(); endif; ?>
				            <?php the_content(); ?>
				            <div class="entry-links">
				                <?php wp_link_pages(); ?>
				            </div>
				        </section>
				    </article>
				<?php if ( ! post_password_required() ) comments_template( '', true ); ?>
				<?php endwhile; endif; ?>
			</div>
			<div class="col-lg-4">
				<aside id="sidebar">
					<?php the_field('sidebar_content'); ?>
				</aside>
			</div>
		</div>
	</div>
</section>
<?php // get_sidebar(); ?>
<?php get_footer(); ?>