<?php

//require_once 'kint.php';

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

function bonze_tml_registration_errors( $errors ) {
	if ( empty( $_POST['name'] ) )
		$errors->add( 'empty_name', '<strong>錯誤</strong>: 請輸入你的姓名' );
	if ( empty( $_POST['phone'] ) )
		$errors->add( 'empty_phone', '<strong>錯誤</strong>: 請輸入你的電話' );
	return $errors;
}
add_filter( 'registration_errors', 'bonze_tml_registration_errors' );


function bonze_tml_user_register( $user_id ) {
	if ( !empty( $_POST['name'] ) )
		update_user_meta( $user_id, 'name', $_POST['name'] );
	if ( !empty( $_POST['phone'] ) )
		update_user_meta( $user_id, 'phone', $_POST['phone'] );
}
add_action( 'user_register', 'bonze_tml_user_register' );
