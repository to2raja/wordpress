	<?php if(is_front_page() || is_category()): ?>
		<section id="tips-container">
			<h2>Tips for Protecting Yourself</h2>
			<div class="wrapper">
				<?php 
				$args = array('cat' => 6, 'posts_per_page' => 6, 'orderby' => 'date', 'order' => 'DESC');
				$query = new WP_Query($args);
				while($query->have_posts()):
					$query->the_post();
				?>
				<article class="tip">
					<div class="content">
						<h3><a href="<?php echo get_permalink(); ?>"><?php echo the_title(); ?></a></h3>
						<p><?php echo get_excerpt(140); ?></p>
					</div>
				</article>
				<?php 
				endwhile;
				wp_reset_postdata();
				?>
			</div>

		</section>
		<?php endif; ?>
		
		 <footer>
            <ul>
                <li class="main segment">
                    <p>  <a href="/eua/">Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem IpsumLorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum
                    Lorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem Ipsum</a>.</p>
                    <ul class="policy-links">
                        <li><a href="/about/privacy-policy/online-privacy-policy/index.html" target="_blank">Privacy Policy</a></li>
                        <li><a href="/coppa/">COPPA Privacy Policy</a></li>
                        <li><a href="/guarantee/">Service Guarantee</a></li>
                        <li><a href="/frequently-asked-questions/">FAQ</a></li>
                    </ul>
                    <p>Copyright 2014 ACME, Inc. | ACME © 2014 ACME Worldwide I [exp0915][All States][DC]</p>
                </li>
                <li class="contact segment">
                    <p>Have a question or comment? <br><a href="/email-us">Contact
                    us</a> <span class="or">or</span> call: <span class=
                    "tel">1-888-000-0000</span></p>
                </li>

                <li class="social segment">
                    <ul>
                        <li class="googleplus"><a href=
                        "https://plus.google.com/share?url=http%3A%2F%2Fwww./">
                        Google+</a></li>

                        <li class="facebook"><a href=
                        "http://www.facebook.com/sharer.php?u=http%3A%2F%2Fwww./">
                        Facebook</a></li>

                        <li class="twitter"><a href=
                        "https://twitter.com/intent/tweet?text=Protect%20yourself%20and%20your%20family%20with%20MetLife%20Defender.%20http://www./">
                        Twitter</a></li>
                    </ul>
                </li>
            </ul>
        </footer>
		<?php wp_footer(); ?>
        
	</body>
</html>
