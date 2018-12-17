<?php
/**
 * The template for displaying all single posts
 *
 * @package WordPress
 * @subpackage PickME
 * @since 1.0.0
 */

get_header();
?>
	<?php if ( has_post_thumbnail() ): ?>
	<div class="container-fluid">
		<div class="img_header">
			<?php the_post_thumbnail('full'); ?>
		</div>
	</div>
	<?php endif; ?>
	<div class="container content-text <?=( has_post_thumbnail() )? 'margined':''?>">
	<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content/content', 'page' );

		endwhile; 
	?>
	</div>

<?php
get_footer();