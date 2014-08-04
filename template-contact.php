<?php
/*
Template Name: Contact
*/

get_header(); ?>
<?php 
    //Past meta value into var
    $map_locations = get_post_meta($post->ID, 'sp_contact_map', true); 
    $map_loc = explode(',', $map_locations);
    $latitude_center = $map_loc[0] + 0.008;// Variable to align the marker on the right side of the map, instead of the center    
?>    
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        var map_styles = [
            {
                // Style the map with the custom hue
                stylers: [
                    { "hue":"#052a50" }
                ]
            },
            {
                // Remove road labels
                featureType:"road",
                elementType:"labels",
                stylers: [
                    { "visibility":"off" }
                ]
            },
            {
                // Style the road
                featureType:"road",
                elementType:"geometry",
                stylers: [
                    { "lightness":100 },
                    { "visibility":"simplified" }
                ]
            }
        ];;
        
        var mapOptions = {  
            center: new google.maps.LatLng(<?php echo $latitude_center . ',' . $map_loc[1]; ?>),
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.LARGE,
                position: google.maps.ControlPosition.RIGHT_CENTER
            },
            panControlOptions: {
                position: google.maps.ControlPosition.RIGHT_CENTER
            },
            streetViewControl:false,
            zoom:14,
            mapTypeControlOptions: {
                mapTypeIds:[]
            }
        }
        var map = new google.maps.Map(document.getElementById("single-map-canvas"), mapOptions);

        var styledMap = new google.maps.StyledMapType(map_styles, { name:"Contact Map" });

        map.mapTypes.set('Contact Map', styledMap);
        map.setMapTypeId('Contact Map');
        
        
        var image = '<?php echo SP_ASSETS_THEME ;?>' + 'images/google-map-marker.png'; // Marker image

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(<?php echo $map_loc[0] . ',' . $map_loc[1]; ?>), 
            map: map,
            icon:image,
            animation: google.maps.Animation.DROP
        });

        $('.sp-contact-form').validate({
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                message: "required",
            },
            submitHandler: function (form) {
                var data = {
                    action:"sp_send_contact_form",
                    inquiry : $('.sp-contact-form').serialize()
                };
                $.post( theme_objects.ajaxURL, data, function(data) {
                    $('.sp-contact-form').hide();
                    $('#result').html(data);
                });
                return false;
            }
        });

    });
</script>

<div id="single-map-canvas" class="google-map-img-reset" style="width:100%; height: 420px;"></div>

<?php do_action( 'sp_start_content_wrap_html' ); ?>
    <div class="main">
        <?php while ( have_posts() ) : the_post(); ?>
            
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>
            <div class="entry-content clearfix">
                <div class="one-third">
                <?php the_content(); ?>
                </div>
                <div class="two-third last">
                    <div id="result"></div>
                    <form class="sp-contact-form" action="" method="post">
                        <h5 class="form-title">General Inquiries</h5>
                        <div class="two-fourth">
                        <label for="name"><?php echo __('Your name', SP_TEXT_DOMAIN); ?></label>
                        <input type="text" id="name" name="name" />
                        </div>
                        <div class="two-fourth last">
                        <label for="email"><?php echo __('Email', SP_TEXT_DOMAIN); ?></label>
                        <input type="text" id="email" name="email" />
                        </div>
                        
                        <div class="clear"></div>

                        <label for="message"><?php echo __('Message:', SP_TEXT_DOMAIN); ?></label>
                        <textarea rows="3" name="message" id="message"></textarea>
                        
                        <p><input type="submit" value="<?php echo __('Send', SP_TEXT_DOMAIN); ?>" class="send-inquiry" /></p>
                    </form>
                </div>
            </div><!-- .entry-content -->
            
        <?php endwhile; ?>
    </div><!-- #main -->
	<?php get_sidebar();?>

<?php do_action( 'sp_end_content_wrap_html' ); ?>
	
<?php get_footer(); ?>