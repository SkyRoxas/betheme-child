<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

get_header();
?>

<!-- #Content -->
<div id="Content" class="p-5" style="box-sizing:border-box;">
	<div class="content_wrapper clearfix">

		<!-- .sections_group -->
		<div class="sections_group">

			<?php if( get_post_meta( get_the_ID(), 'mfn-post-template', true ) == 'builder' ):?>

				<?php
				$single_post_nav = array(
					'hide-sticky'	=> false,
					'in-same-term'	=> false,
				);

				$opts_single_post_nav = mfn_opts_get( 'prev-next-nav' );
				if( isset( $opts_single_post_nav['hide-sticky'] ) ){
					$single_post_nav['hide-sticky'] = true;
				}

				// single post navigation | sticky
				if( ! $single_post_nav['hide-sticky'] ){
					if( isset( $opts_single_post_nav['in-same-term'] ) ){
						$single_post_nav['in-same-term'] = true;
					}

					$post_prev = get_adjacent_post( $single_post_nav['in-same-term'], '', true );
					$post_next = get_adjacent_post( $single_post_nav['in-same-term'], '', false );

					echo mfn_post_navigation_sticky( $post_prev, 'prev', 'icon-left-open-big' );
					echo mfn_post_navigation_sticky( $post_next, 'next', 'icon-right-open-big' );
				}


				while( have_posts() ){
					the_post();							// Post Loop
					mfn_builder_print( get_the_ID() );	// Content Builder & WordPress Editor Content
				}
				?>

			<?php else: ?>

				<!-- Template | Builder -->

				<?php while (have_posts()) : the_post(); ?>

					<?php
					function get_field_image($field){
						echo '<img src="'.get_field($field)['url'].'" alt="'.get_field($field)['alt'].'">';
					}
					?>

					<div class="container">
						<div class="row">
							<div class="col-lg-3 col-12 mb-5">
								<?php get_field_image('icon_node'); ?>
							</div>
							<div class="col">
								<h3 class="single-title mt-2 mb-4"><?php the_title();?></h3>
								<?php the_content(); ?>
							</div>
						</div>
					</div>




					<?php //get_template_part( 'includes/content', 'single' ); ?>

				<?php endwhile; ?>

			<?php endif; ?>
		</div>

		<!-- .four-columns - sidebar -->
		<?php get_sidebar(); ?>

	</div>
</div>

<?php get_footer(); ?>
