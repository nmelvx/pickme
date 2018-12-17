<?php
/**
 * Front Page
 *
 * @package WordPress
 * @subpackage PickME
 * @since 1.0.0
 */

get_header();
?>

<div class="container content_home">
	<div class="row">
		<div class="col-md-8 col-xs-12">
			<div class="row display-table">
				<div class="col-xs-6 interested_for_submision">
					<h2><?php pll_e('Interested for admission ?'); ?></h2>
					<ul>
						<li><a href="why-choose-pick-me-academy.php" title="<?php pll_e('Why choose Pick Me Academy'); ?>"><?php pll_e('Why choose Pick Me Academy'); ?></a></li>
						<li><a href="admission.php" title="<?php pll_e('Application Forms'); ?>"><?php pll_e('Application Forms'); ?></a></li>
						<li><a href="about_us_philosophy.php" title="<?php pll_e('Philosophy'); ?>"><?php pll_e('Philosophy'); ?></a></li>
						<li><a href="about_us_cv.php" title="<?php pll_e('Curriculum Overview'); ?>"><?php pll_e('Curriculum Overview'); ?></a></li>
						<li><a href="about_us_our_staff.php" title="<?php pll_e('Our Staff'); ?>"><?php pll_e('Our Staff'); ?></a></li>
						<li><a href="admission.php#fees" title="<?php pll_e('Fees'); ?>"><?php pll_e('Fees'); ?></a></li>
					</ul>
				</div>
				<div class="col-xs-6 already_a_member">
					<h2><?php pll_e('Already a member'); ?></h2>
					<ul>
						<li><a href="https://app.kinderunity.com/#/login" target="_blank" title="<?php pll_e('Parent login'); ?>"><?php pll_e('Parent login'); ?></a></li>
						<li><a href="about_us_cv.php" title="<?php pll_e('Curriculum'); ?>"><?php pll_e('Curriculum'); ?></a></li>
						<li><a href="about_us_policies_calendar.php" title="<?php pll_e('Calendar'); ?>"><?php pll_e('Calendar'); ?></a></li>
						<li><a href="medical.php" title="<?php pll_e('Medical'); ?>"><?php pll_e('Medical'); ?></a></li>
						<li><a href="/" title="<?php pll_e('Weekly Menu'); ?>"><?php pll_e('Weekly Menu'); ?></a></li>
						<li><a href="#" title="<?php pll_e('Gallery'); ?>"><?php pll_e('Gallery'); ?></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-xs-12 whats_new">
			<h2><?php pll_e('What\'s new for Pick Me'); ?></h2>
			<div class="news_sidebar">
				<span class="news_date">08 Jan 2017</span>
				<h3 class="title">Raising Bilingual Children</h3>
				<p class="content_news">True bilingualism can’t be taught; it must be experienced. Successful true bilingualism requires that both languages themselves</p>
				<a class="read_more" href="/raising-bilingual-children.php">Read more...</a>
			</div>
			<div class="news_sidebar">
				<span class="news_date">19 Jan 2017</span>
				<h3 class="title">How to encourage good behaviour in your child</h3>
				<p class="content_news">A positive and constructive approach is often the best way to guide your child’s behaviour. This means giving your child attention</p>
				<a class="read_more" href="/how-to-encourage-good-behaviour-in-your-child.php">Read more...</a>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-md-8 col-xs-12 lets_meet">
					<img src="<?php bloginfo('template_url'); ?>/images/google_map_icon.jpg" alt="Let's Meet !" title="Let's Meet !">
					<div class="lets_meet_content">
						<h2>Let's meet !</h2>
						<p>If you intend to book a private tour, please let us now <span>by email.</span> You can visit us in one of our locations:</p>
						<ul>
							<li><span>55th, Spatarul Nicolae Milescu</span></li>
							<li><span>9th, Dragos Voda</span></li>
							<li><span>No.79, Agricultori Street</span></li>
						</ul>
					</div>
				</div>
				<div class="col-md-4 col-xs-12 stay_in_touch">
					<h2><?php pll_e('Stay in touch with us'); ?></h2>
					<p><?php pll_e('Should you have questions, require more information or like to be informed about our activities, please leave your email address below:'); ?></p>
					
					<?php echo do_shortcode('[mailpoet_form id="1"]'); ?>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="testimonial_carusel owl-carousel owl-theme">
					<div class="col-xs-12 testimonials">
						<img class="qoutes_left" src="<?php bloginfo('template_url'); ?>/images/qoutes_left.jpg" alt="quote-left">
						<img class="qoutes_right" src="<?php bloginfo('template_url'); ?>/images/qoutes_right.jpg" alt="quote-right">
						<div class="testimonial_content">
							<p class="name">Andreea P. -Robert Mother</p>
							<p class="text">Indeed, super and special team!! Knew it from the first day, felt the love, implication and professionalism that has led to the special place where all these children are raised and helped with love to put the first steps in life! That is why I Picked you</p>
						</div>
					</div>
					<div class="col-xs-12 testimonials">
						<img class="qoutes_left" src="<?php bloginfo('template_url'); ?>/images/qoutes_left.jpg" alt="quote-left">
						<img class="qoutes_right" src="<?php bloginfo('template_url'); ?>/images/qoutes_right.jpg" alt="quote-right">
						<div class="testimonial_content">
							<p class="name">Ileana A. -Maria s mother</p>
							<p class="text">A special place full of love and respect for children. Professionalism in all they do, and well managed curriculum. Perfect choice for my child.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
		
</div>

<?php
get_footer();
?>