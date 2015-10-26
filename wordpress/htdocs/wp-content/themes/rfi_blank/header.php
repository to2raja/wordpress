<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" type="image/x-icon" />
	<?php wp_head(); ?>

	<script id="small-article-template" type="text/x-handlebars-template">
		{{#each posts}}
		<article class="small">
			<div class="image-video">
				<a href="{{ permalink }}"><img src="{{ thumbnail.small }}" width="100%"/></a>
			</div>
			<div class="content">
				<h3><a href="{{ permalink }}">{{{ title }}}</a></h3>
				<p class="updated">{{ updated }}</p>
				<p>{{{ excerpt }}}</p>
			</div>
		</article>
		{{/each}}
	</script>
	
</head>

<body <?php body_class(); ?>>
	<?php if ((is_category()) || (is_single()) ): ?>
		<?php
		$categories = get_the_category();
		$category = $categories[0];
		$category_id = $category->cat_ID;
		?>
		<script type="text/javascript">
			site.appendToAjaxParam({onlyWithCategory: <?php echo $category_id; ?>});
		</script>
	<?php endif; ?>
	
	<div id="topbar">
        <p class="contact">Have a question or comment? <a href="/email-us" class="contact-header-df">Contact us</a> <span class="or">or</span> call: <span class="tel">1-855-693-3637</span></p>
        <ul class="social">
            <li class="googleplus"><a href="https://plus.google.com/share?url=http%3A%2F%2Fwww./">Google+</a></li>
            <li class="facebook"><a href="http://www.facebook.com/sharer.php?u=http%3A%2F%2Fwww./">Facebook</a></li>
            <li class="twitter"><a href="https://twitter.com/intent/tweet?text=Protect%20yourself%20and%20your%20family%20with%20MetLife%20Defender.%20http://www./">Twitter</a></li>
        </ul>
        <?php
			$is_user_logged_in_url = '/umbraco/Surface/MemberJsonSurface/IsUserLoggedIn';
			$signout_url = '/login?signout=true';
			$data = array('key1' => 'value1', 'key2' => 'value2');
			
			// use key 'http' even if you send the request to https://...
			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'POST',
			        'content' => http_build_query($data),
			    ),
			);
			
			try {
				$context = stream_context_create($options);
				$result = file_get_contents($is_user_logged_in_url, false, $context);
			} catch (Exception $e) {
				$result = "false";
			}
			
			if ($result == "true") {
		?>
				<a class="login" href="/login?signout=true">Log out</a>
		<?php
			} else {
		?>
				<a class="login" href="/login">Log in</a>
		<?php
			}
		?>
    </div>
    <header>
        <h1 id="brand">
            <a href="/">ACME Identity Protection</a>
        </h1>

        <nav id="mainmenu">
            <?php /* <span class="toggle-menu toggle-closed">=</span> */ ?>
            <div class="tablet-mobile-menu-bar">
            	<div class="toggle-menu toggle-closed">
            		<span>Menu</span>
            	</div>
            	<p class="contact">QUESTION OR COMMENT? <a href="/email-us" class="contact-header-df">Contact us</a> OR CALL: <span class="tel">1-888-882-3637</span></p>
            </div>
            <ul>
                <li class="secure"><a href="/login">My Account</a></li>
                <li><a href="/how-defender-works/">How ACME Works</a></li>
                <li><a href="/features-and-benefits/">Features and Benefits</a></li>
                <li><a href="/enroll/">Plans and Pricing</a></li>
                <li class="current"><a href="/">Tools And<span class="dt-show"><br></span> Tips</a></li>
                <li style="width:200px"></li>
                <li class="util"><a href="/email-us">Contact Us</a></li>
            </ul>

        </nav>
        <nav class="submenu">
        	<span class="toggle-submenu toggle-closed">TOPICS</span>
            <ul>
                <li class="<?php echo ($category && $category->slug == 'financial-fraud-protection') ? 'current' : ''; ?>"><a href="<?php echo home_url(); ?>/financial-fraud-protection">Financial Fraud Protection</a></li>
                <li class="<?php echo ($category && $category->slug == 'identity-theft-protection') ? 'current' : ''; ?>"><a href="<?php echo home_url(); ?>/identity-theft-protection">Identity Theft Protection</a></li>
                <li class="<?php echo ($category && $category->slug == 'medical-fraud-protection') ? 'current' : ''; ?>"><a href="<?php echo home_url(); ?>/medical-fraud-protection">Medical Fraud Protection</a></li>
                <li class="<?php echo ($category && $category->slug == 'online-child-safety') ? 'current' : ''; ?>"><a href="<?php echo home_url(); ?>/online-child-safety">Online Child Safety</a></li>
            </ul>
        </nav>
    </header>

