<div class="reports-archive">
	
	<?php
	$args = array (
		'post_type' => 'reports',
	);
	$query = new WP_Query( $args ); 
	?>
	
	<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<i class="icon fal fa-file-alt"></i>
			<div class="reports-wrapper">
				<a class="report-link" href="<?php the_permalink(); ?>"><h2 class="report-title"><?php the_title(); ?></h2></a>
				<p class="contributors">Contributors:</p>
				<div class="credits"><?php the_field('authors'); ?></div>
				<p class="summary"><?php the_field('report_summary'); ?></p>
				<a class="button" href="<?php the_permalink(); ?>">Read the Full Report</a>
			</div>
		</article>	
	<?php endwhile; endif;
	wp_reset_postdata(); ?>
	
</div>