<?php

/**
 * @since 0.0.0
 * @package MM_Flickity
 * @subpackage MM_Flickity_Metaboxes
 * Class MM_Flickity_Metaboxes
 */
class MM_Flickity_Metaboxes {

    /**
     * Post type
     * @since 0.0.0
     * @var string
     */
    private $slides = 'mm_flickity';
    /**
     * Term
     * @since 0.0.0
     * @var string
     */
    private $slider = 'mm_flickity_sliders';

    /**
     * Slider option fields
     * @since 0.0.0
     * @var array
     */
    private $slider_fields = array();

    /**
     * @since 0.0.0
     * MM_Flickity_Metaboxes constructor.
     */
    function __construct() {
        $this->_set_slider_fields();
        add_action( 'init', array( $this, 'register' ) );

        // Add slider fileds
        add_action( "{$this->slider}_add_form_fields", array( $this, 'render_add_slider_meta_box_hook' ) );
        add_action( "create_{$this->slider}", array( $this, 'save_slider_fields' ) );

        // Fields in edit slider
        add_action( "{$this->slider}_edit_form_fields", array( $this, 'render_edit_slider_meta_box_hook' ), 10, 2 );
        add_action( "edit_{$this->slider}", array( $this, 'save_slider_fields' ) );

        // Saving when edit slider
        add_action("edited_{$this->slider}", array( $this, 'save_slider_fields' ) );

        //upload default image
        add_action( 'add_meta_boxes', array( $this, 'add_slide_meta_box' ) );
        add_action( 'save_post', array( $this, 'save_post_default_image' ) );
        // styles and scripts
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
    }

    /**
     * Register Post and Taxonomy type
     * @since 0.0.0
     */
    function register() {

        $labels = array(
            'name'                  => _x( 'Slides', 'Post Type General Name', 'mm-flickity' ),
            'singular_name'         => _x( 'Slide', 'Post Type Singular Name', 'mm-flickity' ),
            'menu_name'             => __( 'MM Flickity', 'mm-flickity' ),
            'name_admin_bar'        => __( 'MM Flickity', 'mm-flickity' ),
            'archives'              => __( 'Slide Archives', 'mm-flickity' ),
            'attributes'            => __( 'Slide Attributes', 'mm-flickity' ),
            'parent_item_colon'     => __( 'Parent Slide:', 'mm-flickity' ),
            'all_items'             => __( 'All Slides', 'mm-flickity' ),
            'add_new_item'          => __( 'Add New Slide', 'mm-flickity' ),
            'add_new'               => __( 'Add New', 'mm-flickity' ),
            'new_item'              => __( 'New Slide', 'mm-flickity' ),
            'edit_item'             => __( 'Edit Slide', 'mm-flickity' ),
            'update_item'           => __( 'Update Slide', 'mm-flickity' ),
            'view_item'             => __( 'View Slide', 'mm-flickity' ),
            'view_items'            => __( 'View Slides', 'mm-flickity' ),
            'search_items'          => __( 'Search Slide', 'mm-flickity' ),
            'not_found'             => __( 'Not found', 'mm-flickity' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'mm-flickity' ),
            'featured_image'        => __( 'Featured Image', 'mm-flickity' ),
            'set_featured_image'    => __( 'Set featured image', 'mm-flickity' ),
            'remove_featured_image' => __( 'Remove featured image', 'mm-flickity' ),
            'use_featured_image'    => __( 'Use as featured image', 'mm-flickity' ),
            'insert_into_item'      => __( 'Insert into slide', 'mm-flickity' ),
            'uploaded_to_this_item' => __( 'Uploaded to this slide', 'mm-flickity' ),
            'items_list'            => __( 'Slides list', 'mm-flickity' ),
            'items_list_navigation' => __( 'Slides list navigation', 'mm-flickity' ),
            'filter_items_list'     => __( 'Filter slides list', 'mm-flickity' ),
        );
        $args = array(
            'label'                 => __( 'Slide', 'mm-flickity' ),
            'description'           => __( 'Slides with text and images', 'mm-flickity' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail', ),
            'taxonomies'            => array( $this->slider ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 25,
            'menu_icon'             => 'dashicons-images-alt',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
        );
        register_post_type( $this->slides, $args );

        $labels = array(
            'name'                       => _x( 'Sliders', 'Taxonomy General Name', 'mm-flickity' ),
            'singular_name'              => _x( 'Slider', 'Taxonomy Singular Name', 'mm-flickity' ),
            'menu_name'                  => __( 'Sliders', 'mm-flickity' ),
            'all_items'                  => __( 'All Sliders', 'mm-flickity' ),
            'parent_item'                => __( 'Parent Slider', 'mm-flickity' ),
            'parent_item_colon'          => __( 'Parent Slider:', 'mm-flickity' ),
            'new_item_name'              => __( 'New Slider Name', 'mm-flickity' ),
            'add_new_item'               => __( 'Add New Slider', 'mm-flickity' ),
            'edit_item'                  => __( 'Edit Slider', 'mm-flickity' ),
            'update_item'                => __( 'Update Slider', 'mm-flickity' ),
            'view_item'                  => __( 'View Slider', 'mm-flickity' ),
            'separate_items_with_commas' => __( 'Separate sliders with commas', 'mm-flickity' ),
            'add_or_remove_items'        => __( 'Add or remove sliders', 'mm-flickity' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'mm-flickity' ),
            'popular_items'              => __( 'Popular sliders', 'mm-flickity' ),
            'search_items'               => __( 'Search sliders', 'mm-flickity' ),
            'not_found'                  => __( 'Not Found', 'mm-flickity' ),
            'no_terms'                   => __( 'No sliders', 'mm-flickity' ),
            'items_list'                 => __( 'Sliders list', 'mm-flickity' ),
            'items_list_navigation'      => __( 'Sliders list navigation', 'mm-flickity' ),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => false,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => false,
            'show_tagcloud'              => true,
            'show_in_rest'               => true,
        );
        register_taxonomy( $this->slider, array( $this->slides ), $args );

    }

    /**
     * Adding functionality to add default image to slide
     * @since 0.0.0
     * @param $filter
     */
    function enqueue_scripts( $filter ){

        if( ( $filter === 'post.php' || $filter === 'post-new.php' ) && get_post_type() === $this->slides ){
            wp_enqueue_media();
            wp_enqueue_script( $this->slides, plugin_dir_url( __FILE__ ) . 'js/upload-image.js', array( 'jquery' ) );
            wp_enqueue_style( $this->slides, plugin_dir_url( __FILE__ ) . 'css/upload-image.css' );
        }

    }

    /**
     * Renders the meta box on the slide page.
     *
     * @since 0.0.0
     */
    public function add_slide_meta_box() {

        add_meta_box(
            $this->slides . '_metabox',
            'Default Featured Image',
            array( $this, 'display_default_image' ),
            $this->slides,
            'side'
        );

    }

    /**
     * Renders the view that displays the contents for the meta box that for triggering
     * the meta box.
     *
     * @param    WP_Post    $post    The post object
     * @since    0.0.0
     */
    public function display_default_image( $post ) {
        include_once( dirname( __FILE__ ) . '/views/admin.php' );
    }

    /**
     * Sanitized and saves the post default image meta data specific with this post.
     *
     * @param    int    $post_id    The ID of the post with which we're currently working.
     * @since 0.0.0
     */
    public function save_post_default_image( $post_id ) {

        if ( isset( $_REQUEST['default-thumbnail-src'] ) ) {
            update_post_meta( $post_id, 'default-thumbnail-src', sanitize_text_field( $_REQUEST['default-thumbnail-src'] ) );
        }

        if ( isset( $_REQUEST['default-thumbnail-title'] ) ) {
            update_post_meta( $post_id, 'default-thumbnail-title', sanitize_text_field( $_REQUEST['default-thumbnail-title'] ) );
        }

        if ( isset( $_REQUEST['default-thumbnail-alt'] ) ) {
            update_post_meta( $post_id, 'default-thumbnail-alt', sanitize_text_field( $_REQUEST['default-thumbnail-alt'] ) );
        }

    }

    /**
     * Initialize slider options
     * @since 0.0.0
     */
    private function _set_slider_fields() {
        $this->slider_fields = mm_slider_options();
    }

    /**
     * Render slider fields options
     *
     * @since 0.0.0
     * @param WP_Term|bool $tag
     * @param string $taxonomy
     * @param array $fields
     * @param string $page
     */
    private function render_slider_meta_box( $tag, $taxonomy, $fields, $page ){

        wp_nonce_field( basename( __FILE__ ), $this->slider );

        if( $page === 'edit' ) {
            printf(
                '<tr class="form-field"><th scope="row" valign="top" colspan="2"><label>%s</label></th></tr>',
                __( 'Slider options', 'mm-flickity' )
            );
        }else{
            printf(
                '<div class="form-field"><h3>%s</h3></div>',
                __( 'Slider options', 'mm-flickity' )
            );
        }

        foreach ( $fields as $field )
            $this->render_field( $tag, $taxonomy, $field, $page );
    }

    /**
     * Render field
     *
     * @since 0.0.0
     * @param bool $tag
     * @param string $taxonomy
     * @param array $field
     *          @type string $name              Field name attribute
     *          @type string $type              Type of inputs. Also allow textarea
     *          @type string $label             Label of field
     *          @type string $description       Description of field
     *          @type mixed $value              If type equal select define option array key value pair
     */
    function render_field( $tag = false, $taxonomy = '', $field = array(), $page = ''  ) {

        $defaults = array(
            'name' => 'name',
            'type' => 'text',
            'label' => 'label',
            'description' => 'description',
            'value' => '',
        );

        $field = wp_parse_args( $field, $defaults );

        if( $tag )
            $value = get_term_meta( $tag->term_id, $field['name'], true );
        else
            $value = '';

        if( $page === 'add' ) {
            printf(
                '<div class="form-field term-%1$s-wrap"><label for="%1$s">%2$s</label>',
                $field['name'],
                $field['label']
            );
        } else {
            printf(
                '<tr class="form-field term-%1$s-wrap"><th scope="row"><label for="%1$s">%2$s</label></th><td>',
                $field['name'],
                $field['label']
            );
        }

        switch ( $field['type'] ){
            case 'checkbox':
                $value = !empty( $value ) ? (bool)$value : false;

                $checked = checked( $value, true, false );

                printf(
                    '<input type="checkbox" id="%1$s" name="%1$s" value="true" %2$s>',
                    $field['name'],
                    $checked,
                    $value
                );
                break;
            case 'select':
                printf(
                    '<select id="%1$s" name="%1$s">', $field['name']
                );
                foreach ( $field['value'] as $key => $val )
                    printf(
                        '<option value="%s"%s>%s</option>',
                        $val,
                        selected($val, $value, false),
                        $key
                    );
                echo '</select>';
                break;
            default:
                printf(
                    '<input class="large-text" type="%3$s" id="%1$s" name="%1$s" value="%2$s">',
                    $field['name'],
                    $value,
                    $field['type']
                );
        }

        if( $page === 'add' ){
            printf( '<p>%s</p></div>', $field['description'] );
        } else {
            printf( '<p>%s</p></td></tr>', $field['description'] );
        }


    }

    /**
     * Render slider fields on edit slider page
     *
     * @since 0.0.0
     * @param WP_Term $tag
     * @param string $taxonomy
     */
    public function render_edit_slider_meta_box_hook( $tag, $taxonomy ){
        $this->render_slider_meta_box( $tag, $taxonomy, $this->slider_fields, 'edit' );
    }

    /**
     * Render slider fields on create slider page
     *
     * @since 0.0.0
     */
    public function render_add_slider_meta_box_hook(){
        $this->render_slider_meta_box( false, '', $this->slider_fields, 'add' );
    }

    /**
     * Save slider options
     *
     * @since 0.0.0
     * @param $term_id
     */
    public function save_slider_fields( $term_id ){
        // check nonce
        if( ! isset( $_POST[$this->slider] ) )
            return;

        if( ! wp_verify_nonce( $_POST[$this->slider], basename( __FILE__ ) ) )
            return;

        // save data
        foreach ( $this->slider_fields as $field ) {
            //if( isset( $_POST[ $field['name'] ] ) ) {
                update_term_meta( $term_id, $field['name'], $_POST[ $field['name'] ] );
            //}
        }

    }

}

new MM_Flickity_Metaboxes();
