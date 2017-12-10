<?php
/**
 * The main template file.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

get_header();

// Class
$blog_classes 	= array();
$section_class 	= array();


// Class | Layout
if( $_GET && key_exists( 'mfn-b', $_GET ) ){
	$blog_layout = esc_html( $_GET['mfn-b'] ); // demo
} else {
	$blog_layout = mfn_opts_get( 'blog-layout', 'classic' );
}
$blog_classes[] = $blog_layout;

// Layout | Masonry Tiles | Quick Fix
if( $blog_layout == 'masonry tiles' ){
	$blog_layout = 'masonry';
}


// Class | Columns
if( $_GET && key_exists( 'mfn-bc', $_GET ) ){
	$blog_classes[] = 'col-'. esc_html( $_GET['mfn-bc'] ); // demo
} else {
	$blog_classes[] = 'col-'. mfn_opts_get( 'blog-columns', 3 );
}


// Full width
if( $_GET && key_exists( 'mfn-bfw', $_GET ) ){
	$section_class[] = 'full-width'; // demo
}
if( mfn_opts_get( 'blog-full-width' ) && ( $blog_layout == 'masonry' ) ){
	$section_class[] = 'full-width';
}
$section_class = implode( ' ', $section_class );


// Isotope
if( $_GET && key_exists( 'mfn-iso', $_GET ) ){
	$isotope = true; // demo
} elseif(  mfn_opts_get( 'blog-isotope' ) ) {
	$isotope = true;
} else {
	$isotope = false;
}

if( $isotope || ( $blog_layout == 'masonry' ) ){
	$blog_classes[] = 'isotope';
}


// Ajax | load more
$load_more = mfn_opts_get( 'blog-load-more' );


// Translate
$translate['filter'] 		= mfn_opts_get('translate') ? mfn_opts_get('translate-filter','Filter by') : __('Filter by','betheme');
$translate['tags'] 			= mfn_opts_get('translate') ? mfn_opts_get('translate-tags','Tags') : __('Tags','betheme');
$translate['authors'] 		= mfn_opts_get('translate') ? mfn_opts_get('translate-authors','Authors') : __('Authors','betheme');
$translate['all'] 			= mfn_opts_get('translate') ? mfn_opts_get('translate-all','Show all') : __('Show all','betheme');
$translate['categories'] 	= mfn_opts_get('translate') ? mfn_opts_get('translate-categories','Categories') : __('Categories','betheme');
$translate['item-all'] 		= mfn_opts_get('translate') ? mfn_opts_get('translate-item-all','All') : __('All','betheme');
?>

<!-- #Content -->
<div id="Content">
	<div class="content_wrapper clearfix">

		<!-- .sections_group -->
		<div class="sections_group">
			<div class="section <?php echo $section_class; ?>">
				<div class="section_wrapper clearfix">

					<div class="column one column_blog">
						<div class="blog_wrapper isotope_wrapper">

							<div class="posts_group lm_wrapper <?php echo implode( ' ', $blog_classes ); ?>">
								<?php

									// Featured images | available types

									$featured_image = '';	// all
									if( $load_more ){
										$featured_image = 'no_slider';	// no slider if load more
									}
									if( mfn_opts_get( 'blog-images' ) ){
										$featured_image = 'image';	// images only option
									}

									echo mfn_content_post( false, false, $featured_image );
								?>
							</div>

							<?php
								// pagination
								if( function_exists( 'mfn_pagination' ) ):

									echo mfn_pagination( false, $load_more );

								else:
									?>
										<div class="nav-next"><?php next_posts_link(__('&larr; Older Entries', 'betheme')) ?></div>
										<div class="nav-previous"><?php previous_posts_link(__('Newer Entries &rarr;', 'betheme')) ?></div>
									<?php
								endif;
							?>

						</div>
					</div>

				</div>
			</div>


		</div>

		<!-- .four-columns - sidebar -->
		<?php get_sidebar( 'blog' ); ?>

	</div>
</div>

<?php get_footer();

// Omit Closing PHP Tags
