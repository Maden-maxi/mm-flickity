<?php

/**
 * @package MM_Flickity
 * @subpackage MM_Fkickity_List_Table
 */

class MM_Fkickity_List_Table{
    /**
     * Instance
     *
     * @var null
     */
    private static $instance = null;

    /**
     * Slug
     *
     * @var string
     */
    private $slug = 'mm_flickity';

    /**
     * Table columns
     *
     * @var array
     */
    private $table_columns = array();

    /**
     * Instantinate class only once. Singleton
     *
     * @return null
     */
    public static function getInstance()
    {
        if( null === self::$instance ){
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * MM_Fkickity_List_Table constructor.Initalize hooks
     */
    function __construct(){
        $this->setTableColumns();
        add_filter( "manage_edit-{$this->slug}_columns", array( $this, "header_columns" ) );
        add_filter( "manage_edit-{$this->slug}_sortable_columns", array( $this, "header_columns" ) );

        add_action("manage_{$this->slug}_posts_custom_column",  array( $this ,'output_cell_content_column' ), 10, 2);

        //add_action( "admin_menu", array( $this, "row_actions_hook" ) );
    }

    /**
     *
     */
    public function setTableColumns()
    {
        $this->table_columns = array(
            'slide' => __( 'Slide', 'mm-flickity' ),
            'default_image' => __( 'Default Image' )
        );
    }

    /**
     * Adding table head
     *
     * @param $columns
     * @return array
     */
    public function header_columns( $columns ){
        $new_columns = $this->table_columns;

        $new_columns['date'] = $columns['date'];
        unset( $columns['date'] );

        return array_merge($columns, $new_columns );
    }

    /**
     *
     *
     * @param $column_name
     * @param $post_id
     */
    public function output_cell_content_column( $column_name, $post_id ) {

        if( $column_name === 'slide' ) {
            echo get_the_post_thumbnail( $post_id, 'thumbnail' );
        } elseif ( $column_name === 'default_image' ) {
            echo wp_get_attachment_image( attachment_url_to_postid(get_post_meta( $post_id, 'default-thumbnail-src', true )), 'thumbnail' );
        }
    }

}
MM_Fkickity_List_Table::getInstance();