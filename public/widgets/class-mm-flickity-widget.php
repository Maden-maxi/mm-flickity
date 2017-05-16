<?php

/**
 * @package MM_Flickity
 * @subpackage Class MM_Flickity_Widget
 * @see WP_Widget
 */
class MM_Flickity_Widget extends WP_Widget{

    /**
     * Sets up a new Flickity slider widget.
     * @since 0.0.0
     */
    public function __construct() {
        $widget_ops = array(
            'description' => __( 'A Flickity slider widget.' ),
            'classname' => 'mm-flickity__widget',
            'customize_selective_refresh' => true
        );
        parent::__construct( 'mm_flickity_widget', 'Flickity Slider', $widget_ops );
    }

    /**
     * Renter slider in frontend
     *
     * @param array $args       Display arguments including 'before_title', 'after_title',
     *                          'before_widget', and 'after_widget'.
     * @param array $instance   Settings for the current Flickity slider widget instance.
     */
    public function widget($args, $instance) {
        $current_slider = $this->_get_current_slider($instance);

        if ( !empty($instance['title']) ) {
            $title = apply_filters( 'widget_title', $instance['title'] );
        } else {
            if ( 'post_tag' == $current_slider ) {
                $title = __('Tags');
            } else {
                $tax = get_term($current_slider);
                $title = $tax->name;
            }
        }

        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        $columns = ( ! empty( $instance['columns'] ) ) ? absint( $instance['columns'] ) : 1;


        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $shortcode = '[mm_flickity_slider slides_number="' . $number . '" columns="' . $columns . '" slider="' . $current_slider . '"]';
        echo do_shortcode( $shortcode );

        echo $args['after_widget'];

    }

    /**
     * Handles updating settings for the current Flickity slider widget instance.
     *
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['number'] = (int) $new_instance['number'];
        $instance['columns'] = (int) $new_instance['columns'];
        $instance['slider'] = (int)$new_instance['slider'];
        //$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
        return $instance;
    }

    /**
     * Flickity widget field parameters
     *
     * @param array $instance
     * @return void
     */
    public function form($instance)
    {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $columns   = isset( $instance['columns'] ) ? absint( $instance['columns'] ) : 1;

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of sildes to show:' ); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'columns' ); ?>"><?php _e( 'Columns in slider:' ); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id( 'columns' ); ?>" name="<?php echo $this->get_field_name( 'columns' ); ?>" type="number" step="1" min="1" value="<?php echo $columns; ?>" size="3" />
        </p>
        <?php
        $current_slider = $this->_get_current_slider( $instance );
        $sliders = get_terms( array( 'taxonomy' => 'mm_flickity_sliders' ) );
        $id = $this->get_field_id( 'slider' );
        $name = $this->get_field_name( 'slider' );
        $input = '<input type="hidden" id="' . $id . '" name="' . $name . '" value="%s" />';

        switch ( count( $sliders ) ) {
            case 0:
                echo '<p>' . __( 'The tag cloud will not be displayed since there are no taxonomies that support the tag cloud widget.' ) . '</p>';
                printf( $input, '' );
                break;
            case 1:
                $keys = array_keys( $sliders );
                $taxonomy = reset( $keys );
                printf( $input, esc_attr( $taxonomy ) );
                break;
            default:
                printf(
                    '<p><label for="%1$s">%2$s</label>' .
                    '<select class="widefat" id="%1$s" name="%3$s">',
                    $id,
                    __( 'Slider:' ),
                    $name
                );
                printf(
                    '<option value="%s"%s>%s</option>',
                    -1,
                    selected( -1, $current_slider, false ),
                    __('All')
                );
                foreach ( $sliders as $tax ) {
                    printf(
                        '<option value="%s"%s>%s</option>',
                        esc_attr( $tax->term_id ),
                        selected( $tax->term_id, $current_slider, false ),
                        $tax->name
                    );
                }

                echo '</select></p>';
        }
    }
    /**
     * Retrieves the slider for the current term widget instance.
     *
     * @since 4.4.0
     * @access public
     *
     * @param array $instance Current settings.
     * @return string|bool Name of the current slider if set, otherwise false.
     */
    public function _get_current_slider($instance) {
        if ( !empty($instance['slider']) && term_exists( $instance['slider'] ) )
            return $instance['slider'];

        return false;
    }
}

/**
 * Register widget directly
 */
add_action( 'widgets_init', 'mm_flickity_register_widget' );
function mm_flickity_register_widget(){
    register_widget( 'MM_Flickity_Widget' );
}