<?php
/**
 * Slider section
 *
 * This is the template for the content of slider section
 *
 * @package Theme Palace
 * @subpackage Magazinews
 * @since Magazinews 1.0.0
 */
if ( ! function_exists( 'magazinews_add_slider_section' ) ) :
    /**
    * Add slider section
    *
    *@since Magazinews 1.0.0
    */
    function magazinews_add_slider_section() {
    	$options = magazinews_get_theme_options();
        // Check if slider is enabled on frontpage
        $slider_enable = apply_filters( 'magazinews_section_status', true, 'slider_section_enable' );

        if ( true !== $slider_enable ) {
            return false;
        }
        // Get slider section details
        $section_details = array();
        $section_details = apply_filters( 'magazinews_filter_slider_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render slider section now.
        magazinews_render_slider_section( $section_details );
    }
endif;

if ( ! function_exists( 'magazinews_get_slider_section_details' ) ) :
    /**
    * slider section details.
    *
    * @since Magazinews 1.0.0
    * @param array $input slider section details.
    */
    function magazinews_get_slider_section_details( $input ) {
        $options = magazinews_get_theme_options();

        $content = array();
        $cat_id = ! empty( $options['slider_content_category'] ) ? $options['slider_content_category'] : '';
        $args = array(
            'post_type'         => 'post',
            'posts_per_page'    => 5,
            'cat'               => absint( $cat_id ),
            'ignore_sticky_posts'   => true,
            );                    

        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['id']        = get_the_id();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['excerpt']   = magazinews_trim_content( 25 );
                $page_post['image']  	= has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'full' ) : '';

                // Push to the main array.
                array_push( $content, $page_post );
            endwhile;
        endif;
        wp_reset_postdata();
            
        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// slider section content details.
add_filter( 'magazinews_filter_slider_section_details', 'magazinews_get_slider_section_details' );


if ( ! function_exists( 'magazinews_render_slider_section' ) ) :
  /**
   * Start slider section
   *
   * @return string slider content
   * @since Magazinews 1.0.0
   *
   */
   function magazinews_render_slider_section( $content_details = array() ) {
        $options = magazinews_get_theme_options();

        if ( empty( $content_details ) ) {
            return;
        } 

        $class = ($options['slider_classic_slider'] == 'true' ? 'classic-slider' : 'modern-slider');
        ?>

        <div id="featured-slider" class="relative <?php echo esc_attr($class); ?>" data-slick='{"slidesToShow": 3, "slidesToScroll": 1, "infinite": true, "speed": 500, "dots": false, "arrows":true, "autoplay": <?php echo $options['slider_auto_play'] ? 'true' : 'false'; ?>, "draggable": true, "fade": false }'>
            <?php foreach ( $content_details as $content ) : ?>

                <article style="background-image: url('<?php echo esc_url( $content['image'] ); ?>');">
                    <div class="overlay"></div>
                    <div class="entry-container">
                        <span class="cat-links">
                            <?php the_category( '', '', $content['id'] ); ?>
                        </span><!-- .cat-links -->

                        <header class="entry-header">
                            <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                        </header>

                        <div class="entry-meta">
                            <?php  
                                magazinews_posted_on( $content['id'] );
                                echo magazinews_author( $content['id'] );
                            ?>
                        </div><!-- .entry-meta -->

                        <div class="entry-content">
                            <p><?php echo esc_html( $content['excerpt'] ); ?></p>
                        </div><!-- .entry-content -->
                    </div><!-- .entry-container -->
                </article>
                
            <?php endforeach; ?>
        </div><!-- .main-slider-wrapper -->
        
    <?php }
endif;