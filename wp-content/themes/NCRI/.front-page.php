<?php get_header(); ?>
<main id="content">
	
	<?php $top_section = get_field('top_section'); ?>
	<section class="home-top">
		<div class="container">
			<div class="row">
				<div class="col-md-7 col-lg-6">
					<p class="home-top__top-line"><?php echo $top_section['top_line']; ?></p>
					<div class="home-top__title" data-scroll>
						<?php echo $top_section['main_headlines']; ?>
					</div>
					<div class="home-top__content fadeIn" data-scroll>
						<p><?php echo $top_section['content']; ?></p>
					</div>
					<div class="home-top__content fadeIn" data-scroll>
						
						<div style="height:575px">
 						<blockquote class="twitter-tweet"><p lang="en" dir="ltr">QAnon has &quot;rebranded&quot; since President Trump left office, says Joel Finkelstein, who monitors online misinformation for Network Contagion Research Institute. Followers are now doubling down on misinformation about COVID vaccines and masks. <a href="https://t.co/tyNbewgRuM">https://t.co/tyNbewgRuM</a> <a href="https://t.co/tOilEDi3Dj">pic.twitter.com/tOilEDi3Dj</a></p>&mdash; 60 Minutes (@60Minutes) <a href="https://twitter.com/60Minutes/status/1363651814609088512?ref_src=twsrc%5Etfw">February 22, 2021</a></blockquote> 
						<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
						</div>
						
<!-- 						<p><strong><?php echo $top_section['video_description']; ?></strong></p>
						<img class="logo" src="https://networkcontagion.us/wp-content/uploads/bbcworld-logo.jpg">
						<a class="button" data-fancybox href="#recent_video"><i class="fas fa-tv"></i> <?php echo $top_section['button_text']; ?></a>
						<div class="video__wrapper">
							<video width="480" height="270" controls playsinline poster="https://networkcontagion.us/wp-content/uploads/ncri_bbcposter-1.png"id="recent_video">
								<source src="<?php echo $top_section['video_link']; ?>" type="video/mp4">
								Your browser doesn't support HTML5 video tag.
							</video>
						</div> -->
						
					</div>
				</div>
				<div class="col-md-5 col-lg-6">
				</div>
			</div>
			<div id="graphic-1">
				<img class="graphic" src="/wp-content/uploads/graphic-angled-1.png" alt="NCRI - Contextus Technology">
			</div>
			<div id="mobile-graphic-1" class="fadeIn" data-scroll>
				<img src="/wp-content/uploads/NCRI-mobile-header.jpg" alt="NCRI - Contextus Technology Platform">
			</div>
			<div class="circle circle--1 grow" data-scroll></div>
		</div>
		<div class="graphic-bg graphic-bg-1">
			<div class="overlay"></div>
		</div>
	</section>
	
	<?php $tech_section = get_field('technology_section'); ?>
	<section class="home-tech">
		<div class="container">
			<h2 class="home-tech__section-title fadeIn" data-scroll><?php echo $tech_section['section_title']; ?></h2>
			<div class="row">
				<div class="col-lg-8">
					<div class="home-tech__area">
						<div class="home-tech__area-image slideInLeft" data-scroll style="background-image: url('/wp-content/uploads/ncri_circle_embed.jpg');">
						</div>
						<div class="home-tech__area-content fadeIn" data-scroll>
							<h3 class="home-tech__area-content-title"><?php echo $tech_section['title_1']; ?></h3>
							<p><?php echo $tech_section['description_1']; ?></p>
						</div>
					</div>
					<div class="home-tech__area">
						<div class="home-tech__area-image slideInRight" data-scroll style="background-image: url('/wp-content/uploads/ncri_circle_track.jpg');">
						</div>
						<div class="home-tech__area-content fadeIn" data-scroll>
							<h3 class="home-tech__area-content-title"><?php echo $tech_section['title_2']; ?></h3>
							<p><?php echo $tech_section['description_2']; ?></p>
						</div>
					</div>
					<div class="home-tech__area">
						<div class="home-tech__area-image three slideInLeft" data-scroll style="background-image: url('/wp-content/uploads/ncri_circle_expose.jpg');">
						</div>
						<div class="home-tech__area-content fadeIn" data-scroll>
							<h3 class="home-tech__area-content-title"><?php echo $tech_section['title_3']; ?></h3>
							<p><?php echo $tech_section['description_3']; ?></p>
						</div>
					</div>
				</div>
			</div><div id="graphic-2">
				<img class="graphic" src="/wp-content/uploads/graphic-angled-3.png" alt="NCRI - How our Contextus Technology works">
			</div>
			<div class="circle circle--2 grow" data-scroll></div>
			<div class="circle circle--3 grow" data-scroll></div>
			<div class="circle circle--4 grow" data-scroll></div>
			<div class="circle circle--5 grow" data-scroll></div>
			<div class="circle circle--6 grow" data-scroll></div>
			<div class="circle circle--7 grow" data-scroll></div>
		</div>
	</section>
	
	<?php $links_section = get_field('links_section'); ?>
	<section class="home-links">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-5 col-xl-4 home-links__col">
					<div class="home-links__box slideInUp" data-scroll>
						<div class="home-links__header">
							<h3 class="home-links__title"><?php echo $links_section['title_1']; ?></h3>
						</div>
						<div class="home-links__content">
							<p><?php echo $links_section['content_1']; ?></p>
							<a class="button" href="<?php echo $links_section['link_1']; ?>"><?php echo $links_section['button_text_1']; ?></a>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-5 col-xl-4 home-links__col">
					<div class="home-links__box home-links__box--2 slideInUp" data-scroll>
						<div class="home-links__header">
							<h3 class="home-links__title"><?php echo $links_section['title_2']; ?></h3>
						</div>
						<div class="home-links__content">
							<p><?php echo $links_section['content_2']; ?></p>
							<a class="button" href="<?php echo $links_section['link_2']; ?>" <?php if($links_section['new_page_2']): ?>target="_blank" rel="noopener norefferer"<?php endif; ?>><?php echo $links_section['button_text_2']; ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<?php $support_section = get_field('support_section'); ?>
	<section id="home-donate">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 home-donate__left-col">
					<div class="home-donate__wrapper">
						<h2 class="home-donate__title"><?php echo $support_section['title']; ?></h2>
						<p class="home-donate__content"><?php echo $support_section['content']; ?></p>
						<a class="button" href="<?php echo $support_section['link']; ?>"><?php echo $support_section['button_text']; ?></a>
					</div>
					<svg class="black-svg align-self-end" viewBox="0 0 100 100" preserveAspectRatio="none">
						<polygon points="0,0 90,0 100,100 0,100"></polygon>
					</svg>
				</div>
				<div class="col-lg-6">
					<div class="fb-wrapper">
						<div class="fb-page" data-href="https://www.facebook.com/NCRI.IO/" data-tabs="timeline" data-width="500" data-height="" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/NCRI.IO/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/NCRI.IO/">The Network Contagion Research Institute</a></blockquote></div>
					</div>
				</div>
			</div>
		</div>
		<div class="black-bg"></div>
	</section>
	
</main>

<?php get_footer(); ?>