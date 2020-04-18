<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/***
 * Show image as preview in loop
 */
function latehome_free_loop_post_preview()
{
    global $post;

    if (has_post_thumbnail()) {
        $size = is_single() ? 'full' : 'medium';
        echo get_the_post_thumbnail($post->ID, $size);
    }
}

add_action('latehome_free_loop_post_preview', 'latehome_free_loop_post_preview', 10);

/**
 * Show preview follow post format: support gallery, video, audion, quotes and image as default
 */
function latehome_free_single_generate_preview()
{

    global $post;

    switch (get_post_format()) {
        case 'gallery':
            echo latehome_free_render_post_gallery();
            break;
        case "video":
            echo latehome_free_render_post_video();
            break;
        case "audio":
            echo latehome_free_render_post_audio();
            break;
        case "quote":
            echo latehome_free_render_post_quote();
            break;
        default:

            if (has_post_thumbnail()) {
                $size = is_single() ? 'full' : 'medium';
                echo get_the_post_thumbnail($post->ID, $size);
            }

            break;
    }
}

add_action('latehome_free_single_post_preview', 'latehome_free_single_generate_preview', 10);

/**
 * Render quote preview for format quotes
 */
function latehome_free_render_post_quote()
{ ?>
    <?php
    $author = get_post_meta(get_the_ID(), '_postauthor', true);
    $content = get_post_meta(get_the_ID(), '_postquote', true);
    ?>
    <div class="post-quote-preview">
        <span class="fa fa-quote-right"></span>
        <div class="quote-content"><?php echo esc_html($content); ?></div>
        <div class="quote-author">- <?php echo esc_html($author); ?></div>
    </div>
<?php }

/**
 * Render preview for format audio
 */
function latehome_free_render_post_audio()
{
    $link = get_post_meta(get_the_ID(), '_postaudio_link', true);
    $autoplay = false;
    $options = array('width' => '100%', 'height' => '100%', 'autoplay' => $autoplay);
    ?>
    <?php if ($link): ?>
    <div class="post-audio-preview audio-responsive"><?php echo wp_oembed_get($link, $options); ?></div>
<?php endif; ?>

<?php }

/**
 * Render preview for format video
 */
function latehome_free_render_post_video()
{
    global $post;
    $id = get_post_meta(get_the_ID(), '_postvideo', true);
    ?>

    <div class="video-preivew">
        <?php echo get_the_post_thumbnail($post->ID, 'full', 'image-responsive'); ?>
        <?php if (!empty($id)) : ?>
            <a href="<?php echo esc_url($id); ?>" class="magnific-popup-iframe"><i class="fa fa-play"></i></a>
        <?php endif; ?>
    </div>
<?php }


/**
 * Render preview for format gallery
 */
function latehome_free_render_post_gallery($size = 'full')
{
    $ids = get_post_meta(get_the_ID(), '_postgallery', true);
    $output = array();

    $data = array(
        'slidesPerView' => 1,
        'spaceBetween' => 0,
        'effect' => 'slide'
    );

    $_id = 'posts-block-' . rand(1, 9);

    if ($ids) :
        ?>
        <div class="post-gallery-preview wpopal-swiper-play" id="postcarousel-<?php echo esc_attr($_id); ?>"
             data-swiper="<?php echo esc_attr(wp_json_encode($data)); ?>">

            <div class="swiper-wrapper">

                <?php foreach ($ids as $id => $src) {
                    $image = wp_get_attachment_image_src($id, $size);
                    if (isset($image[0])) { ?>
                        <div class="swiper-slide"><img class="img-responsive" src="<?php echo esc_attr($image[0]); ?>">
                        </div>
                    <?php }
                } ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    <?php
    endif;
}