<?php
/**
 * Popular section
 *
 * This is the template for the content of popular section
 *
 * @package Theme Palace
 * @subpackage Magazinews
 * @since Magazinews 1.0.0
 */
if ( ! function_exists( 'magazinews_add_popular_section' ) ) :
    /**
    * Add popular section
    *
    *@since Magazinews 1.0.0
    */
    function magazinews_add_popular_section() {
    	$options = magazinews_get_theme_options();
        // Check if popular is enabled on frontpage
        $popular_enable = apply_filters( 'magazinews_section_status', true, 'popular_section_enable' );

        if ( true !== $popular_enable ) {
            return false;
        }
        // Get popular section details
        $section_details = array();
        $section_details = apply_filters( 'magazinews_filter_popular_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render popular section now.
        magazinews_render_popular_section( $section_details );
    }
endif;

if ( ! function_exists( 'magazinews_get_popular_section_details' ) ) :
    /**
    * popular section details.
    *
    * @since Magazinews 1.0.0
    * @param array $input popular section details.
    */
    function magazinews_get_popular_section_details( $input ) {
        $options = magazinews_get_theme_options();

        $cats = ! empty( $options['popular_content_category'] ) ? $options['popular_content_category'] : array();
        $content = array();
        $ids = array();
        foreach ( $cats as $cat_id ) :
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
                    $ids[] = get_the_id();
                endwhile;
            endif;
            wp_reset_postdata();             
        endforeach;

        $ids = array_unique( $ids );

        $args = array(
            'post_type'         => 'post',
            'posts_per_page'    => count( $ids ),
            'post__in'          => ( array ) $ids,
            'ignore_sticky_posts'   => true,
            );   

        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['id']        = get_the_id();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['image']     = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'post-thumbnail' ) : '';

                // Push to the main array.
                array_push( $content, $page_post );
            endwhile;
        endif;
        wp_reset_postdata();

        if ( ! empty( $cats ) ) :
            wp_register_script( 'magazinews-popular-localize', get_template_directory_uri() . '/assets/js/popular-localize' . magazinews_min() . '.js', array( 'jquery','magazinews-custom' ), '20151215', true );
            $magazinews_popular_category = array(
                'cat'          => magazinews_get_cat_slug( $cats[0] ),
            );
            wp_localize_script( 'magazinews-popular-localize', 'magazinews_popular_category', $magazinews_popular_category );
            wp_enqueue_script( 'magazinews-popular-localize' );
        endif;

        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// popular section content details.
add_filter( 'magazinews_filter_popular_section_details', 'magazinews_get_popular_section_details' );


if ( ! function_exists( 'magazinews_render_popular_section' ) ) :
  /**
   * Start popular section
   *
   * @return string popular content
   * @since Magazinews 1.0.0
   *
   */
   function magazinews_render_popular_section( $content_details = array() ) {
        $options = magazinews_get_theme_options();
        $cats = ! empty( $options['popular_content_category'] ) ? $options['popular_content_category'] : array();

        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="popular-posts" class="relative page-section">
            <div class="wrapper">
                <div class="section-header-wrapper">
                    <?php if ( ! empty( $options['popular_title'] ) ) : ?>
                        <div class="section-header">
                            <h2 class="section-title"><?php echo esc_html( $options['popular_title'] ); ?></h2>
                        </div><!-- .section-header -->
                    <?php endif; ?>

                    <ul id="ajax-filter">
                        <?php $i = 1; foreach ( $cats as $cat ) : ?>
                            <li <?php if ( $i == 1 ) { echo 'class="active"'; } ?> data-url="<?php echo esc_url( get_category_link( $cat ) ); ?>" data-name="<?php echo esc_attr( get_cat_name( $cat ) ); ?>"><a href="#" data-slug="<?php echo esc_attr( magazinews_get_cat_slug( $cat ) ); ?>"><?php echo esc_html( get_cat_name( $cat ) ); ?></a></li>
                        <?php $i++; endforeach; ?>
                    </ul><!-- #ajax-filter -->

                </div><!-- .section-header-wrapper -->

                <ul id="ajax-filter" class="mobile-view">
                    <?php $i = 1; foreach ( $cats as $cat ) : ?>
                        <li <?php if ( $i == 1 ) { echo 'class="active"'; } ?> data-url="<?php echo esc_url( get_category_link( $cat ) ); ?>" data-name="<?php echo esc_attr( get_cat_name( $cat ) ); ?>"><a href="#" data-slug="<?php echo esc_attr( magazinews_get_cat_slug( $cat ) ); ?>"><?php echo esc_html( get_cat_name( $cat ) ); ?></a></li>
                    <?php $i++; endforeach; ?>
                </ul><!-- #ajax-filter -->

                <div class="section-content-wrapper" data-slick='{"slidesToShow": 4, "slidesToScroll": 1, "infinite": true, "speed": 1500, "dots": true, "arrows":true, "autoplay": true, "draggable": true, "fade": false }'>
                    <?php foreach ( $content_details as $content ) : ?>
                        <article class="<?php magazinews_get_cat_slug_by_post( $content['id'] ); ?>all">
                            <div class="popular-post-wrapper">
                                <?php if ( ! empty( $content['image'] ) ) : ?>
                                    <div class="featured-image" style="background-image:url('<?php echo esc_url( $content['image'] ); ?>');">
                                        <a href="<?php echo esc_url( $content['url'] ); ?>" class="post-thumbnail-link"></a>
                                    </div><!-- .popular-image-->
                                <?php endif; ?>

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
                                </div><!-- .entry-container -->
                            </div><!-- .popular-post-wrapper -->
                        </article>
                    <?php endforeach; ?>
                </div><!-- .section-content-wrapper -->

            </div><!-- .wrapper -->
        </div><!-- #popular-posts -->

    <?php }
endif;