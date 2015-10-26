<?php
/**
 * The template for displaying Category pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); 
$cur_cat_id = get_cat_id(single_cat_title("",false));

$args0 = array('cat' => $cur_cat_id, 'meta_key' => 'secondary_category', 'meta_value' => array( 'Featured Position 1', 'Featured Position 2', 'Featured Position 3'), 'posts_per_page' => '99999' );
$excludeQuery = new WP_Query($args0);
while($excludeQuery->have_posts()): $excludeQuery->the_post();
$ids = get_the_ID();

endwhile;
wp_reset_postdata();
?>



<h1><?php single_cat_title('', true);  ?></h1>

<section id="main-sub-articles">
	<?php 
		$cur_cat_id = get_cat_id(single_cat_title("", false));
		$args = array( 'cat' => $cur_cat_id, 'meta_key' => 'secondary_category', 'meta_value' => 'Featured Position 1', 'posts_per_page' => 1, 'orderby' => 'date', 'order' => 'DESC');
		$query = new WP_Query( $args );
		while($query->have_posts()): 
			$query->the_post();
			$excludePosts[] = get_the_ID();
			//$video = get_post_custom_values('video_url_');
			$video = get_post_meta($post->ID, 'video_url_', true );
	?>
	<article class="main-feature">
		<div class="image-video">
			<?php if( ! empty( $video ) ) : ?>
				<?php $videoId = $video; ?>
			
			  	<div id="YTPlayer-<?php echo $videoId; ?>"></div>
			  	<script type="text/javascript">
			  		if(typeof youtubePlayerObject === 'undefined') {
						var youtubePlayerObject = null;
					}
					else {
						youtubePlayerObject = null;
					}
			    	youtubePlayerObject = new youtubePlayer();
			    	youtubePlayerObject.setYoutubeVideoId('<?php echo $videoId; ?>');
			    	site.youtubePlayerObjects.push(youtubePlayerObject);
			  	</script>
		  	<?php else: ?>
		  		<?php 
		  			$image_id = get_post_thumbnail_id($post->ID);

		  			$image_attributes_1200 = wp_get_attachment_image_src($image_id, 'main-feature/1200');
        			$image_attributes_320 = wp_get_attachment_image_src($image_id, 'main-feature/320'); 
        		?>
		  		<img src="" width="100%" data-1200-src="<?php echo $image_attributes_1200[0]; ?>" data-320-src="<?php echo $image_attributes_320[0]; ?>"/>
		  	<?php endif; ?>
		</div>
		<div class="content">
			<h3><a href="<?php echo get_permalink(); ?>"><?php echo the_title(); ?></a></h3>
			<p><?php echo get_excerpt(110); ?></p>
		</div>
	</article>
	<?php 
		endwhile; 
		wp_reset_postdata();
	?>
	<section class="sub-features">
		<?php 
			$args = array( 'cat' => $cur_cat_id, 'meta_key' => 'secondary_category', 'meta_value' => 'Featured Position 2', 'posts_per_page' => 1, 'orderby' => 'date', 'order' => 'DESC');
			$query = new WP_Query( $args );
			while($query->have_posts()): 
				$query->the_post();
				$excludePosts[] = get_the_ID();
		?>
		<article class="sub-feature">
			<div class="image-video">
				<?php 
		  			$image_id = get_post_thumbnail_id($post->ID);

		  			$image_attributes_1200 = wp_get_attachment_image_src($image_id, 'sub-feature/1200');
        			$image_attributes_768 = wp_get_attachment_image_src($image_id, 'sub-feature/768');
        		?>
        		<img src="" width="100%" data-1200-src="<?php echo $image_attributes_1200[0]; ?>" data-768-src="<?php echo $image_attributes_768[0]; ?>"/>
			</div>
			<div class="content">
				<a href="<?php echo get_permalink(); ?>">
					<h3><?php the_title(); ?></h3>
				</a>
			</div>
		</article>
		<?php 
			endwhile;
			wp_reset_postdata();

			$args = array( 'cat' => $cur_cat_id, 'meta_key' => 'secondary_category', 'meta_value' => 'Featured Position 3', 'posts_per_page' => 1, 'orderby' => 'date', 'order' => 'DESC');
			$query = new WP_Query( $args );
			while($query->have_posts()): 
				$query->the_post();
				$excludePosts[] = get_the_ID();
		?>
		<article class="sub-feature">
			<div class="image-video">
				<?php 
		  			$image_id = get_post_thumbnail_id($post->ID);

		  			$image_attributes_1200 = wp_get_attachment_image_src($image_id, 'sub-feature/1200');
        			$image_attributes_768 = wp_get_attachment_image_src($image_id, 'sub-feature/768');
        		?>
        		<img src="" width="100%" data-1200-src="<?php echo $image_attributes_1200[0]; ?>" data-768-src="<?php echo $image_attributes_768[0]; ?>"/>
			</div>
			<div class="content">
				<a href="<?php echo get_permalink(); ?>">
					<h3><?php the_title(); ?></h3>
				</a>
			</div>
		</article>
		<?php 
			endwhile;
			wp_reset_postdata();
		?>
	</section>
</section>
	<?php if(!empty($excludePosts)): ?>
	<script type="text/javascript">
		site.appendToAjaxParam({excludePosts: [<?php echo implode(', ', $excludePosts); ?>]});
	</script>
	<?php endif; ?>
	<?php 
		$args1 = array('cat' => $cur_cat_id, 'meta_key'=>'secondary_category', 'meta_value'=>'Hot Topics', 'posts_per_page' => 6, 'orderby' => 'date', 'order' => 'DESC');
		$query1 = get_posts($args1);
		$args2 = array('cat' => $cur_cat_id, 'meta_key'=>'secondary_category', 'meta_value'=>'Making Headlines', 'posts_per_page' => 6, 'orderby' => 'date', 'order' => 'DESC');
		$query2 = get_posts($args2);
		$args3 = array('cat' => $cur_cat_id, 'posts_per_page' => 6, 'orderby' => 'date', 'order' => 'DESC', 'post__not_in' => $excludePosts );
		//$query3 = new WP_Query($args3);
		$query3 = get_posts($args3);
	?>
<section id="small-article-container">
		<ul>
			<li class="selected"><a href="#" id="hot-topic" class="sub-category-switcher">Hot Topics</a></li>
			<?php if($query2): ?>
			<li><a href="#" id="media" class="sub-category-switcher">Making Headlines</a></li>
			<?php endif; ?>
			<li><a href="#" id="view-all"  class="sub-category-switcher">View All</a></li>
		</ul>
		
		<section id="hot-topic-container">
			<?php 
			foreach ($query1 as $post): 
				setup_postdata($post); 
			?>
			<article class="small">
				<div class="image-video">
					<?php
						//check if post has featured post thumbnail 
						$key = 'featured_post_thumbnail';
						$themeta = get_post_meta($post->ID, $key, TRUE);
						//get featured post thumbnail
						$customImage = wp_get_attachment_image_src(get_field('featured_post_thumbnail'), 'small'); 	
						//get post thumbnail 
						$image_id = get_post_thumbnail_id($post->ID);
						$image_attributes = wp_get_attachment_image_src($image_id, 'small');
						if($themeta != '') : ?>
						<a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $customImage[0]; ?>" alt="<?php echo get_the_title(get_field('featured_post_thumbnail')) ?>" width="100%" /></a>
						<?php  else : ?>
						<a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $image_attributes[0]; ?>" width="100%" /></a>
						<?php endif ?>				
					<?php /* <a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $image_attributes[0]; ?>" width="100%" /></a> */ ?>
				</div>
				<!--/.image-video-->
				<div class="content">
					<h3><a href="<?php echo get_the_permalink(); ?>"><?php echo get_title(25); ?></a></h3>
					<p class="updated"><?php the_modified_date('M j, Y'); ?></p>
					<p><?php echo get_excerpt(80); ?></p>
				</div>
				<!--/.content-->
			</article>

			<?php 
			endforeach; 
			wp_reset_postdata(); 
			?>
		</section>
		<!--/#hot-topic-container-->

		<section id="media-container" class="sub-category-container">
			<?php 
			foreach($query2 as $post): 
				setup_postdata($post); 
			?>
			<article class="small">
				<div class="image-video">
					<?php
						//check if post has featured post thumbnail 
						$key = 'featured_post_thumbnail';
						$themeta = get_post_meta($post->ID, $key, TRUE);
						//get featured post thumbnail
						$customImage = wp_get_attachment_image_src(get_field('featured_post_thumbnail'), 'small'); 	
						//get post thumbnail 
						$image_id = get_post_thumbnail_id($post->ID);
						$image_attributes = wp_get_attachment_image_src($image_id, 'small');
						if($themeta != '') : ?>
						<a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $customImage[0]; ?>" alt="<?php echo get_the_title(get_field('featured_post_thumbnail')) ?>" width="100%" /></a>
						<?php  else : ?>
						<a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $image_attributes[0]; ?>" width="100%" /></a>
						<?php endif ?>				
					<?php /* <a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $image_attributes[0]; ?>" width="100%" /></a> */ ?>
				</div>
				<!--/.image-video-->
				<div class="content">
					<h3><a href="<?php echo get_the_permalink(); ?>"><?php echo get_title(25); ?></a></h3>
					<p class="updated"><?php the_modified_date('M j, Y'); ?></p>
					<p><?php echo get_excerpt(80); ?></p>
				</div>
				<!--/.content-->
			</article>

			<?php 
			endforeach; 
			wp_reset_postdata(); 
			?>
		</section>
		<!--/#media-container-->
		
		<section id="view-all-container" class="sub-category-container">
			<?php
			//while ($query3->have_posts()): 
				//$query3->the_post(); 
			foreach($query3 as $post): 
				setup_postdata($post); 
			?>
			<article class="small">
				<div class="image-video">
					<?php
						//check if post has featured post thumbnail 
						$key = 'featured_post_thumbnail';
						$themeta = get_post_meta($post->ID, $key, TRUE);
						//get featured post thumbnail
						$customImage = wp_get_attachment_image_src(get_field('featured_post_thumbnail'), 'small'); 	
						//get post thumbnail 
						$image_id = get_post_thumbnail_id($post->ID);
						$image_attributes = wp_get_attachment_image_src($image_id, 'small');
						if($themeta != '') : ?>
						<a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $customImage[0]; ?>" alt="<?php echo get_the_title(get_field('featured_post_thumbnail')) ?>" width="100%" /></a>
						<?php  else : ?>
						<a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $image_attributes[0]; ?>" width="100%" /></a>
						<?php endif ?>				
					<?php /* <a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $image_attributes[0]; ?>" width="100%" /></a> */ ?>
				</div>
				<!--/.image-video-->
				<div class="content">
					<h3><a href="<?php echo get_the_permalink(); ?>"><?php echo get_title(25); ?></a></h3>
					<p class="updated"><?php the_modified_date('M j, Y'); ?></p>
					<p><?php echo get_excerpt(80); ?></p>
				</div>
				<!--/.content-->
			</article>
			<?php 
			//endwhile; wp_reset_postdata(); 
			endforeach;
			wp_reset_postdata();
			?>
			<a href="#" id="btn-show-more">Show More</a>
		</section>
		<!--/#view-all-container-->
		<div class="clear"></div>
</section>
<!--/#smal-article-container-->
<div class="clear"></div>
<?php
get_footer();
