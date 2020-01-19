<?php
/**
 * Featured section
 *
 * This is the template for the content of featured section
 *
 * @package Theme Palace
 * @subpackage Magazinews
 * @since Magazinews 1.0.0
 */
if ( ! function_exists( 'magazinews_add_featured_section' ) ) :
    /**
    * Add featured section
    *
    *@since Magazinews 1.0.0
    */
    function magazinews_add_featured_section() {
    	$options = magazinews_get_theme_options();
        // Check if featured is enabled on frontpage
        $featured_enable = apply_filters( 'magazinews_section_status', true, 'featured_section_enable' );

        if ( true !== $featured_enable ) {
            return false;
        }
        // Get featured section details
        $section_details = array();
        $section_details = apply_filters( 'magazinews_filter_featured_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render featured section now.
        magazinews_render_featured_section( $section_details );
    }
endif;

if ( ! function_exists( 'magazinews_get_featured_section_details' ) ) :
    /**
    * featured section details.
    *
    * @since Magazinews 1.0.0
    * @param array $input featured section details.
    */
    function magazinews_get_featured_section_details( $input ) {
        $options = magazinews_get_theme_options();

            $cats = ! empty( $options['featured_content_category'] ) ? $options['featured_content_category'] : array();
            $content = array();
            $i = 0;
            foreach ( $cats as $cat_id ) :
                $content[$i] = array();
                $args = array(
                    'post_type'         => 'post',
                    'posts_per_page'    => 4,
                    'cat'               => absint( $cat_id ),
                    'ignore_sticky_posts'   => true,
                    );                    


                // Run The Loop.
                $query = new WP_Query( $args );
                if ( $query->have_posts() ) : 
                    while ( $query->have_posts() ) : $query->the_post();
                        $page_post[$i]['id']        = get_the_id();
                        $page_post[$i]['title']     = get_the_title();
                        $page_post[$i]['url']       = get_the_permalink();
                        $page_post[$i]['image']  	= has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'post-thumbnail' ) : '';

                        // Push to the main array.
                        array_push( $content[$i], $page_post[$i] );
                    endwhile;
                endif;
                wp_reset_postdata();
                $i++;
            endforeach;

        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// featured section content details.
add_filter( 'magazinews_filter_featured_section_details', 'magazinews_get_featured_section_details' );


if ( ! function_exists( 'magazinews_render_featured_section' ) ) :
  /**
   * Start featured section
   *
   * @return string featured content
   * @since Magazinews 1.0.0
   *
   */
   function magazinews_render_featured_section( $content_details = array() ) {
        $options = magazinews_get_theme_options();
        $cats = ! empty( $options['featured_content_category'] ) ? $options['featured_content_category'] : array();

        if ( empty( $content_details ) ) {
            return;
        } ?>

         <div id="featured-posts" class="relative page-section">
            <div class="wrapper">
                <div class="section-header-wrapper">
                    <?php if ( ! empty( $options['featured_title'] ) ) : ?>
                        <div class="section-header">
                            <h2 class="section-title"><?php echo esc_html( $options['featured_title'] ); ?></h2>
                        </div><!-- .section-header -->
                    <?php endif; ?>

                    <ul id="ajax-filter" class="tabs">
                        <?php $i = 1; 
                        foreach ( $cats as $cat ) : ?>
                            <li data-tab="<?php echo 'featured-tab-' . absint( $cat ); ?>" data-url="<?php echo esc_url( get_category_link( $cat ) ) ?>" data-name="<?php echo esc_attr( get_cat_name( $cat ) ) ?>" <?php if ( $i == 1 ) { echo 'class="active"'; } ?>><a href="#"><?php echo esc_html( get_cat_name( $cat ) ); ?></a></li>
                        <?php $i++; endforeach; ?>
                    </ul><!-- #ajax-filter -->

                </div><!-- .section-header-wrapper -->

                <ul id="ajax-filter" class="mobile-view tabs">
                    <?php $i = 1; 
                    foreach ( $cats as $cat ) : ?>
                        <li data-tab="<?php echo 'featured-tab-' . absint( $cat ); ?>" data-url="<?php echo esc_url( get_category_link( $cat ) ) ?>" data-name="<?php echo esc_attr( get_cat_name( $cat ) ) ?>" <?php if ( $i == 1 ) { echo 'class="active"'; } ?>><a href="#"><?php echo esc_html( get_cat_name( $cat ) ); ?></a></li>
                    <?php $i++; endforeach; ?>
                </ul><!-- #ajax-filter -->

                <?php $i = 0;
                foreach ( $content_details as $content_detail ) : ?>
                    <div id="<?php echo 'featured-tab-' . absint( $cats[$i] ); ?>" class="section-content-wrapper tab-content clear col-4 <?php echo ( $i == 0 ) ? 'active' : ''; ?>">

                        <?php foreach ( $content_detail as $content ) : ?>
                            <article>
                                <div class="featured-post-wrapper">
                                    <?php if ( ! empty( $content['image'] ) ) : ?>
                                        <div class="featured-image" style="background-image:url('<?php echo esc_url( $content['image'] ); ?>');">
                                            <a href="<?php echo esc_url( $content['url'] ); ?>" class="post-thumbnail-link"></a>
                                        </div><!-- .featured-image-->
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
                                </div><!-- .featured-post-wrapper -->
                            </article>
                        <?php endforeach; ?>
                        
                    </div><!-- .section-content-wrapper -->
                <?php $i++; endforeach; ?>

            </div><!-- .wrapper -->
        </div><!-- #featured-posts -->

    <?php }
endif;