<?php
get_header(); ?>

<div id="main-content" class="main-content">
<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					//get_template_part( 'content', 'page' );

					the_content();
				endwhile;
			?>
</div><!-- #main-content -->

<?php
//get_sidebar();
get_footer();
