<?php
/*
Template Name: Defender Landing Page
*/
get_header(); ?>


<h1><?php the_title(); ?></h1>
<section id="main-article-categories">
	<?php
	$args = array('meta_key'=>'main_feature', 'meta_value'=>'1', 'posts_per_page' => 1, 'orderby' => 'date', 'order' => 'DESC');
	$query = new WP_Query($args);

	while($query->have_posts()): 
		$query->the_post();
		$excludePosts[] = get_the_ID();
		$video = get_post_meta($post->ID, 'video_url_', true );
		//$video = get_post_custom_values('video_url_');
	?>
	<article class="main-feature">
		<div class="image-video">
			<?php if( ! empty( $video ) ) : ?>
				<?php $videoId = $video; ?>
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
			  	<div id="YTPlayer-<?php echo $videoId; ?>"></div>
			  	
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
			<p><?php echo get_excerpt(84); ?></p>
		</div>
	</article>
	<?php 
		endwhile;
		wp_reset_postdata();
	?>
	<section class="categories">
		<div class="category">
			<h2><a href="<?php echo home_url(); ?>/financial-fraud-protection">Financial Fraud Protection</a></h2>
			<p>Financial fraud can impact your time and cost you money. Stay in-the-know about how to keep your finances protected.</p>
		</div>
		<div class="category">
			<h2><a href="<?php echo home_url(); ?>/identity-theft-protection">Identity Theft Protection</a></h2>
			<p>Identity theft can happen more easily than you think. Find out how you can avoid becoming a victim.</p>
		</div>
		<div class="category">
			<h2><a href="<?php echo home_url(); ?>/medical-fraud-protection">Medical Fraud Protection</a></h2>
			<p>Healthcare fraud is a fast-growing problem. Arm yourself with the latest information to protect your medical information.</p>
		</div>
		<div class="category">
			<h2><a href="<?php echo home_url(); ?>/online-child-safety">Online Child Safety</a></h2>
			<p>From cyberbullying to child identity theft, learn more about the issues your children face online and how to prevent them.</p>
		</div>		
	</section>
</section>
<?php 
	$args1 = array('meta_key'=>'secondary_category', 'meta_value'=>'Hot Topics', 'posts_per_page' => 6, 'orderby' => 'date', 'order' => 'DESC');
	$query1 = get_posts($args1);
	$args2 = array('meta_key'=>'secondary_category', 'meta_value'=>'Making Headlines', 'posts_per_page' => 6, 'orderby' => 'date', 'order' => 'DESC');
	$query2 = get_posts($args2);
?>
<section id="small-article-sidebar-container">
	<section id="small-article-container">
		<ul>
			<li class="selected"><a href="#" id="hot-topic" class="sub-category-switcher">Hot Topics</a></li>
			<?php if($query2): ?>
			<li><a href="#" id="media" class="sub-category-switcher">Making Headlines</a></li>
			<?php endif; ?>
		</ul>
		<section id="hot-topic-container" class="sub-category-container <?php if($query1) { echo 'active'; } ?>">
			<?php	
			foreach($query1 as $post): 
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
					<h3><a href="<?php echo get_the_permalink(); ?>"><?php echo get_title(40); ?></a></h3>
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


		<section id="media-container" class="sub-category-container <?php if(!$query1) { echo 'active'; } ?>">
			<?php 
			foreach ($query2 as $post) : 
				setup_postdata( $post ); 
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
						<?php ?>
						
						<a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $customImage[0]; ?>" alt="<?php echo get_the_title(get_field('featured_post_thumbnail')) ?>" width="100%" /></a>
						<?php  else : ?>
						<a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $image_attributes[0]; ?>" width="100%" /></a>
						<?php endif ?>
						
						
				
					<?php /* <a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $image_attributes[0]; ?>" width="100%" /></a> */ ?>
				</div>
				<!--/.image-video-->
				<div class="content">
					<h3><a href="<?php echo get_the_permalink(); ?>"><?php echo get_title(40); ?></a></h3>
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

	</section>
	<!--/#smal-article-container-->

	<section id="sidebar-container">
			<?php get_sidebar( 'content' ); ?>
	</section>
</section>


<div class="clear"></div>
<!--/#getting-started-->


<?php 
get_footer(); 
