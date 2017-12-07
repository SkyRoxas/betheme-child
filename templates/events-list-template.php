<?php
/*
Template Name: Events List Template
Template Post Type: post, page, event
*/
$user_role = bonze_get_current_user_role();
$allowed_roles = array('doctor', 'administrator', 'shop_manager');
if(in_array($user_role, $allowed_roles)){

}else{
	global $wp_query;
    $wp_query->set_404();
    status_header(404);
	include_once( get_query_template( '404' ) );
	die();
}

get_header();

?>

<!-- #Content -->
<div id="Content" class="with_aside p-3">
	<div class="content_wrapper clearfix">

		<!-- .sections_group -->
		<div class="sections_group">

			<div class="entry-content" itemprop="mainContentOfPage">

				<?php
					while ( have_posts() ){
						the_post();							// Post Loop
						mfn_builder_print( get_the_ID() );	// Content Builder & WordPress Editor Content
					}
				?>

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
		<div class="sidebar sidebar-1 four columns">
			<div class="widget-area clearfix">
				<?php dynamic_sidebar( 'sidebar-event_sidbar' ); ?>
			</div>
		</div>
	</div>
</div>

<?php get_footer();

// Omit Closing PHP Tags
