<?php 
/**
 * Brizzz functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Brizzz
 * @since Brizzz 1.0
 */
 require_once ('admin/index.php');
 require_once dirname( __FILE__ ) . '/framework/post_type.php';
 require_once dirname( __FILE__ ) . '/framework/widget.php';
 require_once dirname( __FILE__ ) . '/framework/Custom/example-functions.php';
 require_once dirname( __FILE__ ) . '/framework/wp_bootstrap_navwalker.php';
 function brizzz_setup() {

	/*
	 * Make Twenty Fourteen available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Fourteen, use a find and
	 * replace to change 'brizzz' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( 'brizzz', get_template_directory() . '/languages' );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );
    
    add_theme_support( 'custom-header' );
	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 672, 372, true );
	add_image_size( 'brizzz-full-width', 1038, 576, true );

	// This theme uses wp_nav_menu() in two locations.
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'Primary Menu For Home Page', 'brizzz' ),
		//'secondary' => __( 'Secondary menu in left sidebar', 'brizzz' ),
        'header-menu' => __( 'Header Menu','brizzz' ),
        //extra-menu' => __( 'Extra Menu','brizzz' )
	) );

	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list',
	) );
    
	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );
  
	// This theme allows users to set a custom background.
	add_theme_support( 'custom-background', apply_filters( 'brizzz_custom_background_args', array(
		'default-color' => 'f5f5f5',
	) ) );

	// Add support for featured content.
	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'brizzz_get_featured_posts',
		'max_posts' => 6,
	) );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
    add_shortcode('gallery', '__return_false');
    
}
add_action( 'after_setup_theme', 'brizzz_setup' );
if ( ! isset( $content_width ) ) $content_width = 900;
function custom_excerpt_length( $length ) {
	return 42;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
function brizzz_font_url() {
	$font_url = '';
	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Lato, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Lato font: on or off', 'brizzz' ) ) {
		$font_url = add_query_arg( 'family', urlencode( 'Lato:300,400,700,900,300italic,400italic,700italic' ), "//fonts.googleapis.com/css" );
	}

	return $font_url;
}
function brizzz_admin_fonts() {
	wp_enqueue_style( 'brizzz-lato', brizzz_font_url(), array(), null );
}
add_action( 'admin_print_scripts-appearance_page_custom-header', 'brizzz_admin_fonts' );
function new_excerpt_more( $more ) {
	return '';
}
add_filter('excerpt_more', 'new_excerpt_more');

function brizzz_theme_scripts_styles(){
    global $smof_data;
	if ( isset( $smof_data['google_fonts'] ) ) {
		$google_fonts = $smof_data['google_fonts'];
	}
	else {
		$google_fonts = 'Lato';
	}
     if($google_fonts && $google_fonts != 'Select Font'){ 
    $protocol = is_ssl() ? 'https' : 'http';
    wp_enqueue_style( 'google-font', "$protocol://fonts.googleapis.com/css?family=".urlencode($google_fonts).":300,400,400italic,500,600,700,700italic&amp;subset=latin,greek-ext,cyrillic,latin-ext,greek,cyrillic-ext,vietnamese" );
   }
	 wp_enqueue_style( 'fonts-css', 'http://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic', true);
	 wp_enqueue_style( 'fonts-css', 'http://fonts.googleapis.com/css?family=Oswald:300,400,500,700', true);
     wp_enqueue_style( 'bootstrap-min-css', get_template_directory_uri() .'/css/bootstrap.min.css','','3.2');
     wp_enqueue_style( 'font-awesome-css', get_template_directory_uri() .'/css/font-awesome.css','','3.2');
     wp_enqueue_style( 'flexslider-css', get_template_directory_uri() .'/css/flexslider.css','','3.2');
     wp_enqueue_style( 'prettyPhoto-css', get_template_directory_uri() .'/css/prettyPhoto.css','','3.2');
     wp_enqueue_style( 'animate-css', get_template_directory_uri() .'/css/animate.css','','3.2');
     wp_enqueue_style( 'custom', get_template_directory_uri() .'/css/custom.css');
     wp_enqueue_style( 'style', get_template_directory_uri() .'/style.css','','3.2');
     
     //theme option for color
     wp_enqueue_style( 'color-css', get_template_directory_uri() .'/framework/color.php');
	 
	 $rtl = ( isset($smof_data['rtl']) ) ? $smof_data['rtl'] : 0;
	if($rtl == 1):
		wp_enqueue_style( 'rtl-css', get_template_directory_uri() .'/rtl.css','','3.2');	
	endif;
	 
    //Start Js File.
    wp_enqueue_script("jquery");
    wp_enqueue_script("bootstrap-js", get_stylesheet_directory_uri()."/js/bootstrap.min.js",array(),false, true);  
    wp_enqueue_script("prettyPhoto-js", get_stylesheet_directory_uri()."/js/jquery.prettyPhoto.js",array(),false, true);  
    wp_enqueue_script("stellar-js", get_stylesheet_directory_uri()."/js/jquery.stellar.min.js",array(),false, true);  
    wp_enqueue_script("flexslider-js", get_stylesheet_directory_uri()."/js/jquery.flexslider-min.js",array(),false, true);  
    wp_enqueue_script("jcarousel-js", get_stylesheet_directory_uri()."/js/jquery.jcarousel.js",array(),false, true);  
    wp_enqueue_script("mb-YTPlayer-js", get_stylesheet_directory_uri()."/js/jquery.mb.YTPlayer.js",array(),false, true);  
	$effects_content = ( isset($smof_data['effects_content']) ) ? $smof_data['effects_content'] : 0;
	if($effects_content == 1){}else{
		wp_enqueue_script("animate-js", get_stylesheet_directory_uri()."/js/animate.js",array(),false, true); 	
	}
	wp_enqueue_script("timer-js", get_stylesheet_directory_uri()."/js/jquery.timer.js",array(),false, true);  
    //wp_enqueue_script("twitter-js", get_stylesheet_directory_uri()."/js/jquery.twitter.js",array(),false, true); 
    wp_enqueue_script("twitter-js", get_stylesheet_directory_uri()."/js/tweetable.jquery.js",array(),true); 
    wp_enqueue_script("myscript-js", get_stylesheet_directory_uri()."/js/myscript.js",array(),false, true);      
}
add_action( 'wp_enqueue_scripts', 'brizzz_theme_scripts_styles' );
function brizzz_theme_comment($comment, $args, $depth) {
    //echo 's';
   $GLOBALS['comment'] = $comment; ?>
    <li class="margbot10 clearfix comment_row" style="position: relative;width: 100%;" data-animated="fadeInUp" id="li-comment-<?php comment_ID() ?>">
		<div class="pull-left avatar">
			<?php echo get_avatar($comment,$size='50',$default='http://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=70' ); ?>
		</div>
		<div class="comment_right">
			<div class="comment_info clearfix">
				<div class="pull-left comment_author"><?php printf(__('%s','brizzz'), get_comment_author_link()) ?> </div>
				<div class="pull-left comment_inf_sep">|</div>
				<div class="pull-left comment_date"><?php printf(get_comment_date()) ?></div>
				<div class="pull-right comment_reply" style="position: absolute;top: 0px; right: 0px;"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>			
			</div>
			<?php if ($comment->comment_approved == '0') : ?>
		         <em><?php _e('Your comment is awaiting moderation.','brizzz') ?></em>
		         <br />
		    <?php endif; ?>
			<?php comment_text() ?>
		</div>
	</li> 
	<style>
		#comments ul li {
			border-top: 1px solid #ECECEC;
			margin-top: 10px;
			padding-top: 10px;
		}
		#comments .children {
		  border-top: 1px solid #ECECEC;
		  padding: 10px 0 10px 40px;
		}
		#comments .children li {
		  border-top: 0px solid #ECECEC !important;
		  padding: 0px 0 0px 0px !important;
		  margin-top: 0px !important;
		}	
	</style>
<?php
        }      
function brizzz_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" class="search_form" action="' . home_url( '/' ) . '" >  
    	<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="Search the site..." />
    	<input type="submit" class="search_btn" id="searchsubmit" value="'. esc_attr__( 'Search' ) .'" />    
    </form>';
    return $form;
}
add_filter( 'get_search_form', 'brizzz_search_form' );

function brizzz_numeric_posts_nav() {
	 
    if( is_singular() )
        return;
 
    global $wp_query;
 
    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;
 
    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );
 
    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;
 
    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }
 
    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }
 
    echo '<ul class="pagination clearfix">' . "\n";
 
    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li>%s</li>' . "\n", get_previous_posts_link('&laquo;') );
 
    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';
 
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
 
        if ( ! in_array( 2, $links ) )
            echo '<li>…</li>';
    }
 
    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }
 
    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li>…</li>' . "\n";
 
        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }
 
    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li>%s</li>' . "\n", get_next_posts_link('&raquo;') );
 
    echo '</ul>' . "\n";
 
}      
function excerpt($limit) {
      $excerpt = explode(' ', get_the_excerpt(), $limit);
      if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
      } else {
        $excerpt = implode(" ",$excerpt);
      } 
      $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
      return $excerpt;
}
function brizzz_widgets_init() {
    	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'brizzz' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Main sidebar that appears on the left.', 'brizzz' ),
		'before_widget' => '<div class="sidepanel %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="sidepanel_title">',
		'after_title'   => '</div>',
	) );
}
add_action( 'after_setup_theme','remove_brizzz_options', 100 );
function remove_brizzz_options() {
	remove_theme_support( 'custom-background' );
	remove_theme_support( 'custom-header' );
}
add_action( 'widgets_init', 'brizzz_widgets_init' );
// Slider Gallery Attachment WP 
function marty_get_images($post_id) {
	global $post;
 
	$thumbnail_ID = get_post_thumbnail_id();
 
	$images = get_children( array('post_parent' => $post_id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );
 
	if ($images) :
		//echo '<div class="gallery">';
 
		foreach ($images as $attachment_id => $image) :
 
		if ( $image->ID != $thumbnail_ID ) :
 
			$img_title = $image->post_title;   // title.
			$img_caption = $image->post_excerpt; // caption.
			$img_description = $image->post_content; // description.
			$img_id = $image->ID; // id image
 
			$img_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true); //alt
			if ($img_alt == '') : $img_alt = $img_title; endif;
 
			$big_array = image_downsize( $image->ID, 'large' );
	 		$img_url = $big_array[0];
 
			?>
 
			<!--<div class="slide">
				<div  class="description">
					<p class="title"><strong><?php //echo $img_title; ?></strong></p>
					<?php //if ($img_caption) : echo wpautop($img_caption, 'caption'); endif; ?>
					<?php //if ($img_description) : echo wpautop($img_description); endif; ?>
				</div>
				<div class="image">
					<p><img src="<?php //echo $img_url; ?>" alt="<?php //echo $img_alt; ?>" title="<?php //echo $img_title; ?>" /></p>
				</div>
			</div>-->
			
			<li class="slide<?php echo $img_id; ?>">
				<img src="<?php echo $img_url; ?>" alt="<?php echo $img_alt; ?>" title="<?php echo $img_title; ?>" />
			</li>
 
		<?php endif; ?>
		<?php endforeach; ?>
		<!-- </div> --><!-- End gallery -->
	<?php endif;
}
//Customize WordPress Tag Cloud Widget
add_filter('widget_tag_cloud_args','set_number_tags');
function set_number_tags($args) {
	 $args = array(
		'smallest' => 16,
		'largest' => 22,
		'unit' => 'pt',
		'number' => 45,
		'format' => 'flat',
		//'separator' => \\"\n\\",
		'orderby' => 'name',
		'order' => 'ASC',
		'exclude' => null,
		'include' => null,
		'topic_count_text_callback' => 'default_topic_count_text',
		'link' => 'view',
		'taxonomy' => 'post_tag',
		'echo' => true,
		'child_of' => null
	); 
return $args;
}

//Active Plugin: 
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @package       TGM-Plugin-Activation
 * @subpackage Example
 * @version       2.3.6
 * @author       Thomas Griffin <thomas@thomasgriffinmedia.com>
 * @author       Gary Jones <gamajo@gamajo.com>
 * @copyright  Copyright (c) 2012, Thomas Griffin
 * @license       http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/thomasgriffin/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once dirname( __FILE__ ) . '/framework/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function my_theme_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
        
      
        array(
            'name'                     => 'Contact Form 7', // The plugin name
            'slug'                     => 'contact-form-7', // The plugin slug (typically the folder name)
            'required'                 => true, // If false, the plugin is only 'recommended' instead of required
        ),array(
            'name'                     => 'Aqua Page Builder', // The plugin name
            'slug'                     => 'Aqua-Page-Builder-master', // The plugin slug (typically the folder name)
            'required'                 => false, // If false, the plugin is only 'recommended' instead of required
            'source'                   => get_template_directory_uri() . '/framework/plugins/Aqua-Page-Builder-master.zip',
        )
        
    );

    // Change this to your theme text domain, used for internationalising strings
    $theme_text_domain = 'icommerce';

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'domain'               => $theme_text_domain,             // Text domain - likely want to be the same as your theme.
        'default_path'         => '',                             // Default absolute path to pre-packaged plugins
        'parent_menu_slug'     => 'themes.php',                 // Default parent menu slug
        'parent_url_slug'     => 'themes.php',                 // Default parent URL slug
        'menu'                 => 'install-required-plugins',     // Menu slug
        'has_notices'          => true,                           // Show admin notices or not
        'is_automatic'        => false,                           // Automatically activate plugins after installation or not
        'message'             => '',                            // Message to output right before the plugins table
        'strings'              => array(
            'page_title'                                   => __( 'Install Required Plugins', $theme_text_domain ),
            'menu_title'                                   => __( 'Install Plugins', $theme_text_domain ),
            'installing'                                   => __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
            'oops'                                         => __( 'Something went wrong with the plugin API.', $theme_text_domain ),
            'notice_can_install_required'                 => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_install'                      => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
            'notice_can_activate_required'                => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_activate_recommended'            => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_activate'                     => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
            'notice_ask_to_update'                         => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_update'                         => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
            'install_link'                                   => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                               => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
            'return'                                       => __( 'Return to Required Plugins Installer', $theme_text_domain ),
            'plugin_activated'                             => __( 'Plugin activated successfully.', $theme_text_domain ),
            'complete'                                     => __( 'All plugins installed and activated successfully. %s', $theme_text_domain ), // %1$s = dashboard link
            'nag_type'                                    => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
        )
    );

    tgmpa( $plugins, $config );

}
?>