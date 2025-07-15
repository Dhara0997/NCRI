<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		
		<!-- Google Tag Manager -->
			<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','GTM-N4LPRZN');</script>
		<!-- End Google Tag Manager -->
		
		<!-- Google Analytics -->
		<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
		
		ga('create', 'UA-138260944-1', 'auto');
		ga('send', 'pageview');
		</script>
		<!-- End Google Analytics -->
		
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width">
		
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,400;1,700&family=Teko&display=swap" rel="stylesheet">
		
		<script src="https://kit.fontawesome.com/059ceea038.js" crossorigin="anonymous"></script>
		
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		
		<!-- Google Tag Manager (noscript) -->
			<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N4LPRZN"
			height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
		
		<div id="fb-root"></div>
		<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v4.0&appId=265470456802299&autoLogAppEvents=1"></script>
		
		<?php if(!is_page_template('page-landing.php')): ?>
		<header id="header" role="banner">
			<div class="container header__wrapper">
				<div class="header__logo">
					<?php $site_logo = get_field('logo','option'); ?>
					<a href="/" aria-label="Go to homepage"><img src="<?php echo $site_logo['url']; ?>" alt="NCRI Logo" /></a>
				</div>
				<div class="header__right">
					<div class="header__top-right">
						<a class="alt" href="https://www.paypal.com/US/fundraiser/charity/3521050" target="_blank">DONATE</a>
						<a class="alt" href="/careers">CAREERS</a>
						<a href="/ncri-inc">NCRI Inc.</a>
						<a href="/contact">CONTACT US</a>
					</div>
					<nav id="header__main-menu" role="navigation">
						<?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
					</nav>
				</div>
				<button id="nav-toggle"></button>
			</div>
		</header>
		<?php endif; ?>
