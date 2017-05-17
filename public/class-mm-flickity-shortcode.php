<?php

/**
 * @since 0.0.0
 * @package MM_Flickity
 * @subpackage MM_Flickity_Shortcode
 *
 *
 * Class MM_Flickity_Shortcode
 */
class MM_Flickity_Shortcode {

    /**
     * Tag of shortcode
     *
     * @var string
     */
    private $tag = 'mm_flickity_slider';

    /**
     * Hooks on actions and filters
     *
     * MM_Flickity_Shortcode constructor.
     */
    function __construct() {
        //Register shortcode
        add_action( 'init', array( $this, 'shortcode' )  );
        add_shortcode( $this->tag, array( $this, 'shortcode' ) );

        add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
    }

    /**
     * Adding shortcode scripts and styles
     */
    public function assets() {
        $path = plugin_dir_url( __FILE__ );

        wp_register_script( 'flickity', $path . 'js/flickity.pkgd.min.js', array('jquery'), '2.0.5', true );
        wp_enqueue_script( 'flickity' );

        wp_register_style( 'flickity', $path . 'css/flickity.min.css' );
        wp_register_style( 'mm-flickity', $path . 'css/mm-flickity.css', array( 'flickity' ) );
        wp_enqueue_style( 'mm-flickity' );
    }

    /**
     * Render shortcode
     *
     * @param $atts
     *      @type integer $slide_number             quantity of slides in slider
     *      @type integer $slider                   taxonomy(slider) ID
     * @param null|string $content
     * @return string
     */
    public function shortcode( $atts, $content = null ) {

        $atts = shortcode_atts( array(
            'slides_number' => 4,
            'slider' => '',
            'columns' => 1
        ), $atts );


        $fields = mm_slider_options();
        $options = array();
        foreach ( $fields as $field )
            $options[$field['name']] = get_term_meta( $atts['slider'],  $field['name'], true );

        $options['cellSelector'] = '.carousel-cell';
        $gutter = $options['gutter'];
        $slide_size = $options['slideSize'];
        $no_flickity_options = array( 'gutter', 'slideSize' );
        foreach ( $no_flickity_options as $no_flickity_option )
            unset( $options[$no_flickity_option] );
        $json_options = json_encode( $options );

        $query_args = array(
            'posts_per_page' => (int)$atts['slides_number'],
            'post_type' => 'mm_flickity',
        );

        if ( $atts['slider'] > 0 ){

            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'mm_flickity_sliders',
                    'field' => 'id',
                    'terms' => (int)$atts['slider']
                )
            );

            $query = new WP_Query( $query_args );
        } else{
            $query = new WP_Query( $query_args );
        }

        ob_start();

        $cell_class = ' mm-flickity-carousel__cell';
        $cell_class .= ' ' . $cell_class . '_col-' . $atts['columns'];
        $title_class = '';
        if( $gutter ) {
            $cell_class .= ' mm-flickity-carousel__cell_gutter';
            $title_class = 'mm-flickity-carousel__cell_gutter';
        }

        if( $query->have_posts() ): ?>
            <div class="carousel mm-flickity-carousel" data-flickity='<?php echo $json_options; ?>'>
            <?php while ( $query->have_posts() ): $query->the_post(); ?>
                <?php
                $post_id = get_the_ID();
                $d_img = array(
                    'src' => get_post_meta( $post_id, 'default-thumbnail-src', true ),
                    'alt' => get_post_meta( $post_id, 'default-thumbnail-alt', true ),
                    'title' => get_post_meta( $post_id, 'default-thumbnail-title', true )
                );

                $bgi = !empty( $d_img['src'] ) ? 'style="background-image: url(' . $d_img['src'] . ')"' : '';
                printf('<div class="carousel-cell %s" %s>', esc_attr( $cell_class ), $bgi);
                ?>

                    <?php
                    if( $options['lazyLoad'] == true )
                        printf(
                            '<img class="mm-flickity-carousel__cell-image" src="" data-flickity-lazyload="%s">',
                            get_the_post_thumbnail_url( $post_id, $slide_size )
                        );
                    else
                        printf(
                            '<img class="mm-flickity-carousel__cell-image" src="%s" alt="%s">',
                            get_the_post_thumbnail_url( $post_id, $slide_size ),
                            get_the_title()
                            );
                    ?>
                    <div class="mm-flickity-carousel__cell-title <?php echo $title_class ?>">
                        <?php the_title( '<h3>', '</h3>' ); ?>
                    </div>

                </div>
        
            <?php endwhile; ?>
            </div>
        <?php else:  ?>
            <h1>This slider no have slides</h1>
        <?php
            endif;
        wp_reset_postdata();
        return ob_get_clean();
    }
}
new MM_Flickity_Shortcode();