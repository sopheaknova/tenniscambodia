 
    <aside class="footer-widgets">
        <div class="container clearfix">
            <?php if ( is_active_sidebar('footer-sidebar-1') ) :   
            dynamic_sidebar('footer-sidebar-1');
                else:?> 
                    <div class="non-widget widget">
                     <h4><?php _e('Footer Sidebar 1', SP_TEXT_DOMAIN); ?></h4>
                    <p class="noside"><?php _e('To edit this sidebar, go to admin backend\'s <strong><em>Appearance -&gt; Widgets</em></strong> and place widgets into the <strong><em> Footer sidebar 1 </em></strong> Area', SP_TEXT_DOMAIN); ?></p>
                    </div>
            <?php endif; ?>

            <?php if ( is_active_sidebar('footer-sidebar-2') ) :   
            dynamic_sidebar('footer-sidebar-2');
                else:?> 
                    <div class="non-widget widget">
                     <h4><?php _e('Footer Sidebar 2', SP_TEXT_DOMAIN); ?></h4>
                    <p class="noside"><?php _e('To edit this sidebar, go to admin backend\'s <strong><em>Appearance -&gt; Widgets</em></strong> and place widgets into the <strong><em> Footer sidebar 2 </em></strong> Area', SP_TEXT_DOMAIN); ?></p>
                    </div>
            <?php endif; ?>

            <?php if ( is_active_sidebar('footer-sidebar-3') ) :   
            dynamic_sidebar('footer-sidebar-3');
                else:?> 
                    <div class="non-widget widget">
                     <h4><?php _e('Footer Sidebar 3', SP_TEXT_DOMAIN); ?></h4>
                    <p class="noside"><?php _e('To edit this sidebar, go to admin backend\'s <strong><em>Appearance -&gt; Widgets</em></strong> and place widgets into the <strong><em> Footer sidebar 3 </em></strong> Area', SP_TEXT_DOMAIN); ?></p>
                    </div>
            <?php endif; ?>

        </div> <!-- .container .clearfix -->
    </aside>
    
    <?php if ( is_active_sidebar('footer-sponsor') ) : ?>
        <section class="sponsors">   
        <?php dynamic_sidebar('footer-sponsor'); ?>
        </section>
    <?php endif; ?>        

    <footer id="footer" class="clearfix">
        <nav id="footer-nav" class="clearfix">
            <?php echo sp_footer_navigation(); ?>
        </nav>
        
        <div class="copyright">
            <?php if ( ot_get_option( 'copyright' ) ): ?>
                <p><?php echo ot_get_option( 'copyright' ); ?></p>
            <?php else: ?>
                <p><?php bloginfo(); ?> &copy; <?php echo date( 'Y' ); ?>. <?php _e( 'All Rights Reserved.', SP_TEXT_DOMAIN ); ?></p>
            <?php endif; ?>
            <?php if ( ot_get_option( 'credit' ) != 'off' ): ?>
            <p class="credit"><?php echo ot_get_option( 'credit-text' ); ?></p><!--/#credit-->
            <?php endif; ?>
        </div><!--/#copyright-->
        
    </footer>

    </div> <!-- #content-container -->
</div> <!-- #wrapper -->

<?php wp_footer(); ?>

</body>
</html>