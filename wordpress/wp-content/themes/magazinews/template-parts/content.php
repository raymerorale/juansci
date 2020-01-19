<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Theme Palace
 * @subpackage Magazinews
 * @since Magazinews 1.0.0
 */

$options = magazinews_get_theme_options();
$class = has_post_thumbnail() ? '' : 'no-post-thumbnail';
$readmore = ! empty( $options['read_more_text'] ) ? $options['read_more_text'] : esc_html__( 'Learn More', 'magazinews' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>

    <div class="archive-post-wrapper">
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="featured-image" style="background-image:url('<?php the_post_thumbnail_url( 'post-thumbnail' ); ?>');">
                <a href="<?php the_permalink(); ?>" class="post-thumbnail-link"></a>
            </div><!-- .featured-image-->
        <?php endif; ?>

        <div class="entry-container">
            <span class="cat-links">
                <?php echo magazinews_article_footer_meta(); ?>
            </span><!-- .cat-links -->

            <header class="entry-header">
                <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            </header>

            <div class="entry-meta">
                <?php  
                    if ( ! $options['hide_date'] ) {
                        magazinews_posted_on();
                    }
                    
                    if ( ! $options['hide_author'] ) {
                        echo magazinews_author();
                    }
                ?>
            </div><!-- .entry-meta -->

            <div class="entry-content">
                <p><?php the_excerpt(); ?></p>
            </div><!-- .entry-content -->

            <div class="read-more">
                <a href="<?php the_permalink(); ?>" class="more-link">
                    <?php
                        echo magazinews_get_svg( array( 'icon' => 'angle-right' ) );
                        echo esc_html( $readmore );
                    ?>
                </a>
            </div><!-- .read-more -->
        </div><!-- .entry-container -->
    </div><!-- .archive-post-wrapper -->

</article><!-- #post-## -->
