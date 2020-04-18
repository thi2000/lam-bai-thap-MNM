<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     Opal  Team <opalwordpress@gmail.com>
 * @copyright  Copyright (C) 2017 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */
/**
 * Enable/distable share box
 */
$default = '<span class="social-s-heading">' . esc_html__( 'Share On:', 'wpopal' ) . '</span>';
$heading = apply_filters( 'wpopal_social_heading', $default );
$target = apply_filters( 'wpopal_social_sharing_target', '_blank' );

?>
<table class="social-share-block">
    <tr>
        <td><?php echo wp_kses_post( $heading ); ?></td>
        <td>
            <a class="wpopal-social-facebook hint--top" aria-label="<?php esc_html_e( 'Share on facebook', 'wpopal' ); ?>"
               href="https://www.facebook.com/sharer.php?u=<?php echo( get_the_permalink() ); ?>&t=<?php echo urlencode( get_the_title() ); ?>" target="<?php echo esc_attr( $target ); ?>"
               title="<?php esc_html_e( 'Share on facebook', 'wpopal' ); ?>">
                <i class="fa fa-facebook"></i>
            </a>

            <a class="wpopal-social-twitter hint--top" aria-label="<?php esc_html_e( 'Share on Twitter', 'wpopal' ); ?>"
               href="http://twitter.com/home?status=<?php echo urlencode( get_the_title() ); ?><?php the_permalink(); ?>" target="<?php echo esc_attr( $target ); ?>" title="<?php esc_html_e( 'Share on Twitter',
                'wpopal' )
            ; ?>">
                <i class="fa fa-twitter"></i>
            </a>

            <a class="wpopal-social-linkedin hint--top" aria-label="<?php esc_html_e( 'Share on LinkedIn', 'wpopal' ); ?>"
               href="http://linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php echo urlencode( get_the_title() ); ?>" target="<?php echo esc_attr( $target ); ?>"
               title="<?php esc_html_e( 'Share on LinkedIn', 'wpopal' ); ?>">
                <i class="fa fa-linkedin"></i>
            </a>

            <a class="wpopal-social-tumblr hint--top" aria-label="<?php esc_html_e( 'Share on Tumblr', 'wpopal' ); ?>"
               href="http://www.tumblr.com/share/link?url=<?php echo urlencode( get_permalink() ); ?>&amp;name=<?php echo urlencode( get_the_title() ); ?>&amp;description=<?php echo urlencode( get_the_excerpt() ); ?>"
               target="<?php echo esc_attr( $target ); ?>" title="<?php esc_html_e( 'Share on Tumblr', 'wpopal' ); ?>">
                <i class="fa fa-tumblr"></i>
            </a>

            <a class="wpopal-social-google hint--top" aria-label="<?php esc_html_e( 'Share on Google plus', 'wpopal' ); ?>" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,
'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="<?php echo esc_attr( $target ); ?>" title="<?php esc_html_e( 'Share on Google plus', 'wpopal' )
            ; ?>">
                <i class="fa fa-google-plus"></i>
            </a>

            <a class="wpopal-social-pinterest hint--top" aria-label="<?php esc_html_e( 'Share on Pinterest', 'wpopal' ); ?>"
               href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode( get_permalink() ); ?>&amp;description=<?php echo urlencode( get_the_title() ); ?>" target="<?php echo esc_attr
            ( $target );
            ?>"
               title="<?php esc_html_e( 'Share on Pinterest', 'wpopal' ); ?>">
                <i class="fa fa-pinterest"></i>
            </a>

            <a class="wpopal-social-envelope hint--top" aria-label="<?php esc_html_e( 'Email to a Friend', 'wpopal' ); ?>"
               href="mailto:?subject=<?php echo urlencode( get_the_title() ); ?>&amp;body=<?php the_permalink(); ?>" title="<?php esc_html_e( 'Email to a Friend', 'wpopal' ); ?>">
                <i class="fa fa-envelope"></i>
            </a>
        </td>
    </tr>
</table>
