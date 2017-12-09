<?php

// require_once 'kint.php';

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
	wp_enqueue_script('myscripts', CHILD_THEME_URI . '/js/scripts.js');


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
		$markup='';
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
		$markup='';
		$terms = get_terms( array(
    	'taxonomy' => 'tribe_events_cat',
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
	$markup='';

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
		wp_reset_postdata();
	return $markup;
}

add_shortcode('event-posts', 'bonze_get_event_posts');


/**
 * Defines alternative titles for various event views.
 *
 * @param  string $title
 * @return string
 */
function bonze_change_event_title( $title ) {
	// Single events
	if ( tribe_is_event() && is_single() ) {
		// $title = 'Single event page';
	}
	// Single venues
	elseif ( tribe_is_venue() ) {
		// $title = 'Single venue page';
	}
	// Single organizers
	elseif ( tribe_is_organizer() && is_single() ) {
		// $title = 'Single organizer page';
	}
	// Month view Page
	elseif ( tribe_is_month() && !is_tax() ) {
		// $title = 'Month view page';
	}
	// Month view category page
	elseif ( tribe_is_month() && is_tax() ) {
		// $title = 'Month view category page';
	}
	// List view page: upcoming events
	elseif ( tribe_is_upcoming() && ! is_tax() ) {
		$title = '進修與學習';
	}
	// List view category page: upcoming events
	elseif ( tribe_is_upcoming() && is_tax() ) {
		// $title = 'List view category: upcoming events page';
	}
	// List view page: past events
	elseif ( tribe_is_past() && !is_tax() ) {
		// $title = 'List view: past events page';
	}
	// List view category page: past events
	elseif ( tribe_is_past() && is_tax() ) {
		// $title = 'List view category: past events page';
	}

	// Day view page
	elseif ( tribe_is_day() && ! is_tax() ) {
		// $title = 'Day view page';
	}
	// Day view category page
	elseif ( tribe_is_day() && is_tax() ) {
		// $title = 'Day view category page';
	}

	return $title;
}

/**
 * Modifes the event <title> element.
 *
 * Users of Yoast's SEO plugin may wish to try replacing the below line with:
 *
 *     add_filter('wpseo_title', 'filter_events_title' );
 */
add_filter( 'tribe_get_events_title', 'bonze_change_event_title',999 );

function bonze_register_widgets_init() {

    register_sidebar( array(
        'name'          => 'bonze_theme-my-login',
        'id'            => 'bonze_theme-my-login',
        'before_widget' => '<div class ="widget-item">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

}
add_action( 'widgets_init', 'bonze_register_widgets_init' );

function bonze_woocommerce_disable_shop_page() {
    global $post;
    if (is_shop()){
		global $wp_query;
	    $wp_query->set_404();
	    status_header(404);
	}

}
add_action( 'wp', 'bonze_woocommerce_disable_shop_page' );

function bonze_hide_admin_menu() {
	if(is_admin()){
		$roles = wp_get_current_user()->roles;
	    if ($roles[0]=='shop_manager') {
	        // edit.php?post_type=client
			remove_menu_page( 'edit.php?post_type=client' );
			remove_menu_page( 'edit.php?post_type=offer' );
			remove_menu_page( 'edit.php?post_type=slide' );
			remove_menu_page( 'edit.php?post_type=testimonial' );
			remove_menu_page( 'edit.php?post_type=layout' );
			remove_menu_page( 'edit.php?post_type=template' );
			remove_menu_page( 'tools.php' );
			remove_menu_page( 'edit-comments.php' );
			remove_menu_page( 'vc-welcome' );
	    }
	}
}

add_action('admin_menu', 'bonze_hide_admin_menu',999);

//open content block for VC
add_filter('content_block_post_type', '__return_true');

//使用 content block 時會被當作一般的 post 被安插其他處理，自己包過來用
//ref: https://tw.wordpress.org/plugins/custom-post-widget/
function knockers_custom_post_widget_shortcode($atts) {
	extract(shortcode_atts(array(
		'id' => '',
		'slug' => '',
		'class' => 'content_block',
		'suppress_content_filters' => 'yes', //預設不走 the_content 的事件，避免被其他方法給包過
		'title' => 'no',
		'title_tag' => 'h3',
		'only_img' => 'no', //僅輸出特色圖片連結
	), $atts));

	if ($slug) {
		$block = get_page_by_path($slug, OBJECT, 'content_block');
		if ($block) {
			$id = $block->ID;
		}
	}

	$content = "";

	if ($id != "") {
		$args = array(
			'post__in' => array($id),
			'post_type' => 'content_block',
		);

		$content_post = get_posts($args);

		foreach ($content_post as $post):
			$content .= '<div class="' . esc_attr($class) . '" id="custom_post_widget-' . $id . '">';
			if ($title === 'yes') {
				$content .= '<' . esc_attr($title_tag) . '>' . $post->post_title . '</' . esc_attr($title_tag) . '>';
			}
			if ($suppress_content_filters === 'no') {
				$content .= apply_filters('the_content', $post->post_content);
			} else {
				if (has_shortcode($post->post_content, 'content_block') || has_shortcode($post->post_content, 'ks_content_block')) {
					$content .= $post->post_content;
				} else {
					$content .= do_shortcode($post->post_content);
				}
			}
			$content .= '</div>';
		endforeach;
	}
	if ($only_img == "yes") {
		$featured_image = get_the_post_thumbnail_url($id, 'full');
		return $featured_image ? $featured_image : $content;
	}
	return $content;
}
add_shortcode('ks_content_block', 'knockers_custom_post_widget_shortcode');

function bonze_remove_admin_bar_links() {
	if(is_admin()){
		global $wp_admin_bar;
		$roles = wp_get_current_user()->roles;
		if ($roles[0]=='shop_manager') {
			$wp_admin_bar->remove_menu('updates');          // Remove the updates link
	        $wp_admin_bar->remove_menu('comments');         // Remove the comments link
	        $wp_admin_bar->remove_menu('new-content');      // Remove the content link
	        $wp_admin_bar->remove_menu('w3tc');             // If you use w3 total cache remove the performance link
	        $wp_admin_bar->remove_menu('my-account');       // Remove the user details tab
			$wp_admin_bar->remove_menu('wp-logo');
			$wp_admin_bar->remove_menu('tribe-events');
			$wp_admin_bar->remove_menu('search');
			$wp_admin_bar->remove_menu('revslider');
		}
	}

}
add_action( 'wp_before_admin_bar_render', 'bonze_remove_admin_bar_links',999 );

add_action('manage_users_columns','bonze_modify_user_columns');
function bonze_modify_user_columns($column_headers) {
  unset($column_headers['posts']);
  $column_headers['doctor_no'] = '醫師證號';
  return $column_headers;
}

add_action('manage_users_custom_column', 'bonze_user_doctor_no_column_content', 10, 3);
function bonze_user_doctor_no_column_content($value, $column_name, $user_id)
{
	$all_meta_for_user = get_user_meta( $user_id );
	switch ($column_name) {
        case 'doctor_no' :
            return get_the_author_meta( 'doctor_no', $user_id );
            break;
        default:
    }
  return $value;
}

//make the new column sortable
function bonze_user_sortable_columns( $columns ) {
    $columns['doctor_no'] = 'doctor_no';
    return $columns;
}
add_filter( 'manage_users_sortable_columns', 'bonze_user_sortable_columns' );

add_action( 'after_setup_theme', 'bonze_register_menu' );
function bonze_register_menu() {
  register_nav_menu( 'submenu', __( 'Submenu', 'theme-slug' ) );
}

add_action( 'woocommerce_save_account_details', 'bonze_woocommerce_save_account_details',99 );

function bonze_woocommerce_save_account_details( $user_id ) {

  update_user_meta( $user_id, 'doctor_no', htmlentities( $_POST[ 'account_doctor_no' ] ) );

  $user = wp_update_user( array( 'ID' => $user_id, 'user_url' => esc_url( $_POST[ 'url' ] ) ) );

}

function add_helpful_user_classes() {
    if ( is_user_logged_in() ) {
        add_filter('body_class','bonze_class_to_body');
    }
}
add_action('init', 'add_helpful_user_classes');

/// Add user role class to front-end body tag
function bonze_class_to_body($classes) {
    global $current_user;
    $user_role = array_shift($current_user->roles);
    $classes[] = $user_role.' ';
    return $classes;
}

function bonze_get_current_user_role() {
  if( is_user_logged_in() ) {
    $user = wp_get_current_user();
    $role = ( array ) $user->roles;
    return $role[0];
  } else {
    return false;
  }
 }
