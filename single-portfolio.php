<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

get_header();

$class = '';
if( get_post_meta( get_the_ID(), 'mfn-post-template', true ) == 'builder' ) $class .= 'no-padding';
?>

<!-- #Content -->
<div id="Content" class="<?php echo $class; ?>">
	<div class="content_wrapper clearfix">

		<!-- .sections_group -->
		<div class="sections_group px-3">

			<?php if( get_post_meta( get_the_ID(), 'mfn-post-template', true ) == 'builder' ): ?>
				<?php
				// Template | Builder -----------------------------------------------

				// prev & next post navigation
				mfn_post_navigation_sort();

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

					$post_prev = get_adjacent_post( $single_post_nav['in-same-term'], '', true, 'portfolio-types' );
					$post_next = get_adjacent_post( $single_post_nav['in-same-term'], '', false, 'portfolio-types' );

					echo mfn_post_navigation_sticky( $post_prev, 'prev', 'icon-left-open-big' );
					echo mfn_post_navigation_sticky( $post_next, 'next', 'icon-right-open-big' );
				}


				while( have_posts() ){
					the_post();							// Post Loop
					mfn_builder_print( get_the_ID() );	// Content Builder & WordPress Editor Content
				}
				 ?>
				<?php else: ?>
					<?php while( have_posts() ): the_post();?>
						<div class="field field-title mb-4">
							<h2><?php the_title(); ?></h2>
						</div>
						<div class="field field-info d-flex mb-4">
							<div>
								<?php the_time('m 月 d 日 G:i') ?>
							</div>
							<div class="mx-2">
								<?php echo "/";  ?>
							</div>
							<div>
								<?php $terms = get_the_terms( $post->ID , 'portfolio-types' ); ?>
								<?php foreach ($terms as $key => $term): ?>
									<li style="list-style:none;">
										<a class="color-inherit" href ="<?php echo get_term_link($term->slug,$term->taxonomy) ?>"><?php echo $term -> name ?></a>
									</li>
								<?php endforeach; ?>
							</div>
						</div>
						<div class="field field-image mb-5">
							<?php the_post_thumbnail('685X455'); ?>
						</div>
						<div class="field field-content">
							<?php the_content(); ?>
						</div>
					<?php endwhile; ?>
			<?php endif; ?>

		</div>

		<!-- .four-columns - sidebar -->
		<?php get_sidebar(); ?>

	</div>
</div>

<?php get_footer();

// Omit Closing PHP Tags
