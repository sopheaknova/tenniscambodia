<?php
/*
Template Name: Home
*/

get_header(); ?>
<?php do_action( 'sp_start_content_wrap_html' ); ?>
    <div class="main">
		<?php 

		$home_meta = get_post_meta( $post->ID );

        $args = array(
            'posts_per_page' => 5,
            'category__in' => $home_meta['sp_news_category'][0],
            'post__in'  => get_option( 'sticky_posts' ),
            'ignore_sticky_posts' => 1
        );
        $custom_query = new WP_Query( $args );
    ?>    

    <?php if( $custom_query->have_posts() ) : ?>

    <script type="text/javascript">
        jQuery(document).ready(function(){

            /* Single Post slider */
            $('#featured-post').flexslider({
                animation: "slide",
                slideshowSpeed: 8000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
                animationDuration: 200,         //Integer: Set the speed of animations, in milliseconds
                animationLoop: true,            //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
                pauseOnAction: true,            //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
                pauseOnHover: true,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
                before: function(slider) {
                  $('.flex-caption').delay(100).fadeOut(100);
                },
                after: function(slider) {
                  $('.flex-active-slide').find('.flex-caption').delay(200).fadeIn(400);
                  }
            });
        });
    </script>

    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=927721147243367&version=v2.0";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>    

    <section id="featured-post" class="flexslider">
        <ul class="slides">

        <?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
    
            <li>
                <?php if ( has_post_thumbnail() ): ?>
                    <?php the_post_thumbnail('post-slider'); ?>
                <?php elseif ( ot_get_option('placeholder') != 'off' ): ?>
                    <img class="wp-image-placeholder" src="<?php echo SP_ASSETS_THEME; ?>images/placeholder/thumb-medium.png" alt="<?php the_title(); ?>" />
                <?php endif; ?>
                <ul class="social-share">
                    <li><a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-via="NorngNova" data-related="NorngNova" data-count="none">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></li>
                    <li class="fb-share-button" data-href="<?php the_permalink(); ?>" data-type="button"></li>
                </ul>
                <div class="flex-caption">
                <h5><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h5>
                <span class="date-meta"><?php the_time('j M, Y'); ?></span>
                </div>
            </li>

        <?php endwhile; wp_reset_postdata(); ?>

        </ul>
    </section> <!-- #featured-post -->

    <?php endif; ?> 

    <div class="two-fourth">
        <div class="widget">
            <div class="widget-title"><h4><?php echo $home_meta['sp_video_title'][0]; ?></h4></div>
            <?php echo sp_add_video ($home_meta['sp_video_url_home'][0], 300, 169); ?>
        </div>
    </div> <!-- video -->

    <div class="two-fourth last">
        <div class="widget sp-widget-upcoming-events clearfix">
            <div class="widget-title"><h4><?php echo $home_meta['sp_event_title'][0]; ?></h4></div>
            <article>
                <div class="event-meta">
                    <span class="event-day">22</span>
                    <span class="event-month">Jul</span>
                </div>
                <a href="#" class="event-title">
                    <h5>The Best Adults Social Doubles Competition</h5>
                    <span class="event-location">At Cambodian Country Club</span>
                    <span class="event-time">09:00 am</span>
                </a>
            </article>
            <article>
                <div class="event-meta">
                    <span class="event-day">06</span>
                    <span class="event-month">Jun</span>
                </div>
                <a href="#" class="event-title">
                    <h5>Tennis 10’s Festival</h5>
                    <span class="event-location">At Cambodian Country Club</span>
                    <span class="event-time">14:30 pm</span>
                </a>
            </article>
            <a class="learn-more" href="ing-holdings.com">All events</a>
        </div>
    </div> <!-- upcoming-event -->  

    <div class="two-fourth">
    <div class="widget sp-widget-logos">
        <div class="widget-title"><h4><?php echo $home_meta['sp_partner_title'][0]; ?></h4></div>
        <section id="partners">
        <?php echo sp_get_logos_by_type( $home_meta['sp_partner_home'][0], $home_meta['sp_partner_logo_num'][0] ); ?>    
        </section>
    </div>
    </div> <!-- partner -->

    <div class="two-fourth last">
    <div class="widget sp-widget-logos">
        <div class="widget-title"><h4><?php echo $home_meta['sp_award_title'][0]; ?></h4></div>
        <section id="awards">
            <?php echo sp_get_logos_by_type( $home_meta['sp_award_home'][0], $home_meta['sp_award_logo_num'][0] ); ?>
        </section>
    </div>
    </div> <!-- awards -->



	</div><!-- #main -->
	<?php get_sidebar();?>

    <div class="clear"></div>
    <div class="widget sp-widget-photogallery">
        <div class="widget-title"><h4><?php echo $home_meta['sp_photo_title'][0]; ?></h4></div>
        <?php echo sp_get_album_gallery( $home_meta['sp_gallery_home'][0], $home_meta['sp_photo_num'][0])?>
    </div>

<?php do_action( 'sp_end_content_wrap_html' ); ?>
	
<?php get_footer(); ?>