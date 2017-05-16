<?php

$d_img = array(
    'src' => get_post_meta( $post->ID, 'default-thumbnail-src', true ),
    'alt' => get_post_meta( $post->ID, 'default-thumbnail-alt', true ),
    'title' => get_post_meta( $post->ID, 'default-thumbnail-title', true )
);
?>
<p class="hide-if-no-js">
    <a title="Set Footer Image" href="javascript:;" id="set-default-thumbnail">Set featured image</a>
</p>

<div id="default-image-container" class="hidden">
    <img  src="<?php echo $d_img['src']; ?>" alt="<?php $d_img['alt']; ?>" title="<?php echo $d_img['title']; ?>" />
</div><!-- #featured-footer-image-container -->

<p class="hide-if-no-js hidden">
    <a title="Remove Footer Image" href="javascript:;" id="remove-default-thumbnail">Remove featured image</a>
</p><!-- .hide-if-no-js -->

<p id="featured-default-image-meta">
    <input type="hidden" id="default-thumbnail-src" name="default-thumbnail-src" value="<?php echo $d_img['src']; ?>" />
    <input type="hidden" id="default-thumbnail-title" name="default-thumbnail-title" value="<?php echo $d_img['title']; ?>" />
    <input type="hidden" id="default-thumbnail-alt" name="default-thumbnail-alt" value="<?php echo $d_img['alt']; ?>" />
</p><!-- #featured-footer-image-meta -->