<?php
/**
 * Theme Palace basic theme structure hooks
 *
 * This file contains structural hooks.
 *
 * @package Theme Palace
 * @subpackage Magazinews
 * @since Magazinews 1.0.0
 */

$options = magazinews_get_theme_options();


if ( ! function_exists( 'magazinews_doctype' ) ) :
	/**
	 * Doctype Declaration.
	 *
	 * @since Magazinews 1.0.0
	 */
	function magazinews_doctype() {
	?>
		<!DOCTYPE html>
			<html <?php language_attributes(); ?>>
	<?php
	}
endif;

add_action( 'magazinews_doctype', 'magazinews_doctype', 10 );


if ( ! function_exists( 'magazinews_head' ) ) :
	/**
	 * Header Codes
	 *
	 * @since Magazinews 1.0.0
	 *
	 */
	function magazinews_head() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
			<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php endif;
	}
endif;
add_action( 'magazinews_before_wp_head', 'magazinews_head', 10 );

if ( ! function_exists( 'magazinews_page_start' ) ) :
	/**
	 * Page starts html codes
	 *
	 * @since Magazinews 1.0.0
	 *
	 */
	function magazinews_page_start() {
		?>
		<div id="page" class="site">
			<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'magazinews' ); ?></a>
			<div class="menu-overlay"></div>

		<?php
	}
endif;
add_action( 'magazinews_page_start_action', 'magazinews_page_start', 10 );

if ( ! function_exists( 'magazinews_page_end' ) ) :
	/**
	 * Page end html codes
	 *
	 * @since Magazinews 1.0.0
	 *
	 */
	function magazinews_page_end() {
		?>
		</div><!-- #page -->
		<?php
	}
endif;
add_action( 'magazinews_page_end_action', 'magazinews_page_end', 10 );

if ( ! function_exists( 'magazinews_header_start' ) ) :
	/**
	 * Header start html codes
	 *
	 * @since Magazinews 1.0.0
	 *
	 */
	function magazinews_header_start() { ?>
		<header id="masthead" class="site-header" role="banner">
		<?php
	}
endif;
add_action( 'magazinews_header_action', 'magazinews_header_start', 10 );

if ( ! function_exists( 'magazinews_site_branding' ) ) :
	/**
	 * Site branding codes
	 *
	 * @since Magazinews 1.0.0
	 *
	 */
	function magazinews_site_branding() {
		$options  = magazinews_get_theme_options();
		$header_txt_logo_extra = $options['header_txt_logo_extra'];		
		?>
		<div class="wrapper">
            <div class="site-branding-wrapper">
				<div class="site-branding">
					<?php if ( in_array( $header_txt_logo_extra, array( 'show-all', 'logo-title', 'logo-tagline' ) )  ) { ?>
						<div class="site-logo">
							<?php the_custom_logo(); ?>
						</div>
					<?php } 
					if ( in_array( $header_txt_logo_extra, array( 'show-all', 'title-only', 'logo-title', 'show-all', 'tagline-only', 'logo-tagline' ) ) ) : ?>
						<div id="site-details">
							<?php
							if( in_array( $header_txt_logo_extra, array( 'show-all', 'title-only', 'logo-title' ) )  ) {
								if ( magazinews_is_latest_posts() ) : ?>
									<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
								<?php else : ?>
									<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
								<?php
								endif;
							} 
							if ( in_array( $header_txt_logo_extra, array( 'show-all', 'tagline-only', 'logo-tagline' ) ) ) {
								$description = get_bloginfo( 'description', 'display' );
								if ( $description || is_customize_preview() ) : ?>
									<p class="site-description"><?php echo esc_html( $description ); /* WPCS: xss ok. */ ?></p>
								<?php
								endif; 
							}?>
						</div>
			    	<?php endif; ?>
				</div><!-- .site-branding -->

				<?php if ( ! empty( $options['ads_image'] ) && ! empty( $options['ads_url'] ) ) : ?>
					<div class="site-advertisement">
	                    <a href="<?php echo esc_url( $options['ads_url'] ); ?>"><img src="<?php echo esc_url( $options['ads_image'] ); ?>"></a>
	                </div><!-- .site-advertisement -->
	            <?php endif; ?>
			</div><!-- .site-branding-wrapper -->
		</div><!-- .wrapper -->
		<?php
	}
endif;
add_action( 'magazinews_header_action', 'magazinews_site_branding', 20 );

if ( ! function_exists( 'magazinews_site_navigation' ) ) :
	/**
	 * Site navigation codes
	 *
	 * @since Magazinews 1.0.0
	 *
	 */
	function magazinews_site_navigation() {
		$options = magazinews_get_theme_options();
		?>
		<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
			<?php
			echo magazinews_get_svg( array( 'icon' => 'menu' ) );
			echo magazinews_get_svg( array( 'icon' => 'close' ) );
			?>		
			<span class="menu-label"><?php esc_html_e( 'Menu', 'magazinews' ); ?></span>			
		</button>
		<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="Primary Menu">
			<div class="wrapper">
				<?php 
					$search = '';
					if ( $options['nav_search_enable'] ) :
						$search = '<li class="main-navigation-search">';
						$search .= get_search_form( $echo = false );
		                $search .= '</li>';
	                endif;

	        		$defaults = array(
	        			'theme_location' => 'primary',
	        			'container' => false,
	        			'menu_class' => 'menu nav-menu',
	        			'menu_id' => 'primary-menu',
	        			'echo' => true,
	        			'fallback_cb' => 'magazinews_menu_fallback_cb',
	        			'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s' . $search . '</ul>',
	        		);
	        	
	        		wp_nav_menu( $defaults );
	        	?>
        	</div><!-- .wrapper -->
		</nav><!-- #site-navigation -->
		<?php
	}
endif;
add_action( 'magazinews_header_action', 'magazinews_site_navigation', 30 );


if ( ! function_exists( 'magazinews_header_end' ) ) :
	/**
	 * Header end html codes
	 *
	 * @since Magazinews 1.0.0
	 *
	 */
	function magazinews_header_end() {
		?>
		</header><!-- #masthead -->
		<?php
	}
endif;

add_action( 'magazinews_header_action', 'magazinews_header_end', 50 );

if ( ! function_exists( 'magazinews_content_start' ) ) :
	/**
	 * Site content codes
	 *
	 * @since Magazinews 1.0.0
	 *
	 */
	function magazinews_content_start() {
		?>
		<div id="content" class="site-content">
		<?php
	}
endif;
add_action( 'magazinews_content_start_action', 'magazinews_content_start', 10 );

if ( ! function_exists( 'magazinews_header_image' ) ) :
	/**
	 * Header Image codes
	 *
	 * @since Magazinews 1.0.0
	 *
	 */
	function magazinews_header_image() {
		if ( magazinews_is_frontpage() )
			return;
		$header_image = get_header_image();
		if ( is_singular() ) :
			$header_image = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'full' ) : $header_image;
		endif;
		?>

		<div id="page-site-header" class="relative" style="background-image: url('<?php echo esc_url( $header_image ); ?>');">
            <div class="overlay"></div>
            <div class="wrapper">
                <header class="page-header">
                    <h2 class="page-title"><?php echo magazinews_custom_header_banner_title(); ?></h2>
                </header>

                <?php magazinews_add_breadcrumb(); ?>
            </div><!-- .wrapper -->
        </div><!-- #page-site-header -->
		<?php
	}
endif;
add_action( 'magazinews_header_image_action', 'magazinews_header_image', 10 );

if ( ! function_exists( 'magazinews_add_breadcrumb' ) ) :
	/**
	 * Add breadcrumb.
	 *
	 * @since Magazinews 1.0.0
	 */
	function magazinews_add_breadcrumb() {
		$options = magazinews_get_theme_options();
		// Bail if Breadcrumb disabled.
		$breadcrumb = $options['breadcrumb_enable'];
		if ( false === $breadcrumb ) {
			return;
		}
		
		// Bail if Home Page.
		if ( magazinews_is_frontpage() ) {
			return;
		}

		echo '<div id="breadcrumb-list">';
				/**
				 * magazinews_simple_breadcrumb hook
				 *
				 * @hooked magazinews_simple_breadcrumb -  10
				 *
				 */
				do_action( 'magazinews_simple_breadcrumb' );
		echo '</div><!-- #breadcrumb-list -->';
		return;
	}
endif;
add_action( 'magazinews_header_image_action', 'magazinews_add_breadcrumb', 20 );

if ( ! function_exists( 'magazinews_content_end' ) ) :
	/**
	 * Site content codes
	 *
	 * @since Magazinews 1.0.0
	 *
	 */
	function magazinews_content_end() {
		?>
			<div class="menu-overlay"></div>
		</div><!-- #content -->
		<?php
	}
endif;
add_action( 'magazinews_content_end_action', 'magazinews_content_end', 10 );

if ( ! function_exists( 'magazinews_footer_start' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Magazinews 1.0.0
	 *
	 */
	function magazinews_footer_start() {
		?>
		<footer id="colophon" class="site-footer" role="contentinfo">
		<?php
	}
endif;
add_action( 'magazinews_footer', 'magazinews_footer_start', 10 );

if ( ! function_exists( 'magazinews_footer_site_info' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Magazinews 1.0.0
	 *
	 */
	function magazinews_footer_site_info() {
		$theme_data = wp_get_theme();
		$options = magazinews_get_theme_options();
		$search = array( '[the-year]', '[site-link]' );

        $replace = array( date( 'Y' ), '<a href="'. esc_url( home_url( '/' ) ) .'">'. esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>' );

        $options['copyright_text'] = str_replace( $search, $replace, $options['copyright_text'] );

		$copyright_text = $options['copyright_text']; 
		?>
		<div class="site-info col-<?php echo ! empty( $options['footer_image'] ) ? 2 : 1; ?>">
            <div class="wrapper">
            	<?php if ( ! empty( $options['footer_image'] ) ) : ?>
	            	<span><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $options['footer_image'] ); ?>" alt="<?php bloginfo( 'name' ); ?>"></a></span>
	            <?php endif; ?>

                <span>
                	<?php 
                	echo magazinews_santize_allow_tag( $copyright_text ); 
                	echo esc_html( $theme_data->get( 'Name') ) . '&nbsp;' . esc_html__( 'by', 'magazinews' ). '&nbsp;<a target="_blank" href="'. esc_url( $theme_data->get( 'AuthorURI' ) ) .'">'. esc_html( ucwords( $theme_data->get( 'Author' ) ) ) .'</a>';
                	if ( function_exists( 'the_privacy_policy_link' ) ) {
						the_privacy_policy_link( ' | ' );
					}
                	?>
            	</span>
            </div><!-- .wrapper -->    
        </div><!-- .site-info -->

		<?php
	}
endif;
add_action( 'magazinews_footer', 'magazinews_footer_site_info', 40 );

if ( ! function_exists( 'magazinews_footer_scroll_to_top' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Magazinews 1.0.0
	 *
	 */
	function magazinews_footer_scroll_to_top() {
		$options  = magazinews_get_theme_options();
		if ( true === $options['scroll_top_visible'] ) : ?>
			<div class="backtotop"><?php echo magazinews_get_svg( array( 'icon' => 'up' ) ); ?></div>
		<?php endif;
	}
endif;
add_action( 'magazinews_footer', 'magazinews_footer_scroll_to_top', 40 );

if ( ! function_exists( 'magazinews_footer_end' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Magazinews 1.0.0
	 *
	 */
	function magazinews_footer_end() {
		?>
		</footer>
		<div class="popup-overlay"></div>
		<?php
	}
endif;
add_action( 'magazinews_footer', 'magazinews_footer_end', 100 );

