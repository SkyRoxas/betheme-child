<?php

require_once 'kint.php';

/* ---------------------------------------------------------------------------
 * Child Theme URI | DO NOT CHANGE
 * --------------------------------------------------------------------------- */
define( 'CHILD_THEME_URI', get_stylesheet_directory_uri() );


/* ---------------------------------------------------------------------------
 * Define | YOU CAN CHANGE THESE
 * --------------------------------------------------------------------------- */

// White Label --------------------------------------------
define( 'WHITE_LABEL', false );

// Static CSS is placed in Child Theme directory ----------
define( 'STATIC_IN_CHILD', false );


/* ---------------------------------------------------------------------------
 * Enqueue Style
 * --------------------------------------------------------------------------- */
add_action( 'wp_enqueue_scripts', 'mfnch_enqueue_styles', 101 );
function mfnch_enqueue_styles() {

	// Enqueue the parent stylesheet
	// 	wp_enqueue_style( 'parent-style', get_template_directory_uri() .'/style.css' );		//we don't need this if it's empty

	wp_enqueue_style( 'custom', CHILD_THEME_URI .'/css/style.css' );



	// Enqueue the parent rtl stylesheet
	if ( is_rtl() ) {
		wp_enqueue_style( 'mfn-rtl', get_template_directory_uri() . '/rtl.css' );
	}

	// Enqueue the child stylesheet
	wp_dequeue_style( 'style' );
	wp_enqueue_style( 'style', get_stylesheet_directory_uri() .'/style.css' );

}


/* ---------------------------------------------------------------------------
 * Load Textdomain
 * --------------------------------------------------------------------------- */
add_action( 'after_setup_theme', 'mfnch_textdomain' );
function mfnch_textdomain() {
    load_child_theme_textdomain( 'betheme',  get_stylesheet_directory() . '/languages' );
    load_child_theme_textdomain( 'mfn-opts', get_stylesheet_directory() . '/languages' );
}


/* ---------------------------------------------------------------------------
 * Override theme functions
 *
 * if you want to override theme functions use the example below
 * --------------------------------------------------------------------------- */
// require_once( get_stylesheet_directory() .'/includes/content-portfolio.php' );
//
function excerpt_length_example(){
      return 120;
}

add_filter( 'excerpt_length', 'excerpt_more_example' );


function add_custom_sizes()
{
    add_image_size('575X420', 575, 445, array( 'center', 'center'));
		add_image_size('190X190', 190, 190, array( 'center', 'center'));
		add_image_size('330Xauto', 330, 'auto', array( 'center', 'center'));
		add_image_size('342X368', 342, 368 , array( 'center', 'center'));
}
add_action('after_setup_theme', 'add_custom_sizes');

/**
 * Hides the custom post template for pages on WordPress 4.6 and older
 *
 * @param array $post_templates Array of page templates. Keys are filenames, values are translated names.
 * @return array Filtered array of page templates.
 */
function bonze_page_templates( $post_templates ) {
    if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
        unset( $post_templates['templates/events-list-template.php'] );
    }

    return $post_templates;
}

add_filter( 'theme_page_templates', 'bonze_page_templates' );
/**
 * My custom registr field
 * @param  array $errors  error message
 * @return array          change error message
 */
function bonze_tml_registration_errors( $errors ) {
	if ( empty( $_POST['name'] ) ){
		$errors->add( 'empty_name', '<strong>錯誤</strong>: 請輸入你的姓名' );
	}

	if ( empty( $_POST['phone'] ) ){
		$errors->add( 'empty_phone', '<strong>錯誤</strong>: 請輸入你的電話' );
	}

	return $errors;
}
add_filter( 'registration_errors', 'bonze_tml_registration_errors' );

/**
 * My custom user meta
 * @param  int   $user_id new register user id
 */
function bonze_tml_user_register( $user_id ) {
	if ( !empty( $_POST['name'] ) ){
		update_user_meta( $user_id, 'first_name', sanitize_text_field($_POST['name']) );
	}
	if ( !empty( $_POST['phone'] ) ){
		update_user_meta( $user_id, 'billing_phone', sanitize_text_field($_POST['phone']) );
	}
	if(!empty($_POST['user_doctor_no'])){
		update_user_meta( $user_id, 'doctor_no', sanitize_text_field($_POST['user_doctor_no']) );
	}
}
add_action( 'user_register', 'bonze_tml_user_register' );

function bonze_get_portfilio_category($atts)
{
		$markup;
		$terms = get_terms( array(
    	'taxonomy' => 'portfolio-types',
    	'hide_empty' => false,
		));

		foreach ($terms as $key => $term) {
			$markup.= '<li class="cat-item cat-item-'.$term->term_id .'">
										<a href="'. get_term_link($term->slug,$term->taxonomy) .'"> ' . $term->name . ' </a>
								</li>';
		}

		return '<ul>
			'.$markup.'
		</ul>';
}

add_shortcode('portfilio-category', 'bonze_get_portfilio_category');

function bonze_get_event_category($atts)
{
		$markup;
		$terms = get_terms( array(
    	'taxonomy' => 'event',
    	'hide_empty' => false,
		));

		foreach ($terms as $key => $term) {
			$markup.= '<li class="cat-item cat-item-'.$term->term_id .'">
										<a href="'. get_term_link($term->slug,$term->taxonomy) .'"> ' . $term->name . ' </a>
								</li>';
		}

		return '<ul>
			'.$markup.'
		</ul>';
}

add_shortcode('event-category', 'bonze_get_event_category');

function bonze_get_event_posts($atts) {
	$markup;

	$args = [
		'posts_per_page' => 2,
		'post_type' => 'tribe_events',
		'order' => 'DESC',
	];

	$the_query = new WP_Query( $args );

		while ($the_query->have_posts()) {
			$the_query->the_post();
			$post = get_post();

			$markup.= '<div class="entity-event"><div class="img_wrapper">
										<a href="'. get_post_permalink($post) .'">'. get_the_post_thumbnail($post,'190X190') .'</a>
								</div>
								<div class="title">
									<a href="'. get_post_permalink($post) .'">'. $post->post_title .'</a>
								</div>
			</div>';
		}

	return $markup;
}

add_shortcode('event-posts', 'bonze_get_event_posts');
