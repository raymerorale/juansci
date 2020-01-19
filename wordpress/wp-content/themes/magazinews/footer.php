<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Theme Palace
 * @subpackage Magazinews
 * @since Magazinews 1.0.0
 */

/**
 * magazinews_footer_primary_content hook
 *
 * @hooked magazinews_add_contact_section -  10
 *
 */
do_action( 'magazinews_footer_primary_content' );

/**
 * magazinews_content_end_action hook
 *
 * @hooked magazinews_content_end -  10
 *
 */
do_action( 'magazinews_content_end_action' );

/**
 * magazinews_content_end_action hook
 *
 * @hooked magazinews_footer_start -  10
 * @hooked Magazinews_Footer_Widgets->add_footer_widgets -  20
 * @hooked magazinews_footer_site_info -  40
 * @hooked magazinews_footer_end -  100
 *
 */
do_action( 'magazinews_footer' );

/**
 * magazinews_page_end_action hook
 *
 * @hooked magazinews_page_end -  10
 *
 */
do_action( 'magazinews_page_end_action' ); 

?>

<?php wp_footer(); ?>

</body>
</html>
