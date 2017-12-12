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
			<div class="entry-content p-5" itemprop="mainContentOfPage">
				<div id="message"></div>
				<script type="text/javascript">
					if(location.search === "?pending=approval"){
						document.getElementById('message').innerHTML = '<h4 class="text-center text-success" style="margin-bottom:100px; line-height:50px;">恭喜您註冊完成 ! </br> 待管理員審核通過後，即可進行登入</h4>'
					}
				</script>
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-12 d-flex justify-content-center mb-5">
              <?php dynamic_sidebar( 'bonze_theme-my-login' ); ?>
            </div>
            <div class="col-md-6 col-12 d-flex justify-content-center align-items-center">
              <?php echo do_shortcode( '[theme-my-login show_title = "0"]' ); ?>
            </div>
          </div>
        </div>
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
	<?php get_footer(); ?>
</div>



// Omit Closing PHP Tags
