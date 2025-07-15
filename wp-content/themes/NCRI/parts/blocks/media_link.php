<?php
/**
 * Block template file: parts/blocks/media_link.php
 *
 * Media Link Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'media-link-' . $block['id'];
if ( ! empty($block['anchor'] ) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$classes = 'block-media-link';
if ( ! empty( $block['className'] ) ) {
    $classes .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $classes .= ' align' . $block['align'];
}
?>

<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
	<p class="meta"><span class="date"><?php the_field( 'date' ); ?></span> | <span class="source"><?php the_field( 'source' ); ?></span></p>
	<h3><a class="title" href="<?php the_field( 'link' ); ?>" target="_blank" rel="noopener"><?php the_field( 'title' ); ?></a></h3>
	<p><?php the_field( 'summary' ); ?></p>
    <hr />
</div>