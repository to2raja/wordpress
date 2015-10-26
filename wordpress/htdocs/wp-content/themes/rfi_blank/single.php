<?php
get_header(); ?>

<section id="main-article-container">
	<?php while ( have_posts() ) : the_post();?>
	<h1><?php the_title(); ?></h1>
	<section id="article-container">	
		<div class="article-container-border">
			<div class="article-container-nav">
				<span class="article-updated"><?php the_modified_date('M j, Y'); ?></span>
				<span class="article-share">
					<h2>Share<span class="mobileTrim"> This Article</span></h2>
					<div class="addthis_sharing_toolbox"></div>
					<!-- Go to www.addthis.com/dashboard to customize your tools -->
					<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-530e1e41195527d8"></script>

				</span>
			 	<!--/.article-share-->
			 
			</div>
			<!--/.article-container-nav-->

			<?php $video = get_post_meta($post->ID, 'video_url_', true );
				if( ! empty( $video ) ) : ?>
				<?php $videoId = $video; ?>
				<div class="image-video">
			  	<div id="YTPlayer-<?php echo $videoId; ?>" class="vidPlayer"></div>
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
			  </div>
		  	<?php else: ?>
		  	<?php endif; ?>	
		
		




			<p><?php the_content(); ?></p>

			<?php edit_post_link(); ?>	
			<div class="article-container-nav bottom">

				<?php 
					$currentID = get_the_ID();
					$category = get_the_category();
					$catID = $category[0]->cat_ID;
					$firstCategory = $category[0]->cat_name;
					//echo $firstCategory;
					$firstCategorySlug = $category[0]->slug;
					if ( in_category('tips')) {

					} else {
						echo '<span class="backToCat"><strong><a class="backToCat" href="/'.$firstCategorySlug.'">Back<span class="mobileTrim"> to '.$firstCategory.'</span></a></strong></span>';
					}	
				?>
				 
			<?php /* next_post_link('<span class="nextArticle top-nav"><strong>%link</strong></span>', 'Next'); */ ?>
			 	<?php /* previous_post_link('<span class="previousArticle top-nav"><strong>%link</strong></span>', 'Previous'); */ ?>

			 	 <?php
			 	   $category = get_the_category();
					$catID = $category[0]->cat_ID;
					$firstCategory = $category[0]->cat_name;
					
			 	  	$prev_post = get_adjacent_post(true, '', true); 
			 	  	$next_post = get_adjacent_post(true, '', false);

			 	  	//FIRST POST IN THE SAME CAT
			 	  	$args = array('cat' => $catID, 'posts_per_page' => '1', 'orderby' => 'date', 'order' => 'DESC');
			 	  	//LAST POST IN THE SAME CAT
			 	  	$args2 = array('cat' => $catID, 'posts_per_page' => '1', 'orderby' => 'date', 'order' => 'ASC');
			 	  	$query = get_posts($args);
			 	  	$query2 = get_posts($args2);
					foreach ($query as $post) : setup_postdata( $post ); 
					
					
					//$firstPostID = get_the_ID();
					$firstPostInCat = get_the_permalink();
					//echo $firstPostInCat;
					endforeach; 
					wp_reset_postdata();

					foreach ($query2 as $post) : setup_postdata( $post ); 
					
					$lastPostID = get_the_ID();
					$lastPostInCat = get_the_permalink();
					//echo $lastPostInCat;
					endforeach; 
					wp_reset_postdata();

			 	  ?>	 
			 	  <!--
			<?php if ( !empty( $next_post ) ): ?>
 				<span class="nextArticle"><strong><a href="<?php echo $next_post->guid; ?>">Next</a></strong></span>
			 <?php endif; ?>
			 <?php if ( !empty( $prev_post ) ): ?>
 				<span class="previousArticle"><strong><a href="<?php echo $prev_post->guid; ?>">Previous</a></strong></span>
 			 <?php endif; ?>
			-->
			</div>
			<!--/.bottom-artice-nav-->
		<?php endwhile; ?>
		</div>
		<!--/.article-container-border-->
	</section>
	<!--/#article-container-->
	<section id="sidebar-container">

		<section id="sidebar-container-related-articles">
			<h2><span>Related Articles</span></h2>

			<?php 
			$args = array('posts_per_page' => '6', 'cat' => $catID, 'post__not_in' => array($currentID));
			$relatedArticles = new WP_Query($args);

			while ( $relatedArticles->have_posts()) : $relatedArticles->the_post(); ?>
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
					<h3><a href="<?php echo get_the_permalink(); ?>"><?php echo get_title(25); ?></a></h3>
					<p class="updated"><?php the_modified_date('M j, Y'); ?></p>
					<p><?php echo get_excerpt(100); ?></p>
				</div>
				<!--/.content-->
			</article>
		
	
		<?php endwhile; wp_reset_postdata(); ?>
		</section>
		<!--/#sidebar-container-related-articles-->
		<div class="clear"></div>
	</section>
	<!--/#sidebar-container-->
	
</section>
<!--/#main-article-container-->

<?php
//get_sidebar( 'content' );
//get_sidebar();
get_footer();
