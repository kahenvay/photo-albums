<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://tredny.com
 * @since             1.0.0
 * @package           Tdy_Pa
 *
 * @wordpress-plugin
 * Plugin Name:       Tredny Photo Albums
 * Plugin URI:        https://github.com/kahenvay/photo-albums
 * Description:       Tredny Photo Albums plugin to organise your media in a tredny manner.
 * Version:           1.0.0
 * Author:            Ulysse Coates
 * Author URI:        https://tredny.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tdy-pa
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PHOTO_ALBUMS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tdy-pa-activator.php
 */
function activate_tdy_pa() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tdy-pa-activator.php';
	Tdy_Pa_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tdy-pa-deactivator.php
 */
function deactivate_tdy_pa() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tdy-pa-deactivator.php';
	Tdy_Pa_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_tdy_pa' );
register_deactivation_hook( __FILE__, 'deactivate_tdy_pa' );


/**
* Register Custom Photo album
*/
function custom_post_type() {

		$labels = array(
			'name'                  => _x( 'Photo albums', 'Photo album General Name', 'tdy_pa_text_domain' ),
			'singular_name'         => _x( 'Photo album', 'Photo album Singular Name', 'tdy_pa_text_domain' ),
			'menu_name'             => __( 'Photo albums', 'tdy_pa_text_domain' ),
			'name_admin_bar'        => __( 'Photo album', 'tdy_pa_text_domain' ),
			'archives'              => __( 'Album Archives', 'tdy_pa_text_domain' ),
			'attributes'            => __( 'Album Attributes', 'tdy_pa_text_domain' ),
			'parent_item_colon'     => __( 'Parent Album:', 'tdy_pa_text_domain' ),
			'all_items'             => __( 'All Albums', 'tdy_pa_text_domain' ),
			'add_new_item'          => __( 'Add New Album', 'tdy_pa_text_domain' ),
			'add_new'               => __( 'Add New', 'tdy_pa_text_domain' ),
			'new_item'              => __( 'New Album', 'tdy_pa_text_domain' ),
			'edit_item'             => __( 'Edit Album', 'tdy_pa_text_domain' ),
			'update_item'           => __( 'Update Album', 'tdy_pa_text_domain' ),
			'view_item'             => __( 'View Album', 'tdy_pa_text_domain' ),
			'view_items'            => __( 'View Albums', 'tdy_pa_text_domain' ),
			'search_items'          => __( 'Search Album', 'tdy_pa_text_domain' ),
			'not_found'             => __( 'Not found', 'tdy_pa_text_domain' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'tdy_pa_text_domain' ),
			'featured_image'        => __( 'Featured Image', 'tdy_pa_text_domain' ),
			'set_featured_image'    => __( 'Set featured image', 'tdy_pa_text_domain' ),
			'remove_featured_image' => __( 'Remove featured image', 'tdy_pa_text_domain' ),
			'use_featured_image'    => __( 'Use as featured image', 'tdy_pa_text_domain' ),
			'insert_into_item'      => __( 'Insert into item', 'tdy_pa_text_domain' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'tdy_pa_text_domain' ),
			'items_list'            => __( 'Albums list', 'tdy_pa_text_domain' ),
			'items_list_navigation' => __( 'Albums list navigation', 'tdy_pa_text_domain' ),
			'filter_items_list'     => __( 'Filter items list', 'tdy_pa_text_domain' ),
		);
		$args = array(
			'label'                 => __( 'Photo album', 'tdy_pa_text_domain' ),
			'description'           => __( 'Photo album Description', 'tdy_pa_text_domain' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'revisions', 'page-attributes' ),
			'taxonomies'            => array( 'category', 'post_tag' ),
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'show_in_rest' 					=> true,
			'menu_position'         => 5,
			'menu_icon'							=> 'dashicons-format-gallery',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		register_post_type( 'tdy_photo_album', $args );

	}
add_action( 'init', 'custom_post_type' );


add_filter('single_template', 'my_custom_template');
function my_custom_template($single) {

    global $post;

    /* Checks for single template by post type */
    if ( $post->post_type == 'tdy_photo_album' ) {
        if ( file_exists( __DIR__ . '/public/partials/single-tdy_photo_album.php' ) ) {
            return __DIR__ . '/public/partials/single-tdy_photo_album.php';
        }
    }

    return $single;

}

add_filter( 'archive_template', 'get_custom_post_type_template' ) ;
function get_custom_post_type_template($archive) {

    global $post;

    /* Checks for archive template by post type */
    if ( $post->post_type == 'tdy_photo_album' ) {
        if ( file_exists( __DIR__ . '/public/partials/archive-tdy_photo_album.php' ) ) {
            return __DIR__ . '/public/partials/archive-tdy_photo_album.php';
        }
    }

    return $archive;

}

/**
* Adding Meta Boxes
*/
function tdy_add_meta_custom_box(){
  $screens = ['tdy_photo_album'];
  foreach ($screens as $screen) {
    add_meta_box(
      'tdy_pa_date',          	// Unique ID
      __( 'Photo Album Details', 'tdy_pa_text_domain'),   	// Box title
      'tdy_add_meta_custom_box_html',  // Content callback, must be of type callable
      $screen,                   // Post type
      'advanced',
      'high'
    );
  }
}
add_action( 'add_meta_boxes', 'tdy_add_meta_custom_box' );

/**
 * Outputs the content of the meta box
 */
function tdy_add_meta_custom_box_html($post){

	wp_nonce_field( basename( __FILE__ ), 'tdy_meta_nonce' );

	// $date = get_post_meta($post->ID, '_tdy_pa_date_meta', true);
	// $location = get_post_meta($post->ID, '_tdy_pa_location_meta', true);

	$meta_data = get_post_meta(get_the_ID());

	$date = $meta_data['_tdy_pa_date_meta'][0];
  $location = $meta_data['_tdy_pa_location_meta'][0];
  $photosObjectString = $meta_data['_tdy_pa_photos_meta'][0];
  $photosObjectArray = json_decode($photosObjectString);

  // print_r($photosObjectArray) ;

  $photosSrcArray = array_map(function($o) { return $o->src; }, $photosObjectArray);

  // print_r($photosSrcArray);

	?>

	<!-- Date text  -->
	<fieldset>
      <label for="_tdy_pa_date_meta"><?php _e('Album Date', 'tdy_pa_text_domain');?></label>
      <input type="text" class="regular-text" id="_tdy_pa_date_meta" name="_tdy_pa_date_meta" value="<?php if(!empty($date)) echo $date; ?>"/>
  </fieldset>

  <!-- Location text  -->
  <fieldset>
      <label for="_tdy_pa_location_meta"><?php _e('Location', 'tdy_pa_text_domain');?></label>
      <input type="text" class="regular-text" id="_tdy_pa_location_meta" name="_tdy_pa_location_meta" value="<?php if(!empty($location)) echo $location; ?>"/>
  </fieldset>

  <!-- Photos Upload  -->
  <fieldset>
      <label for="_tdy_pa_photos_meta">
          <input type="hidden" id="_tdy_pa_photos_meta" name="_tdy_pa_photos_meta" value='<?php if(!empty($photosObjectString)) echo $photosObjectString; ?>' />
          <input id="upload_photos_button" type="button" class="button" value="<?php _e( 'Upload Photo(s)', 'tdy_pa_text_domain'); ?>" />
          <span><?php esc_attr_e('Photo(s)', 'tdy_pa_text_domain');?></span>
      </label>
      <div class="tdy-pa-upload-wrapper">
      <?php if ($photosSrcArray) : ?>
      	<?php foreach ($photosSrcArray as $src): ?>
			     <div id="upload_photos_preview" class="tdy-pa-upload-preview">
			     		<div class="tdy-pa-close remove_image">&#8722;</div>
			        <img src="<?php echo $src; ?>" />
			     </div>
      	<?php endforeach ?>
    	<?php endif; ?>
      </div>
      <button id="tdy-pa-delete_photos_button" class="tdy-pa-delete-image">Remove all photos</button>
  </fieldset>
  <?php
}

/**
 * Saves the custom meta input
 */
function tdy_meta_save( $post_id ) {
 
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'tdy_meta_nonce' ] ) && wp_verify_nonce( $_POST[ 'tdy_meta_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ '_tdy_pa_date_meta' ] ) ) {
        update_post_meta( $post_id, '_tdy_pa_date_meta', sanitize_text_field( $_POST[ '_tdy_pa_date_meta' ] ) );
    }

    if( isset( $_POST[ '_tdy_pa_location_meta' ] ) ) {
        update_post_meta( $post_id, '_tdy_pa_location_meta', sanitize_text_field( $_POST[ '_tdy_pa_location_meta' ] ) );
    }

    if( isset( $_POST[ '_tdy_pa_photos_meta' ] ) ) {
        update_post_meta( $post_id, '_tdy_pa_photos_meta', sanitize_text_field( $_POST[ '_tdy_pa_photos_meta' ] ) );
    }
 
}
add_action( 'save_post', 'tdy_meta_save' );

function filter_tdy_photo_album_json( $data, $post, $context ) {

// $phone = get_post_meta( $post->ID, '_phone', true );
// if( $phone ) {
//     $data->data['phone'] = $phone;
// }

$meta_data = get_post_meta(get_the_ID());
$date = $meta_data['_tdy_pa_date_meta'][0];
$location = $meta_data['_tdy_pa_location_meta'][0];
$photos = $meta_data['_tdy_pa_photos_meta'][0];

if ($date) {
	 $data->data['date'] = $date;
}
if ($location) {
	 $data->data['location'] = $location;
}
if ($photos) {
	 $data->data['photos'] = $photos;
}

return $data;
}
add_filter( 'rest_prepare_tdy_photo_album', 'filter_tdy_photo_album_json', 10, 3 );


/**
* Gutenberg Block 
*/

require_once 'main-block-render.php';

function my_register_main() {

  // Register our block script with WordPress
  wp_register_script(
    'main',
    plugins_url('/blocks/dist/blocks.build.js', __FILE__),
    array('wp-blocks', 'wp-element')
  );

  // Register our block's base CSS  
  wp_register_style(
    'main-style',
    plugins_url( '/blocks/dist/blocks.style.build.css', __FILE__ ),
    array( 'wp-blocks' )
  );
  
  // Register our block's editor-specific CSS
  wp_register_style(
    'main-edit-style',
    plugins_url('/blocks/dist/blocks.editor.build.css', __FILE__),
    array( 'wp-edit-blocks' )
  );  
  
  // Enqueue the script in the editor
  register_block_type('tdy-pa/main', array(
  	'render_callback' => 'main_callback',
    'editor_script' => 'main',
    'editor_style' => 'main-edit-style',
    'style' => 'main-style'
  ));

  // register_meta( 'post', 'location', array(
  //       'show_in_rest' => true,
  //   ) );
}

add_action('init', 'my_register_main');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-tdy-pa.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_tdy_pa() {

	$plugin = new Tdy_Pa();
	$plugin->run();

}
run_tdy_pa();
