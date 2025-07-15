<?php get_header(); ?>
<section id="content" role="main">
	<div class="container">
			    
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header>
				<p class="post-type">Webinar</p>
				<h1 class="entry-title"><?php the_title(); ?>
			</header>
			<section class="entry-content">
				
				<div class="webinar-info">
					<div class="row">
						<div class="col-md-4">
							<div class="webinar-meta">
								<?php
								$webinarDate = get_field('webinar_date', get_the_ID() );
								$eventDate = new DateTime($webinarDate);
								?>
								<p><strong>WHEN:</strong> <?php echo $eventDate->format('F j, Y'); ?></p>
								<p><strong>TIME:</strong> <?php the_field( 'webinar_time' ); ?></p>
								<p><strong>WHERE:</strong> <?php the_field( 'webinar_where' ); ?></p>
								<p><strong>REGISTRATION & INFO:</strong></p>
								<p><a class="button" href="<?php the_field( 'registration_link' ); ?>" target="_blank">REGISTER NOW</a></p>
								<p><a href="#become-a-sponsor">Sponsorship Opportunities</a></p>
								<?php $image_logo = get_field( 'image_logo' ); ?>
								<?php if ( $image_logo ) : ?>
									<img src="<?php echo esc_url( $image_logo['url'] ); ?>" alt="<?php echo esc_attr( $image_logo['alt'] ); ?>" />
								<?php endif; ?>
							</div>
						</div>	
						<div class="col-md-8">
							<?php the_field( 'webinar_excerpt' ); ?>
							
							<?php $logos_images = get_field( 'logos' ); ?>
							<?php if ( $logos_images ) :  ?>
							<div class="webinar-logos">
								<?php foreach ( $logos_images as $logos_image ): ?>
									<a href="<?php echo esc_url( $logos_image['url'] ); ?>">
										<img src="<?php echo esc_url( $logos_image['sizes']['thumbnail'] ); ?>" alt="<?php echo esc_attr( $logos_image['alt'] ); ?>" />
									</a>
									<p><?php echo esc_html( $logos_image['caption'] ); ?></p>
								<?php endforeach; ?>
							</div>
							<?php endif; ?>
							
						</div>
					</div>	
				</div>
				
				<?php if ( has_post_thumbnail() ) : the_post_thumbnail(); endif; ?>
				<?php the_content(); ?>
			</section>
		</article>
	    <?php if ( ! post_password_required() ) comments_template( '', true ); ?>
	    <?php endwhile; endif; ?>
	    
		<!-- <footer class="footer">
	        <?php get_template_part( 'nav', 'below-single' ); ?>
	    </footer> -->
			
			
		<aside id="sidebar">
			<div id="form">
			<?php echo do_shortcode('[gravityform id="3" tabindex="49"]'); ?>
			</div>
		</aside>
			
		
	</div>
</section>

<?php get_footer(); ?>