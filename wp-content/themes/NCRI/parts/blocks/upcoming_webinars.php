<?php
/**
 * Block template file: parts/blocks/upcoming_webinars.php
 *
 * Upcoming Webinars Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'upcoming-webinars-' . $block['id'];
if ( ! empty($block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$classes = 'block-upcoming-webinars';
if ( ! empty( $block['className'] ) ) {
	$classes .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$classes .= ' align' . $block['align'];
}
?>

<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $classes ); ?>">

	<h2>Upcoming Webinars</h2>
	
	<?php 
	$args = array (
		'post_type'    => 'webinars',
		'post_status'  => 'publish',
	);
	$webinars = new WP_Query( $args );
	
	if ( $webinars->have_posts() ) : ?>

		<?php while ( $webinars->have_posts() ) : $webinars->the_post(); ?>
		<div class="webinar-item">
			<div class="row">
				<div class="col-md-4">
					<?php if ( has_post_thumbnail() ) : the_post_thumbnail(); endif; ?>
				</div>
				<div class="col-md-8">
					<?php
					$webinarDate = get_field('webinar_date', get_the_ID() );
					$eventDate = new DateTime($webinarDate);
					?>
					<p class="webinar-item__date"><?php echo $eventDate->format('F j, Y'); ?></p>
					<h3><?php the_title(); ?></h3>
					<?php the_field( 'webinar_excerpt', get_the_ID() ); ?>
					<a class="button" href="<?php the_permalink(); ?>">Learn More</a>
				</div>
			</div>
		</div>
		<?php endwhile; ?>

	<?php else: ?>
	<p>No upcoming webinars at this time. Please check back soon for updates.</p>
	<?php endif; ?>
	
	<?php wp_reset_postdata(); ?>

</div>