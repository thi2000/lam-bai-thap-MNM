<?php 
defined( 'ABSPATH' ) || exit();

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Main Wpopal_Core_Product_Navigation Class
 *
 * @class Wpopal_Core_Product_Navigation
 * @version	1.0.0
 * @since 1.0.0
 * @package	Wpopal_Core_Product_Navigation
 */
class Wpopal_Core_Product_Sizes_Chart {
	
	public $content; 

	public static function get_instance() {

		static $_instance; 

		if( !$_instance ){

			$_instance = new Wpopal_Core_Product_Sizes_Chart();
		}
		return $_instance;
	}

	public function __construct() {

		add_action( 'init', array($this,'create_post_type'), 9 );  
		add_action( 'template_redirect', array($this,'get_sizeschart_content')  );  

		add_action( 'template_include', array( $this, 'template_include' ) );
		add_action('cmb2_admin_init', array($this, 'taxonomy_metaboxes'));
	}

	public function create_post_type(){

		$labels = array(
			'name'               => _x( 'Sizes Chart', 'post type general name', 'wpopal' ),
			'singular_name'      => _x( 'Sizes Chart', 'post type singular name', 'wpopal' ),
			'menu_name'          => _x( 'Sizes Charts', 'admin menu', 'wpopal' ),
			'name_admin_bar'     => _x( 'Sizes Chart', 'add new on admin bar', 'wpopal' ),
			'add_new'            => _x( 'Add New', 'book', 'wpopal' ),
			'add_new_item'       => __( 'Add New Sizes Chart', 'wpopal' ),
			'new_item'           => __( 'New Sizes Chart', 'wpopal' ),
			'edit_item'          => __( 'Edit Sizes Chart', 'wpopal' ),
			'view_item'          => __( 'View Sizes Chart', 'wpopal' ),
			'all_items'          => __( 'All Sizes Chart', 'wpopal' ),
			'search_items'       => __( 'Search Items', 'wpopal' ),
			'parent_item_colon'  => __( 'Parent Items:', 'wpopal' ),
			'not_found'          => __( 'No menus found.', 'wpopal' ),
			'not_found_in_trash' => __( 'No menus found in Trash.', 'wpopal' )
		);

		$args = array(
			'labels'              => $labels,
			'hierarchical'        => false,
			'description'         => 'description',
			'taxonomies'          => array(),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => null,
			'menu_icon'           => null,
			'show_in_nav_menus'   => false,
			'publicly_queryable'  => true,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'query_var'           => true,
			'can_export'          => true,
			'capability_type'     => 'post',
			'supports'            => array( 'title', 'editor' ),
			'rewrite'            => array( 'slug' => 'sizeschart' )
		);

		register_post_type( 'sizeschart', apply_filters( 'wpopal_sizeschart_post_type', $args ) );

		add_post_type_support( 'sizeschart', 'elementor' );
	}

	public function get_options() {  
		global $pagenow;
		$options = array(
			'' => __( 'None' , 'wpopal' )
		);
 
		if ( $pagenow === 'post.php' || $pagenow === 'post-new.php' ) { 
			$args = array( 
				  'numberposts'		=> -1, // -1 is for all
				  'post_type'		=> 'sizeschart', // or 'post', 'page'
				  'orderby' 		=> 'title', // or 'date', 'rand'
				  'order' 			=> 'ASC', // or 'DESC'
			);
			// Get the posts
			$posts = get_posts( $args );

			if( $posts ){
				foreach( $posts as $post ){
					$options[$post->post_name] = $post->post_title;
				}
			}
		}	
 
		return $options;
	}

	/**
	 * Register meta box fields with cmb2 plugin
     *
     * @return avoid 
	 */
	public function taxonomy_metaboxes() {

        $prefix = 'opal_';

        $cmb_term = new_cmb2_box(array(
            'id'           => 'sizechart',
            'title'        => __('Product Metabox', 'wpopal'), // Doesn't output for term boxes
          	'object_types'  => array( 'product' ), // Post type
            // 'new_term_section' => true, // Will display in the "Add New Category" section
        ));

        $cmb_term->add_field(array(
            'name'       => __('Size Chart', 'wpopal'),
            //                'desc' => __('Location image', 'homefinder'),
            'id'         => $prefix . 'sizechart',
            'type'       => 'select',
            'options'	=> $this->get_options(),
            'query_args' => array(
                'type' => 'sizeschart',
            ),
        ));
    }

	 /**
     * template include function callback
     */
    public function template_include( $template ) {   

        if ( get_query_var('post_type') !== 'sizeschart' ) {
            return $template;
        }
 
        $template = WPOPAL_PLUGIN_TEMPLATE_DIR . 'elementor-preview.php';
        
        return $template;
    }

    public function get_sizeschart_content(){
    	global $post;
    	if( is_product() ) {  
	    	$slug = get_post_meta( $post->ID, 'opal_sizechart', true );


	    	if( empty($slug) ){
	    		return ;
	    	}
	 		$_post = get_page_by_path($slug, OBJECT, 'sizeschart' );


	 		if( $_post ) {
			    	if( class_exists("\Elementor\Plugin") ) {
			    	$this->content = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $_post->ID );
			    }	
			}
		}
    }	
	   
    public function render_sizechart(){ 
 

    	if( $this->content ) {  
    ?>
		<a href="#sizeschart-content" class="btn-sizechart open-popup-link">
			 	<?php echo __( 'Sizes Chart', 'wpopal' );?>
		</a>
		<div style="display:none">
			<div id="sizeschart-content" class="white-popup mfp-with-anim  mfp-hide" >
				<?php echo $this->content; ?>
			</div>	
		</div>
    <?php } }
}
?>
