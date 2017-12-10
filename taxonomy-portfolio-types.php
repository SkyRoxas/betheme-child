<?php
/**
 * Taxanomy Portfolio Types
 *
 * @package Betheme
 * @author Muffin Group
 */

get_header();

// Class
$portfolio_classes 	= '';
$section_class 		= array();

// Class | Layout
if( $_GET && key_exists('mfn-p', $_GET) ){
	$portfolio_classes .= esc_html( $_GET['mfn-p'] ); // demo
} else {
	$portfolio_classes .= mfn_opts_get( 'portfolio-layout', 'grid' );
}

if( $portfolio_classes == 'list' ) $section_class[] = 'full-width';


// Class | Columns
if( $_GET && key_exists('mfn-pc', $_GET) ){
	$portfolio_classes .= ' col-'. esc_html( $_GET['mfn-pc'] ); // demo
} else {
	$portfolio_classes .= ' col-'. mfn_opts_get( 'portfolio-columns', 3 );
}


if( $_GET && key_exists('mfn-pfw', $_GET) )	$section_class[] = 'full-width'; // demo
if( mfn_opts_get('portfolio-full-width') )	$section_class[] = 'full-width';
$section_class = implode( ' ', $section_class );


// Ajax |  load more
$load_more = mfn_opts_get('portfolio-load-more');


// Translate
$translate['filter'] 		= mfn_opts_get('translate') ? mfn_opts_get('translate-filter','Filter by') : __('Filter by','betheme');
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

					<div class="column one column_portfolio">
						<div class="portfolio_wrapper isotope_wrapper">

							<?php
								$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
								$args = array(
									'post_type' 			=> 'portfolio',
									'posts_per_page' 		=> mfn_opts_get( 'portfolio-posts', 6 ),
									'paged' 				=> $paged,
									'order' 				=> mfn_opts_get( 'portfolio-order', 'DESC' ),
									'orderby' 				=> mfn_opts_get( 'portfolio-orderby', 'date' ),
									'taxonomy' 				=> 'portfolio-types',
									'term' 					=> get_query_var( 'term' ),	// WordPress 4.0 Portfolio Categories FIX
									'ignore_sticky_posts' 	=> 1,
								);

								global $query_string;
								parse_str( $query_string, $qstring_array );
								$query_args = array_merge( $args, $qstring_array );

								$portfolio_types_query = new WP_Query( $query_args );

							 	echo '<ul class="portfolio_group lm_wrapper isotope '. $portfolio_classes .'">';
							 		echo mfn_content_portfolio( $portfolio_types_query );
								echo '</ul>';

								echo mfn_pagination( $portfolio_types_query, $load_more );

							 	wp_reset_query();
							?>

						</div>
					</div>

				</div>
			</div>

		</div>

		<!-- .four-columns - sidebar -->
		<?php get_sidebar( 'taxonomy' ); ?>

	</div>
</div>

<?php get_footer();

// Omit Closing PHP Tags
