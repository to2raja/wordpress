<?php
/**
 * RFI Blank Theme functions 
 * Based on Wordpress Twenty Fourteen
 * Twenty Fourteen functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used./**
 * Twenty Fourteen only works in WordPress 3.6 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '3.6', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'rfi_blank_setup' ) ) :

function rfi_blank_setup() {

	/*
	 * Make Twenty Fourteen available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Fourteen, use a find and
	 * replace to change 'twentyfourteen' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( 'rfi_blank', get_template_directory() . '/languages' );

	// This theme styles the visual editor to resemble the theme style.
	//add_editor_style( array( 'css/editor-style.css', twentyfourteen_font_url() ) );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support('post-thumbnails');

	set_post_thumbnail_size(672, 372, true);
	add_image_size('main-feature/1200', 800, 450, true);
	add_image_size('main-feature/320', 320, 180, true);
	//add_image_size('sub-feature/1200', 400, 225, true);
	add_image_size('sub-feature/1200', 396, 223, true);
	add_image_size('sub-feature/768', 384, 180, true);
	//add_image_size('sub-feature/320', 320, 150, true);
	add_image_size('small', 150, 150, true);
	add_image_size('article/768', 768, 350, true);
	add_image_size('article/320', 320, 180, true);
	add_image_size('facebook-share',  1200, 630, true);
	/*
	set_post_thumbnail_size( 672, 372, true );
	add_image_size('main-feature/single-article-thumb-desktop', 1200, 450, true);
	//add_image_size('single-article-thumb', 1200, 350, true);	
	add_image_size('main-feature/single-article-thumb-mobile', 640, 330, true);
	add_image_size('sub-feature-article-thumb-mobile',  580, 270, true);
	add_image_size('sub-feature-article-thumb-desktop', 370, 370, true);
	add_image_size('small-article-thumb', 150, 150, true);
	*/

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'Top primary menu', 'rfi_blank' ),
		'secondary' => __( 'Secondary menu in left sidebar', 'rfi_blank' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	
	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	/*
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );
	*/

	// This theme allows users to set a custom background.

}
endif; // twentyfourteen_setup
add_action( 'after_setup_theme', 'rfi_blank_setup' );



function rfi_blank_widgets_init() {
	require get_template_directory() . '/inc/widgets.php';
	//register_widget( 'Twenty_Fourteen_Ephemera_Widget' );

	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'twentyfourteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Main sidebar that appears on the left.', 'twentyfourteen' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Content Sidebar', 'twentyfourteen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Additional sidebar that appears on the right.', 'twentyfourteen' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area', 'twentyfourteen' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appears in the footer section of the site.', 'twentyfourteen' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

}
add_action( 'widgets_init', 'rfi_blank_widgets_init' );

/**/



if ( ! function_exists( 'rfi_blank_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since Twenty Fourteen 1.0
 */
function rfi_blank_the_attached_image() {
	$post                = get_post();
	/**
	 * Filter the default Twenty Fourteen attachment size.
	 *
	 * @since Twenty Fourteen 1.0
	 *
	 * @param array $dimensions {
	 *     An array of height and width dimensions.
	 *
	 *     @type int $height Height of the image in pixels. Default 810.
	 *     @type int $width  Width of the image in pixels. Default 810.
	 * }
	 */
	$attachment_size     = apply_filters( 'rfi_blank_attachment_size', array( 810, 810 ) );
	$next_attachment_url = wp_get_attachment_url();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID',
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id ) {
			$next_attachment_url = get_attachment_link( $next_id );
		}

		// or get the URL of the first image attachment.
		else {
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

if ( ! function_exists( 'twentyfourteen_list_authors' ) ) :
/**
 * Print a list of all site contributors who published at least one post.
 *
 * @since Twenty Fourteen 1.0
 */
function twentyfourteen_list_authors() {
	$contributor_ids = get_users( array(
		'fields'  => 'ID',
		'orderby' => 'post_count',
		'order'   => 'DESC',
		'who'     => 'authors',
	) );

	foreach ( $contributor_ids as $contributor_id ) :
		$post_count = count_user_posts( $contributor_id );

		// Move on if user has not published a post (yet).
		if ( ! $post_count ) {
			continue;
		}
	?>

	<div class="contributor">
		<div class="contributor-info">
			<div class="contributor-avatar"><?php echo get_avatar( $contributor_id, 132 ); ?></div>
			<div class="contributor-summary">
				<h2 class="contributor-name"><?php echo get_the_author_meta( 'display_name', $contributor_id ); ?></h2>
				<p class="contributor-bio">
					<?php echo get_the_author_meta( 'description', $contributor_id ); ?>
				</p>
				<a class="button contributor-posts-link" href="<?php echo esc_url( get_author_posts_url( $contributor_id ) ); ?>">
					<?php printf( _n( '%d Article', '%d Articles', $post_count, 'twentyfourteen' ), $post_count ); ?>
				</a>
			</div><!-- .contributor-summary -->
		</div><!-- .contributor-info -->
	</div><!-- .contributor -->

	<?php
	endforeach;
}
endif;

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Twenty Fourteen 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function rfi_blank_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentyfourteen' ), max( $paged, $page ) );
	}

	return $title;
}
//add_filter( 'wp_title', 'rfi_blank_wp_title', 10, 2 );

add_action( 'admin_footer', 'catlist2radio' );
function catlist2radio(){
	echo '<script type="text/javascript">';
	echo 'jQuery("#categorychecklist input, #categorychecklist-pop input, .cat-checklist input")';
	echo '.each(function(){this.type="radio"});</script>';
}


/* POST VALIDATION AGAINST UNCATEGORIZED CATEGORY */



/* REQUIRE FEATURED IMAGE */
//add_action('transition_post_status', 'require_featured_image', 10, 3);
/*
add_action('draft_to_publish', 'require_featured_image');
add_action('pending_to_publish', 'require_featured_image');
add_action('draft_to_future', 'require_featured_image');
add_action('pending_to_future', 'require_featured_image');
*/
//add_action( 'pre_post_update', 'require_featured_image' );
//add_action('publish_future_post', 'require_featured_image');
//add_action('pre_post_update', 'custom_requirements');
//add_action('update_postmeta', 'custom_requirements');
//add_action('draft_to_publish', 'custom_requirements');
//add_action('publish_future_post', 'custom_requirements');


/*add_action('save_post', 'custom_requirements');*/

/*
function custom_requirements($post) {
	global $post, $wpdb;

	if($post->post_type !== "post") {
		return true;
	}

	require_acceptable_category($post);
	require_featured_image($post);
}



function require_acceptable_category($post) {
	$category = get_the_category($post->ID);
	if(!$category || strtolower($category[0]->name) === 'uncategorized') {
		wp_die( __( 'You cannot publish without an acceptable category. Please choose any category other than Uncategorized.'));
    }
}

function require_featured_image($post) {
	$thumbnail_min_width = 1000;
	$thumbnail_min_height = 672;

	//No feature image required if tip category
	$category = get_the_category($post->ID);
	if($category && strtolower($category[0]->name) === 'tips') {
		return true;
	}

	//No feature image check 
	if(!has_post_thumbnail($post->ID)) {
		wp_die( __('You cannot publish without an acceptable featured image with dimensions of at least '.$thumbnail_min_width.'x'.$thumbnail_min_height.'.'));
	}
	else {
		//Not meeting dimension requirements check
		$image_id = get_post_thumbnail_id($post->ID);
	    $image_attributes = wp_get_attachment_image_src($image_id, 'full');    
	    if($image_attributes[1] < $thumbnail_min_width || $image_attributes[2] < $thumbnail_min_height) {
	        wp_die( __('You cannot publish without an acceptable featured image with dimensions of at least '.$thumbnail_min_width.'x'.$thumbnail_min_height.'.'));
	    }
    }
}
*/

function get_title($count, $post_obj=null) {
	global $post, $wpdb;

	//$post = ($post) ? $post : $post_obj;
	$post = ($post_obj) ? $post_obj : $post;

	$title = get_the_title($post->ID);
	if(strlen($title) <= $count) {
		return $title;
	}
	$title = html_entity_decode($title, ENT_QUOTES);
	$title = substr($title, 0, $count);
	$title .= '&hellip;';
	return $title;
}
//add_action('the_title','');

function get_excerpt($count, $readMoreOption=1, $post_obj=null){
	global $post, $wpdb;

	//$post = ($post) ? $post : $post_obj;
	$post = ($post_obj) ? $post_obj : $post;

	$permalink = get_permalink($post->ID);
	$excerpt = get_the_content();
	$excerpt = trim($excerpt);

	$pattern = '/\[(soliloquy|playbuzz-game)\s(id|game)="[^"]+"\]/i';
	$replace_with = '';
	$excerpt =  preg_replace($pattern,$replace_with,$excerpt);

	if(strlen($excerpt) <= $count) {
		return $excerpt;
	}
	$excerpt = strip_tags($excerpt);
	$excerpt = html_entity_decode($excerpt, ENT_QUOTES);
	$excerpt = substr($excerpt, 0, $count);
	$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
	$excerpt = trim($excerpt);
	//$excerpt .= '&hellip;';
	if($readMoreOption == 1) {
		$excerpt = $excerpt.' <a class="read-more" href="'.$permalink.'">read</a>';
	}
	else if($readMoreOption == 2) {
		$excerpt = $excerpt.' <a class="read-more" href="'.$permalink.'"></a>';
	}
	//$pattern = '/\[\w+\s+id=\"\d+\"\]/i';
	//$replace_with = '';
	//$excerpt =  preg_replace($pattern,$replace_with,$text);


	return $excerpt;
}

add_action('the_excerpt', 'get_excerpt');

add_action( 'wp_ajax_nopriv_load-filter', 'prefix_load_posts' );
add_action( 'wp_ajax_load-filter', 'prefix_load_posts' );
function prefix_load_posts() {
	$sanitizedRequest = sanitizeRequest($_POST);
	$args = array();

	/* request key to wp_query key map */
	$requestKeyToWpQueryKeyMap = array(
		'onlyWithCategory' => 'cat',
		//'onlyWithMetaKey' => 'meta_key',
		//'onlyWithMetaValue' => 'meta_value',
		'excludePosts' => 'post__not_in',
		'limit' => 'posts_per_page',
		'offset' => 'offset',
		//'orderby' => 'orderby',
		//'order' => 'order'
	);
	/* assign wp_query values */
	foreach($sanitizedRequest as $key => $value) {
		if(!isset($requestKeyToWpQueryKeyMap[$key])) {
			continue;
		}
		$args[$requestKeyToWpQueryKeyMap[$key]] = $value;
	}
	/* wp_query default values */
	$args['post_status'] = array('publish');

	$args['limit'] = isset($args['limit']) ? $args['limit'] : 6;
	$args['offset'] = isset($args['offset']) ? $args['offset'] : 0;
	$args['orderby'] = isset($args['orderby']) ? $args['orderby'] : 'modified';
	$args['order'] = isset($args['order']) ? $args['order'] : 'DESC';

	$excerptLength = isset($requestKeyToWpQueryKeyMap['excerptLength']) ? $requestKeyToWpQueryKeyMap['excerptLength'] : 110;
	$excerptStyleOption = isset($requestKeyToWpQueryKeyMap['excerptStyleOption']) ? $requestKeyToWpQueryKeyMap['excerptStyleOption'] : 1;
	$titleLength = isset($requestKeyToWpQueryKeyMap['titleLength']) ? $requestKeyToWpQueryKeyMap['titleLength'] : 27;	

	$query = new WP_Query($args);

	$posts = $query->get_posts();

	$results = array();
	foreach($posts as $post) {
		setup_postdata($post);
		$post_array = (array)$post;
		$post_array['permalink'] = get_permalink($post->ID);

		$post_array['thumbnail'] = array();
		$image_id = get_post_thumbnail_id($post->ID);
		$image_attributes = wp_get_attachment_image_src($image_id, 'small');
		$post_array['thumbnail']['small'] = $image_attributes[0];

		$post_array['excerpt'] = get_excerpt($excerptLength, $excerptStyleOption, $post);
		$post_array['title'] = get_title($titleLength, $post);
		$post_array['updated'] = get_the_modified_date('M j, Y');

		$results[] = $post_array;
	}

	echo json_encode($results);

	die(1);
}

function sanitizeRequest($request) {
	$sanitizedRequest = array();
	foreach($request as $key => $value) {
		switch($key) {
			case 'onlyWithCategory':
			case 'offset':
			case 'limit':
			case 'excerptLength':
			case 'excerptStyleOption':
			case 'titleLength':
				$sanitizedRequest[$key] = intVal($value);
				break;
			/*
			case 'orderby':
			case 'order':
				$sanitizedRequest[$key] = strval($value);
				break;

			case 'onlyWithMetaKey':
			case 'onlyWithMetaValue':
				if(!is_array($value)) {
					break;
				}
				$sanitizedRequest[$key] = array_map('strVal', $value);
				break;
			*/
			case 'excludePosts':
				if(!is_array($value)) {
					break;
				}
				$sanitizedRequest[$key] = array_map('intVal', $value);
				break;
			default:
				continue;
				break;
		}
		
	}
	return $sanitizedRequest;
}


function featured_image_requirement() {
    if(!has_post_thumbnail()) {
         wp_die( 'You forgot to set the featured image. Click the back button on your browser and set it.' ); 
    } 
}
//add_action( 'pre_post_update', 'featured_image_requirement' );
function my_excerpt($text, $excerpt)
{
    if ($excerpt) return $excerpt;

    $text = strip_shortcodes( $text );

    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]&gt;', $text);
    $text = strip_tags($text);
    $excerpt_length = apply_filters('excerpt_length', 55);
    $excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
    $words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
    if ( count($words) > $excerpt_length ) {
            array_pop($words);
            $text = implode(' ', $words);
            $text = $text . $excerpt_more;
    } else {
            $text = implode(' ', $words);
    }

	//$pattern = '/\[\w+\s+id=\"\d+\"\]/i';
	$pattern = '/\[(soliloquy|playbuzz-game)\s(id|game)="[^"]+"\]/i';
	$replace_with = '';
	$text =  preg_replace($pattern,$replace_with,$text);

    return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}




function add_meta_tags() {
	global $post;
	setup_postdata($post);

	//all tags 
	
	//echo '<meta property="og:site_name" content="'.bloginfo('name').'" />';
	//echo '<meta property="og:site_name" content="MetLife Defender - Understanding Your Risks" />';
	echo '<meta property="og:site_name" content="MetLife Defender - Tools and Tips" />';
	echo '<meta property="og:type" content="website" />';



	//$title = empty(trim(wp_title('', '', '')))? 'MetLife Defender' : wp_title('', '', ''); 
	//echo '<meta property="og:title" content="'.$title.'" />';
	//echo '<meta property="og:url" content="'.get_site_url().'" />';
	//echo '<meta property="og:url" content="http://'.$_SERVER['PHP_SELF'] .'" />';

	echo '<meta name="twitter:card" content="summary"/>';
	
	//echo '<meta property="og:url" content="http://'.$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"].'" />';
	//wp_title('', '', '');
	//page specific tags

	//check if on article page
	if (is_single()) {
		$image_id = get_post_thumbnail_id($post->ID);
        $image_attributes = wp_get_attachment_image_src($image_id, 'facebook-share');	
        $articleDesc = my_excerpt($post->post_content, get_the_excerpt());
        $fb_image = empty($image_attributes[0])? get_site_url().'/wp-content/themes/rfi_blank/images/facebook.png' : $image_attributes[0];
        $twitter_image = empty($image_attributes[0])? get_site_url().'/wp-content/themes/rfi_blank/images/twitter.png' : $image_attributes[0];
        //echo $articleDesc;

		echo '<meta property="og:url" content="'.get_permalink($post->ID ).'" />';
        echo '<meta property="og:image" content="'.$fb_image.'" />';
       	echo '<meta property="og:description" content="'.$articleDesc.'" />';
       	echo '<meta property="og:title" content="'.wp_title('', '', '').'" />';
       	echo '<meta name="twitter:title" content="'.wp_title('', '', '').'"/>';
       	echo '<meta name="twitter:image" content="'.$twitter_image.'" />';
       	echo '<meta name="twitter:image:src" content="'.$twitter_image.'">';
       	echo '<meta name="twitter:description" content="'.$articleDesc.'" />';
	}
	else {
		//if its not article page, pick general share image
		echo '<meta property="og:url" content="'.get_site_url().'" />';

		echo '<meta property="og:image" content="'.get_site_url().'/wp-content/themes/rfi_blank/images/facebook.png" />';
		echo '<meta property="og:description" content="MetLife Defender will protect you and your family from identify theft, data and credit fraud. Start to protect your personal information here." />';
		echo '<meta property="og:title" content="MetLife Defender"/>';
		echo '<meta name="twitter:title" content="MetLife Defender"/>';
		echo '<meta name="twitter:image" content="'.get_site_url().'/wp-content/themes/rfi_blank/images/twitter.png" />';
		echo '<meta name="twitter:image:src" content="'.get_site_url().'/wp-content/themes/rfi_blank/images/twitter.png" />';
		echo '<meta name="twitter:description" content="MetLife Defender will protect you and your family from identify theft, data and credit fraud. Start to protect your personal information here." />';

	}
}
//add_action('wp_head', 'add_meta_tags');




/* JAVASCRIPT VALIDATION FOR ADMIN EDIT POST */
/*
function rfi_enqueue_edit_screen_js($hook) {
    global $post;
	if ($hook !== 'post.php' && $hook !== 'post-new.php') {
    	return;
    }

    if($post->post_type === "post") {
        wp_register_script( 'rfi-admin-js', plugins_url( '/require-featured-image-on-edit.js', __FILE__ ), array( 'jquery' ) );
        wp_enqueue_script( 'rfi-admin-js' );
        wp_localize_script(
            'rfi-admin-js',
            'objectL10n',
            array(
                'jsWarningHtml' => __( '<strong>This entry has no featured image.</strong> Please set one. You need to set a featured image before publishing.', 'require-featured-image' ),
            )
        );
    }
}
*/

function my_enqueue($hook) {
	global $post;
	if ($hook !== 'post.php' && $hook !== 'post-new.php') {
    	return;
    }

    if($post->post_type === "post") {
    	wp_enqueue_script('admin-post-requirements', get_template_directory_uri().'/js/admin-post-requirements.js');
    }
}
add_action('admin_enqueue_scripts', 'my_enqueue');

//remove_filter( 'the_content', 'wpautop' );
//remove_filter( 'the_excerpt', 'wpautop' );


function redirect_tips() {
    //check if cat is tips
    if ( is_category( 'tips' ) ) {
        wp_redirect( home_url() );
        exit();
    }
}
add_action( 'template_redirect', 'redirect_tips' );
//remove default image link
update_option('image_default_link_type','none');




//hide admin sections
function remove_admin_menus() {
	remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=category');
    remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
	remove_meta_box('tagsdiv-post_tag' , 'post', 'normal');
	//remove_menu_page( 'themes.php' );
	remove_submenu_page('themes.php', 'customize.php');
	remove_submenu_page('themes.php', 'themes.php');
	remove_submenu_page('themes.php', 'nav-menus.php' );
	//add_menu_page('widgets.php');
	remove_menu_page('plugins.php');
	remove_menu_page('tools.php');
	
}
add_action('admin_menu', 'remove_admin_menus');



function remove_editor_menu() {
  remove_action('admin_menu', '_add_themes_utility_last', 101);
}
add_action('_admin_menu', 'remove_editor_menu', 1);
/*
function add_scripts(){
	//echo home_url();
	if ( is_user_logged_in() ) {
		echo '<link rel="stylesheet" id="admin-bar-css"  href="'.home_url().'/wp-includes/css/admin-bar.min.css?ver=3.9.1" type="text/css" media="all" />';
		echo '<link rel="stylesheet" id="stylesheet-css"  href="'.home_url().'/wp-content/themes/rfi_blank/style.css?ver=3.9.1" type="text/css" media="all" />';
		echo '<link rel="stylesheet" id="wp-polls-css"  href="'.home_url().'/wp-content/plugins/wp-polls/polls-css.css?ver=2.63" type="text/css" media="all" />';
		echo '<script type="text/javascript" src="'.home_url().'/wp-content/themes/rfi_blank/js/jquery-1.11.1.min.js?ver=3.9.1"></script>';
		echo '<script type="text/javascript" src="'.home_url().'/wp-content/themes/rfi_blank/js/handlebars-v1.3.0.js?ver=3.9.1"></script>';
		echo '<script type="text/javascript" src="'.home_url().'/wp-content/themes/rfi_blank/js/site.js?ver=3.9.1"></script>';
	} else {
		echo '<link rel="stylesheet" id="stylesheet-css"  href="'.home_url().'/wp-content/themes/rfi_blank/style.css?ver=3.9.1" type="text/css" media="all" />';
		echo '<link rel="stylesheet" id="wp-polls-css"  href="'.home_url().'/wp-content/plugins/wp-polls/polls-css.css?ver=2.63" type="text/css" media="all" />';
		echo '<script type="text/javascript" src="'.home_url().'/wp-content/themes/rfi_blank/js/jquery-1.11.1.min.js?ver=3.9.1"></script>';
		echo '<script type="text/javascript" src="'.home_url().'/wp-content/themes/rfi_blank/js/handlebars-v1.3.0.js?ver=3.9.1"></script>';
		echo '<script type="text/javascript" src="'.home_url().'/wp-content/themes/rfi_blank/js/site.js?ver=3.9.1"></script>';
	}
	
}

add_action('wp_head' , 'add_scripts');



function force_https_the_content($content) {
  if ( is_ssl() )
  {
    $content = str_replace( 'src="http://', 'src="https://', $content );
  }
  return $content;
}
add_filter('the_content', 'force_https_the_content');


//add_action('wp_head' , 'add_scripts');
*/


/**
* Enqueue scripts and styles for the front end.
*
* @since Twenty Fourteen 1.0
*/
 function rfi_blank_scripts() {

	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.0.2' );

	// Load our main stylesheet.
	//wp_enqueue_style( 'twentyfourteen-style', get_stylesheet_uri(), array( 'genericons' ) );
	wp_enqueue_style('stylesheet', get_template_directory_uri() . '/style.css');
	wp_enqueue_style('stylesheet-ie8', get_template_directory_uri() . '/ie8-style.css', array('stylesheet'));
	wp_style_add_data('stylesheet-ie8', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentyfourteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentyfourteen-style', 'genericons' ), '20131205' );
	wp_style_add_data( 'twentyfourteen-ie', 'conditional', 'lt IE 9' );

	

	wp_enqueue_script('jquery-1.11.1.min.js' , get_template_directory_uri() .'/js/jquery-1.11.1.min.js');
	//wp_enqueue_script('ajaxLoop.js' , get_template_directory_uri() .'/js/ajaxLoop.js');
	wp_enqueue_script('handlebars-v1.3.0.js' , get_template_directory_uri() .'/js/handlebars-v1.3.0.js' );
	wp_enqueue_script('site.js' , get_template_directory_uri() .'/js/site.js' );
	//wp_localize_script( 'my-script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
	if ( is_category() ) {

	}	
}
add_action( 'wp_enqueue_scripts', 'rfi_blank_scripts' );







