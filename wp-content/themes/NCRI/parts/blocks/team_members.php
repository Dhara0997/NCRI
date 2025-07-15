<?php
/**
 * Block template file: parts/blocks/team_members.php
 *
 * Team Members Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'team-members-' . $block['id'];
if ( ! empty($block['anchor'] ) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$classes = 'block-team-members';
if( ! empty( $block['className'] ) ) {
    $classes .= ' ' . $block['className'];
}
if( ! empty( $block['align'] ) ) {
    $classes .= ' align' . $block['align'];
}
?>

<style type="text/css">
	<?php echo '#' . $id; ?> {
		/* Add styles that use ACF values here */
	}
</style>

<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
	<?php if ( have_rows( 'team_members' ) ) : ?>
	<div class="team-members">
		<?php while ( have_rows( 'team_members' ) ) : the_row(); ?>
		<div class="team-member fadeIn" data-scroll>
			<div class="team-member__photo">
				<?php $photo = get_sub_field( 'photo' ); ?>
				<?php if ( $photo ) { ?>
					<img src="<?php echo $photo['url']; ?>" alt="<?php echo $photo['alt']; ?>" />
				<?php } ?>
			</div>
			<div class="team-member__info">
				<h3><?php the_sub_field( 'name' ); ?></h3>
				<?php if(get_sub_field( 'title' )): ?>
					<p class="title"><?php the_sub_field( 'title' ); ?></p>
				<?php endif; ?>
				<div class="team-member__sep"></div>
				<p><?php the_sub_field( 'bio' ); ?></p>
			</div>
		</div>
		<?php endwhile; ?>
	</div>
	<?php endif; ?>
</div>