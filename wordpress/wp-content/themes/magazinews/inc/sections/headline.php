<?php
/**
 * Headline section
 *
 * This is the template for the content of headline section
 *
 * @package Theme Palace
 * @subpackage Magazinews
 * @since Magazinews 1.0.0
 */
if ( ! function_exists( 'magazinews_add_headline_section' ) ) :
    /**
    * Add headline section
    *
    *@since Magazinews 1.0.0
    */
    function magazinews_add_headline_section() {
    	$options = magazinews_get_theme_options();
        // Check if headline is enabled on frontpage
        $headline_enable = apply_filters( 'magazinews_section_status', true, 'headline_section_enable' );

        if ( true !== $headline_enable ) {
            return false;
        }
        // Get headline section details
        $section_details = array();
        $section_details = apply_filters( 'magazinews_filter_headline_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render headline section now.
        magazinews_render_headline_section( $section_details );
    }
endif;

if ( ! function_exists( 'magazinews_get_headline_section_details' ) ) :
    /**
    * headline section details.
    *
    * @since Magazinews 1.0.0
    * @param array $input headline section details.
    */
    function magazinews_get_headline_section_details( $input ) {
        $options = magazinews_get_theme_options();

        $content = array();
        $cat_id = ! empty( $options['headline_content_category'] ) ? $options['headline_content_category'] : '';
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
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();

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
// headline section content details.
add_filter( 'magazinews_filter_headline_section_details', 'magazinews_get_headline_section_details' );


if ( ! function_exists( 'magazinews_render_headline_section' ) ) :
  /**
   * Start headline section
   *
   * @return string headline content
   * @since Magazinews 1.0.0
   *
   */
   function magazinews_render_headline_section( $content_details = array() ) {
        $options = magazinews_get_theme_options();
        $title = ! empty( $options['headline_title'] ) ? $options['headline_title'] : esc_html__( 'Breaking News', 'magazinews' );

        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="breaking-news">
            <div class="wrapper">
                <div class="news-header">
                    <span class="news-title"><?php echo esc_html( $title ); ?></span>
                </div><!-- .section-header -->

                <div class="breaking-news-posts">
                    <div class="marquee-content">
                        <ul>
                            <?php foreach ( $content_details as $content ) : ?>
                                <li><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div><!-- .marquee-content -->
                </div><!-- .breaking-news-posts -->
            </div><!-- .wrapper -->
        </div><!-- #breaking-news -->
        
    <?php }
endif;