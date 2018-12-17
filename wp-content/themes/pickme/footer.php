<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package WordPress
 * @subpackage PickME
 * @since 1.0.0
 */

?>

<div class="container">
	<div class="row">
		<div class="col-xs-12 footer_logos text-center">
			<div class="logos">
				<img src="<?php bloginfo('template_url'); ?>/images/logo_footer/aracip.jpg" alt="" title="">
			</div>
			<div class="logos">
				<img src="<?php bloginfo('template_url'); ?>/images/logo_footer/ci.jpg" alt="" title="">
			</div>
			<div class="logos">
				<img src="<?php bloginfo('template_url'); ?>/images/logo_footer/cobis-member.jpg" alt="" title="">
			</div>
		</div>
	</div>
</div>
<div class="container-fluid footer">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 text-center">
				<ul style="display: inline-block">
					<li>Email: contact@gradinitapickme.ro</li>
					<li>Mobile: 0726 000 640 / 0722 391 000</li>
					<li>
						We are social: 
						<a href="https://www.facebook.com/pickmeacademy" target="_blank">
							<img class="fb_icon" src="<?php bloginfo('template_url'); ?>/images/fb_icon.png" alt="Facebook Pickme Academy" title="Facebook Pickme Academy">
						</a>
					</li>
				</ul>
			</div>
		</div>					
	</div>
</div>

<?php wp_footer(); ?>

</body>
</html>
