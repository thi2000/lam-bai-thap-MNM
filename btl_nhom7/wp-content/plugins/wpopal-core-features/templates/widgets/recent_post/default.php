<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     Wordpress Opal Team <opalwordpress@gmail.com, support@prestabrain.com>
 * @copyright  Copyright (C) 2015 prestabrain.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */

$args = array(
	'post_type' => 'post',
	'posts_per_page' => $number_post
);

$query = new WP_Query($args);
if($query->have_posts()):
?>
<div class="widget media-post-layout widget-content">
	<?php 
		// Display the widget title
		if ( $title ) {
		    echo ($before_title)  . trim( $title ) . $after_title;
		}
	?>
	<ul>
	<?php
		while($query->have_posts()):$query->the_post();
	?>
		<li class="item-post media">
			<?php
				if(has_post_thumbnail()){
			?>
			<a href="<?php the_permalink(); ?>" class="image">
				<?php the_post_thumbnail( 'thumbnail' ); ?>
			</a>
			<?php } ?>

			<div class="media-body">
				<h6 class="entry-title">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h6>
				<div class="entry-meta">
					<?php if(isset($show_date) && $show_date === 'true' ) :?>
						<span class="post-date">
							<i class="fa fa-calendar-o"></i>
							<?php the_time( 'd M Y' ); ?>
						</span>
					<?php endif; ?>
					<?php if(isset($show_admin) && $show_admin === 'true' ) :?>
						<span class="post-author">
							<i class="fa fa-user"></i> <?php the_author_posts_link(); ?>
						</span>
					<?php endif; ?>
				</div>
			</div>

		</li>
	<?php endwhile; ?>
	<?php wp_reset_postdata(); ?>
</ul>
</div>
<?php endif; ?>
