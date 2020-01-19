<?php
/**
 * List block part for displaying header content in page.php
 *
 * @package Newsium
 */

?>
<?php
$class = '';
$background = '';
if (has_header_image()) {
    $class = 'data-bg';
    $background = get_header_image();
}
$show_date = newsium_get_option('show_date_section');
$show_social_menu = newsium_get_option('show_social_menu_section');

$header_layout = newsium_get_option('header_layout');

if ($header_layout == 'header-layout-2') {
    $header_class = 'logo-centered';
} else {
    $header_class = '';
}
?>
<?php if (is_active_sidebar('off-canvas-panel') || (has_nav_menu('aft-social-nav') && $show_social_menu == true) || ($show_date == true)) : ?>
    <div class="top-header">
        <div class="container-wrapper">
            <div class="top-bar-flex">
                <div class="top-bar-left col-2">

                    <?php if (is_active_sidebar('off-canvas-panel')) : ?>
                        <div class="off-cancas-panel">
  							<span class="offcanvas">
  								<a href="#" class="offcanvas-nav">
  									<div class="offcanvas-menu">
  										<span class="mbtn-top"></span>
  										<span class="mbtn-mid"></span>
  										<span class="mbtn-bot"></span>
  									</div>
  								</a>
  							</span>
                        </div>
                    <?php endif; ?>

                    <div class="date-bar-left">
                        <?php

                        if ($show_date == true): ?>
                            <span class="topbar-date">
                                        <?php
                                        echo date_i18n('D. M jS, Y ', strtotime(current_time("Y-m-d")));
                                        ?>
                                    </span>

                        <?php endif; ?>
                        <?php
                        $aft_language_switcher = newsium_get_option('aft_language_switcher');
                        if (!empty($aft_language_switcher)):
                            ?>
                            <span class="language-icon">
                                <?php echo do_shortcode($aft_language_switcher); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="top-bar-right col-2">
  						<span class="aft-small-social-menu">
  							<?php

                            if (has_nav_menu('aft-social-nav') && $show_social_menu == true): ?>

                                <?php
                                wp_nav_menu(array(
                                    'theme_location' => 'aft-social-nav',
                                    'link_before' => '<span class="screen-reader-text">',
                                    'link_after' => '</span>',
                                    'menu_id' => 'social-menu',
                                    'container' => 'div',
                                    'container_class' => 'social-navigation'
                                ));
                                ?>

                            <?php endif; ?>
  						</span>
                </div>
            </div>
        </div>

    </div>
<?php endif; ?>
<div class="main-header <?php echo esc_attr($header_class); ?> <?php echo esc_attr($class); ?>"
     data-background="<?php echo esc_attr($background); ?>">
    <div class="container-wrapper">
        <div class="af-container-row af-flex-container">
            <div class="col-3 float-l pad">
                <div class="logo-brand">
                    <div class="site-branding">
                        <?php
                        the_custom_logo();
                        if (is_front_page() || is_home()) : ?>
                            <h1 class="site-title font-family-1">
                                <a href="<?php echo esc_url(home_url('/')); ?>"
                                   rel="home"><?php bloginfo('name'); ?></a>
                            </h1>
                        <?php else : ?>
                            <p class="site-title font-family-1">
                                <a href="<?php echo esc_url(home_url('/')); ?>"
                                   rel="home"><?php bloginfo('name'); ?></a>
                            </p>
                        <?php endif; ?>

                        <?php
                        $description = get_bloginfo('description', 'display');
                        if ($description || is_customize_preview()) : ?>
                            <p class="site-description"><?php echo esc_html($description); ?></p>
                        <?php
                        endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-66 float-l pad">
                <?php
                $banner_advertisement_scope = newsium_get_option('banner_advertisement_scope');
                if($banner_advertisement_scope == 'front-page-only'){
                    if( is_home() || is_front_page() ){
                        do_action('newsium_action_banner_advertisement');
                    }
                } else {
                    do_action('newsium_action_banner_advertisement');

                }

                ?>
            </div>
        </div>
    </div>

</div>