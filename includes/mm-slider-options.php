<?php
/**
 * Array of option fields for slider
 * @package MM_Flickity
 * @since 0.0.0
 * @return mixed|void
 */
function mm_slider_options() {
    $fields = array(
        array(
            'name' => 'initialIndex',
            'type' => 'number',
            'label' => __( 'Initial slide', 'mm-flickity' ),
            'description' => __( 'Zero-based index of the initial selected cell.', 'mm-flickity' )
        ),
        array(
            'name' => 'accessibility',
            'type' => 'checkbox',
            'label' => __( 'Accessibility', 'mm-flickity' ),
            'description' => __( 'Enable keyboard navigation. Users can tab to a Flickity carousel, and pressing left & right keys to change cells.', 'mm-flickity' ),
            'value' => true
        ),
        array(
            'name' => 'resize',
            'type' => 'checkbox',
            'label' => __( 'Resize', 'mm-flickity' ),
            'description' => __( 'Adjusts sizes and positions when window is resized.', 'mm-flickity' ),
            'value' => true
        ),
        array(
            'name' => 'cellAlign',
            'label' => __( 'Cell Align', 'mm-flickity' ),
            'description' => __( 'Align cells within the carousel element.', 'mm-flickity' ),
            'type' => 'select',
            'value' => array(
                'Left' => 'left',
                'Center' => 'center',
                'Right' => 'right'
            )
        ),
        array(
            'name' => 'slideSize',
            'label' => __( 'Slide size', 'mm-flickity' ),
            'description' => __( 'Slide size.', 'mm-flickity' ),
            'type' => 'select',
            'value' => array(
                __( 'Thumbnail', 'mm-flickity' ) => 'thumbnail',
                __( 'Post thumbnail', 'mm-flickity' ) => 'post-thumbnail',
                __( 'Medium', 'mm-flickity' ) => 'medium',
                __( 'Large', 'mm-flickity' ) => 'large',
                __( 'Full', 'mm-flickity' ) => 'full',
            )
        ),
        array(
            'name' => 'contain',
            'type' => 'checkbox',
            'label' => __( 'Contain', 'mm-flickity' ),
            'description' => __( 'Contains cells to carousel element to prevent excess scroll at beginning or end. Has no effect if `wrapAround: true`', 'mm-flickity' ),
        ),
        array(
            'name' => 'imagesLoaded',
            'type' => 'checkbox',
            'label' => __( 'Images Loaded', 'mm-flickity' ),
            'description' => __( 'Unloaded images have no size, which can throw off cell positions. To fix this, the imagesLoaded option re-positions cells once their images have loaded.', 'mm-flickity' )
        ),
        array(
            'name' => 'lazyLoad',
            'type' => 'checkbox',
            'label' => __( 'Lazy Load', 'mm-flickity' ),
            'description' => __( 'Loads cell images when a cell is selected.', 'mm-flickity' )
        ),
        array(
            'name' => 'bgLazyLoad',
            'type' => 'checkbox',
            'label' => __( 'Lazy Load Background', 'mm-flickity' ),
            'description' => __( 'Loads cell background image when a cell is selected.', 'mm-flickity' )
        ),
        array(
            'name' => 'rightToLeft',
            'type' => 'checkbox',
            'label' => __( 'Right To Left', 'mm-flickity' ),
            'description' => __( 'Enables right-to-left layout.', 'mm-flickity' )
        ),
        array(
            'name' => 'draggable',
            'type' => 'checkbox',
            'label' => __( 'Draggable', 'mm-flickity' ),
            'description' => __( 'Enables dragging and flicking.', 'mm-flickity' ),
            'value' => true
        ),
        array(
            'name' => 'freeScroll',
            'type' => 'checkbox',
            'label' => __( 'Free Scroll', 'mm-flickity' ),
            'description' => __( 'Enables content to be freely scrolled and flicked without aligning cells to an end position.', 'mm-flickity' )
        ),
        array(
            'name' => 'wrapAround',
            'type' => 'checkbox',
            'label' => __( 'Wrap around', 'mm-flickity' ),
            'description' => __( 'At the end of cells, wrap-around to the other end for infinite scrolling.', 'mm-flickity' )
        ),
        array(
            'name' => 'groupCells',
            'type' => 'checkbox',
            'label' => __( 'Group Cells', 'mm-flickity' ),
            'description' => __( 'Groups cells together in slides. Flicking, page dots, and previous/next buttons are mapped to group slides, not individual cells.  is-selected class is added to the multiple cells in the selected slide.', 'mm-flickity' )
        ),
        array(
            'name' => 'autoPlay',
            'type' => 'checkbox',
            'label' => __( 'Auto Play', 'mm-flickity' ),
            'description' => __( 'Automatically advances to the next cell.', 'mm-flickity' ),
            'value' => true
        ),
        array(
            'name' => 'pauseAutoPlayOnHover',
            'type' => 'checkbox',
            'label' => __( 'Pause Auto Play On Hover', 'mm-flickity' ),
            'description' => __( 'Automatically advances to the next cell.', 'mm-flickity' ),
            'value' => true
        ),
        array(
            'name' => 'adaptiveHeight',
            'type' => 'checkbox',
            'label' => __( 'Adaptive Height', 'mm-flickity' ),
            'description' => __( 'Changes height of carousel to fit height of selected slide.', 'mm-flickity' ),
            'value' => true
        ),
        array(
            'name' => 'prevNextButtons',
            'type' => 'checkbox',
            'label' => __( 'Prev Next Buttons', 'mm-flickity' ),
            'description' => __( 'Creates and enables previous & next buttons.', 'mm-flickity' ),
            'value' => true
        ),
        array(
            'name' => 'pageDots',
            'type' => 'checkbox',
            'label' => __( 'Page Dots', 'mm-flickity' ),
            'description' => __( 'Creates and enables page dots.', 'mm-flickity' ),
            'value' => true
        ),
        array(
            'name' => 'gutter',
            'type' => 'checkbox',
            'label' => __( 'Gutter', 'mm-flickity' ),
            'description' => __( 'Gutter between slides.', 'mm-flickity' )
        ),
    );
    /**
     * In this filter we have ability to add options to slider or change or remove options in slider
     */
    return apply_filters( 'mm_flickity_slider_options', $fields );
}