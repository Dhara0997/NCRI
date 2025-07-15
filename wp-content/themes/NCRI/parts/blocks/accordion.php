<?php
/**
 * Block template file: parts/blocks/accordion.php
 *
 * Accordion Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'accordion-' . $block['id'];
if ( ! empty($block['anchor'] ) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$classes = 'block-accordion';
if ( ! empty( $block['className'] ) ) {
    $classes .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $classes .= ' align' . $block['align'];
}
?>

<?php if(is_admin()): ?>
<div class="block-admin-box">
	<p>Accordion panels will display here</p>
</div>
<?php else: ?>

<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
	<?php if ( have_rows( 'accordion_panels' ) ) : ?>
	
	<div class="accordion" id="<?php echo $id ?>">
		<?php $i = 1; while ( have_rows( 'accordion_panels' ) ) : the_row(); ?>
		<div class="accordion-panel">
			<div class="accordion-panel__header" id="panel-header-<?php echo $i ?>">
				<button data-toggle="collapse" data-target="#collapse-<?php echo $i ?>" aria-expanded="false" aria-controls="collapse-<?php echo $i ?>">
					<?php if(get_sub_field( 'panel_icon' )): ?>
						<div class="icon"><?php the_sub_field( 'panel_icon' ); ?></div>
					<?php endif; ?>
					<span><?php the_sub_field( 'panel_title' ); ?></span>
				</button>
			</div>
			<div id="collapse-<?php echo $i ?>" class="collapse" aria-labelledby="panel-header-<?php echo $i ?>" data-parent="#<?php echo $id ?>">
				<div class="accordion-panel__body">
					<?php the_sub_field( 'panel_content' ); ?>
				</div>
			</div>
		</div>
		<?php $i++; endwhile; ?>
	</div>
	
	<?php endif; ?>
</div>

<?php endif; ?>