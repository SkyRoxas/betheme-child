<?php
/**
 * The template for displaying all pages.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

get_header();
?>

<!-- #Content -->
<div id="Content">
	<div class="content_wrapper clearfix">
		<!-- .sections_group -->
		<div class="sections_group">
			<div class="entry-content" itemprop="mainContentOfPage">
        <?php
          $args = array(
												'post_type' => 'treatment_node',
												'posts_per_page' => -1,
												'orderby' => 'date',
												'order'   => 'ASC',
											 );

          $the_query = new WP_Query( $args );

					function get_field_image($field){
						echo '<img src="'.get_field($field)['url'].'" alt="'.get_field($field)['alt'].'">';
					}

        ?>
				<div class="article-list treatment">
					<?php $counter=0; ?>
        	<?php if ($the_query->have_posts()) : ?>
          	<?php while ($the_query->have_posts()) : $the_query->the_post();?>

							<?php
							$count++;
	      			$even_odd_class = ( ($count % 2) == 0 ) ? "even" : "odd";
							?>

							<article class="d-flex <?php echo $even_odd_class;?>">
								<div class="wrap col col-md-5 d-flex align-items-center" style="padding:10px 50px; box-sizing:border-box;">
									<div>
										<div class="d-flex align-items-end" style="margin-bottom:30px;">
											<a href="<?php the_permalink();?>">
												<?php get_field_image('icon_list'); ?>
											</a>
											<h3>
												<a href="<?php the_permalink();?>">
                					<?php the_title(); ?>
              					</a>
											</h3>
										</div>
										<div style="margin-bottom:15px;">
											<?php echo wp_trim_words( get_the_content(), 120, '...' );?>
										</div>
										<div>
											<a class="more-link" href="<?php echo the_permalink();?>"><h5>瞭解更多</h5></a>
										</div>
									</div>
								</div>
								<div class="wrap col col-md-5">
									<a href="<?php the_permalink();?>">
										<?php the_post_thumbnail('575X420'); ?>
									</a>
								</div>
							</article>
          <?php endwhile; ?>
        <?php else: ?>
            <?php //No units for projects in this region ?>
        <?php endif; ?>
					</div>

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
