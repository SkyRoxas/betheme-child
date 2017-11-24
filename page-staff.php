<?php
/**
 * The template for displaying all pages.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
get_header();
?>

<!-- #Content -->
<div id="Content">
	<div class="content_wrapper clearfix">

		<!-- .sections_group -->
		<div class="sections_group">

			<div class="entry-content doctor_list" itemprop="mainContentOfPage">



        <?php
          $args = [
						'posts_per_page' => -1,
						'post_type' => 'doctor',
						'order' => 'ASC',
					];
          $the_query = new WP_Query( $args );
					$count = 0;
        ?>

        <?php if ($the_query->have_posts()) : ?>
          <?php while ($the_query->have_posts()) : $the_query->the_post();?>
						<?php
						$count++;
      			$even_odd_class = ( ($count % 2) == 0 ) ? "even" : "odd";
						?>

						<div class="section mcb-section <?php print $even_odd_class?> ">
							<div class="section_wrapper mcb-section-inner">
								<div class="wrap mcb-wrap one-third  valign-top clearfix">
									<div class="image_wrapper">
										<?php $image = get_field('image'); ?>
										<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
									</div>
								</div>

								<div class="wrap mcb-wrap two-third  valign-top clearfix">
									<div class="mcb-wrap-inner">
										<div class="title_wrapper">
											<h2 class="title"> <?php the_title(); ?> 醫師</h2>
										</div>
										<div class="education_wrapper">
											<?php $education = get_field('education'); ?>
											<?php print $education ?>
										</div>
										<div class="body_wrapper">
											<?php the_content(); ?>
										</div>
										<div class="read_more">
											<?php
												$post_id = get_the_ID();
												$post_link = get_permalink($post_id);
											?>
											<a class="more" href="<?php print $post_link ?>">瞭解更多</a>
										</div>
									</div>
								</div>
							</div>
						</div>

          <?php endwhile; ?>
        <?php else: ?>
            <?php //No units for projects in this region ?>
        <?php endif; ?>

				<div class="section section-page-footer">
					<div class="section_wrapper clearfix">

						<div class="column one page-pager">
							<?php
								// List of pages
								wp_link_pages(array(
									'before'			=> '<div class="pager-single">',
									'after'				=> '</div>',
									'link_before'		=> '<span>',
									'link_after'		=> '</span>',
									'next_or_number'	=> 'number'
								));
							?>
						</div>

					</div>
				</div>

			</div>

			<?php if( mfn_opts_get('page-comments') ): ?>
				<div class="section section-page-comments">
					<div class="section_wrapper clearfix">

						<div class="column one comments">
							<?php comments_template( '', true ); ?>
						</div>

					</div>
				</div>
			<?php endif; ?>

		</div>

		<!-- .four-columns - sidebar -->
		<?php get_sidebar(); ?>

	</div>
</div>

<?php get_footer();

// Omit Closing PHP Tags
