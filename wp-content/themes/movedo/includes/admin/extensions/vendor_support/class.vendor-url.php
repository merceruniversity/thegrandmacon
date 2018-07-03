<?php

    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

    if ( ! class_exists( 'Redux_VendorURL' ) ) {
        class Redux_VendorURL {

            public static function get_url( $handle ) {
                if ( $handle == 'ace-editor-js' ) {
                    return get_template_directory_uri() . '/includes/admin/extensions/vendor_support/vendor/ace_editor/ace.js';
                } elseif ( $handle == 'select2-js' ) {
                    return get_template_directory_uri() . '/includes/admin/extensions/vendor_support/vendor/select2/select2.js';
                } elseif ( $handle == 'select2-css' ) {
                    return get_template_directory_uri() . '/includes/admin/extensions/vendor_support/vendor/select2/select2.css';
                }
            }
        }
    }