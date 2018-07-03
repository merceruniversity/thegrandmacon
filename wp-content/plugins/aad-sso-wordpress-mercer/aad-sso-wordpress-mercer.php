<?php

/*
Plugin Name: AADSSO Mercer Customizations
Plugin URI: https://github.com/merceruniversity/aad-sso-wordpress-mercer
Description: A brief description of the Plugin.
Version: 1.0
Author: Todd Sayre
Author URI: https://github.com/Sporkyy
License: MIT
*/

class AADSSOMercer
{

    static $instance = false;

    public function __construct()
    {
        // Actions
        add_action('login_enqueue_scripts', array($this, 'add_javascript'));

        /*
         * `login_head` is used instead of `login_enqueue_scripts` for the style sheet so it will be below
         * the default stylesheet that has a `.login *` selector and, btw, `.login` targets the body tag
         */
        add_action('login_head', array($this, 'add_style_sheet'));

        // Filters
        add_filter('login_message', array($this, 'print_aad'));

        if ($_SERVER['PHP_SELF'] == '/wp-login.php') {
            ob_start(array($this, 'kill_wp_attempt_focus'));
        }
    }

    public static function kill_wp_attempt_focus($in)
    {
        $pattern     = '/\s*(wp_attempt_focus\(\);)\s*/';
        $replacement = ' /* $1 */ ';

        return preg_replace($pattern, $replacement, $in);
    }

    public static function add_style_sheet()
    {
        $html = '<link href="%s" rel="stylesheet">';
        $url  = plugins_url('aad-sso-wordpress-mercer.css', __FILE__);
        printf($html, $url);
    }

    public static function add_javascript()
    {
        $html = '<script src="%s"></script>';
        $url  = plugins_url('aad-sso-wordpress-mercer.js', __FILE__);
        printf($html, $url);
    }

    public static function print_aad()
    {
        $html = '';
        $showAadLogoutMessage = 'true' == $_GET['loggedout'];

        // BEM Block `sso`
        $html .= '<div class="sso" role="main">';

        if ($showAadLogoutMessage) {
            // BEM Block `section`
            $html .= '<div class="section section--logout">';
            $html .= '<div class="section__content">';
            $html .= '<h2 class="section__heading"><strong>Stop!</strong> You are still logged in to Azure AD.</h2>';
            $html .= '<p class="section__hint">You just logged out of WordPress. If this is a shared computer, you might also want to log out of Azure AD.</p>';
            $html .= '<p class="section__hint">Log out everywhere you are using your Mercer Office 365 account.</p>';
            $html .= '<a class="cta cta--logout" href="#">';
            $html .= '<span class="cta__icon-wrapper cta__icon-wrapper--logout">';
            $html .= '<svg class="cta__icon" height="512" width="420.677" viewBox="0 0 0420.677 512"><path d="M420.677 18.286v475.428A18.286 18.286 0 0 1 402.392 512H36.677a18.286 18.286 0 0 1-18.285-18.286v-36.571h36.571v18.286h329.143V36.57H54.963V91.43H18.392V18.286A18.286 18.286 0 0 1 36.677 0h365.715a18.286 18.286 0 0 1 18.285 18.286zm-297.874 316.16l-60.343-60.16h193.646v-36.572H62.46l60.343-60.16-25.966-25.965L5.41 243.017a18.286 18.286 0 0 0 0 25.966l91.428 91.428z"/></svg>';
            $html .= '</span>';  // .cta__icon-wrapper
            $html .= '<span class="cta__text">Office 365 SSO Log Out</span>';
            $html .= '</a>';  // .cta.cta--logout
            $html .= '</div>';  // .section__content
            $html .= '</div>';  // .section.section--logout

            // BEM Block `jump`
            $html .= '<div class="jump jump--after-logout">';
            $html .= '<div class="jump__text">';
            $html .= 'Scroll down for standard form';
            $html .= '</div>';  // .jump__text
            $html .= '<a class="jump__icon-link" href="#standard-login">';
            $html .= '<span class="u-visually-hidden">Jump to standard login form</span>';
            $html .= '<svg class="jump__icon" width="511.943" height="512" viewBox="0 0 511.943 512"><path d="M256.335 0c50.601.12 100.978 15.552 142.735 43.77 55.801 37.708 95.9 97.955 108.481 164.653 10.02 53.112 2.776 109.267-20.51 157.938-26.832 56.103-74.865 101.976-132.55 126.079-61.863 25.848-133.88 26.21-196.423.3C100.523 468.9 52.282 423.368 25.133 367.061-3.225 308.238-7.895 238.215 12.7 175.832c17.793-53.896 54.195-101.566 101.67-133.134C155.719 15.199 205.486.196 255.097.001h1.238zm-.755 47.983c-52.15.125-103.385 20.41-141.37 55.773-41.867 38.98-66.558 95.288-66.373 152.984.138 43.471 14.314 86.74 39.862 121.759 30.576 41.912 77.049 71.907 128.514 81.863 51.701 10.002 107.122-.432 151.54-28.83 41.094-26.27 72.55-67.29 86.986-113.921 16.065-51.878 10.865-110.098-14.66-158.452-29.153-55.22-83.848-96.265-146.363-107.75-12.576-2.308-25.37-3.436-38.136-3.425zm.484 280.503l125.289-125.285c2.407-2.072 2.92-2.75 5.752-4.247 7.416-3.92 16.854-3.578 23.977.897 2.712 1.704 3.172 2.42 5.418 4.665.708.962 1.422 1.924 2.13 2.885 1.486 2.808 2.033 3.462 2.862 6.555 1.549 5.795.835 12.122-1.963 17.42-1.497 2.832-2.177 3.347-4.25 5.754L276.073 376.337a22.294 22.294 0 0 1-1.537 2.011c-6.092 7.08-16.434 9.853-25.445 7.141-3.224-.907-6.27-2.473-8.861-4.702a22.645 22.645 0 0 1-3.415-3.69L96.947 237.226c-2.067-2.407-2.752-2.923-4.244-5.754-3.921-7.418-3.581-16.852.898-23.975 1.7-2.712 2.419-3.175 4.664-5.42l2.885-2.13c2.804-1.484 3.46-2.03 6.553-2.86 5.792-1.552 12.12-.837 17.418 1.963 2.833 1.496 3.351 2.175 5.758 4.247z"/></svg>';
            $html .= '</a>';  // .jump__icon-link
            $html .= '</div>';  // .jump
        }

        // BEM Block `section`
        $html .= '<div class="section section--login">';
        $html .= '<div class="section__content">';
        $html .= '<h2 class="section__heading">Log in to %s</h2>';
        $html .= '<p class="cta__hint">Use your Mercer Office 365 account to log in to WordPress</p>';
        $html .= '<a class="cta cta--login" href="#">';
        $html .= '<span class="cta__icon-wrapper cta__icon-wrapper--login">';
        $html .= '<svg class="cta__icon" height="512" width="402.286" viewBox="0 0 402.286 512"><path d="M402.286 18.286v475.428A18.286 18.286 0 0 1 384 512H18.286A18.286 18.286 0 0 1 0 493.714v-36.571h36.571v18.286h329.143V36.57H36.571V91.43H0V18.286A18.286 18.286 0 0 1 18.286 0H384a18.286 18.286 0 0 1 18.286 18.286zm-268.983 316.16l25.966 25.965 91.428-91.428a18.286 18.286 0 0 0 0-25.966L159.27 151.59l-25.966 25.965 60.343 60.16H0v36.572h193.646z"/></svg>';
        $html .= '</span>';  // .cta__icon-wrapper
        $html .= '<span class="cta__text">Office 365 SSO Log In</span>';
        $html .= '</a>';  // .cta.cta--login
        $html .= '</div>';  // .section__content
        $html .= '</div>';  // .section.section--login

        // BEM Block `jump`
        $html .= '<div class="jump jump--after-login">';
        $html .= '<div class="jump__text">';
        $html .= 'Scroll down for standard form';
        $html .= '</div>';  // .jump__text
        $html .= '<a class="jump__icon-link" href="#standard-login">';
        $html .= '<span class="u-visually-hidden">Jump to standard login form</span>';
        $html .= '<svg class="jump__icon" width="511.943" height="512" viewBox="0 0 511.943 512"><path d="M256.335 0c50.601.12 100.978 15.552 142.735 43.77 55.801 37.708 95.9 97.955 108.481 164.653 10.02 53.112 2.776 109.267-20.51 157.938-26.832 56.103-74.865 101.976-132.55 126.079-61.863 25.848-133.88 26.21-196.423.3C100.523 468.9 52.282 423.368 25.133 367.061-3.225 308.238-7.895 238.215 12.7 175.832c17.793-53.896 54.195-101.566 101.67-133.134C155.719 15.199 205.486.196 255.097.001h1.238zm-.755 47.983c-52.15.125-103.385 20.41-141.37 55.773-41.867 38.98-66.558 95.288-66.373 152.984.138 43.471 14.314 86.74 39.862 121.759 30.576 41.912 77.049 71.907 128.514 81.863 51.701 10.002 107.122-.432 151.54-28.83 41.094-26.27 72.55-67.29 86.986-113.921 16.065-51.878 10.865-110.098-14.66-158.452-29.153-55.22-83.848-96.265-146.363-107.75-12.576-2.308-25.37-3.436-38.136-3.425zm.484 280.503l125.289-125.285c2.407-2.072 2.92-2.75 5.752-4.247 7.416-3.92 16.854-3.578 23.977.897 2.712 1.704 3.172 2.42 5.418 4.665.708.962 1.422 1.924 2.13 2.885 1.486 2.808 2.033 3.462 2.862 6.555 1.549 5.795.835 12.122-1.963 17.42-1.497 2.832-2.177 3.347-4.25 5.754L276.073 376.337a22.294 22.294 0 0 1-1.537 2.011c-6.092 7.08-16.434 9.853-25.445 7.141-3.224-.907-6.27-2.473-8.861-4.702a22.645 22.645 0 0 1-3.415-3.69L96.947 237.226c-2.067-2.407-2.752-2.923-4.244-5.754-3.921-7.418-3.581-16.852.898-23.975 1.7-2.712 2.419-3.175 4.664-5.42l2.885-2.13c2.804-1.484 3.46-2.03 6.553-2.86 5.792-1.552 12.12-.837 17.418 1.963 2.833 1.496 3.351 2.175 5.758 4.247z"/></svg>';
        $html .= '</a>';  // .jump__icon-link
        $html .= '</div>';  // .jump

        $html .= '<div id="standard-login"></div>';

        $html .= '</div>';  // .sso

        printf($html, get_bloginfo('name'));
    }

    /**
     * Gets the (only) instance of the plugin. Initializes an instance if it hasn't yet.
     *
     * @return \AADSSOMercer The (only) instance of the class.
     */
    public function get_instance()
    {
        if ( ! self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

}

$aadsso = AADSSOMercer::get_instance();

