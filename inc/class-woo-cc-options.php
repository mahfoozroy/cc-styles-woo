<?php
defined( 'ABSPATH' ) || exit;

class CC_Style_Options {
	protected static $option_name = 'woo_cc_styles';
	protected $settings;

	public function __construct() {
		$this->settings = new Awesome_Options_Framework( [
			'option_name' => self::$option_name,
			'page_title'  => __( 'Woo CC Styles', 'woo-cc' ),
			'menu_slug'   => 'woo_cc_styles',
			'menu_icon'   => 'dashicons-admin-appearance',
			'tab_layout'  => 'horizontal',
			'sections'    => self::get_fields(),
		] );

        // Clear woo transient caches for appearance on save
        add_action('update_option', 'clear_woo_appearance_transients', 10, 3);
	}

	/**
	 * Static getter for option name
	 */
	public static function get_option_name() {
		return self::$option_name;
	}

	/**
	 * Static access to field definitions
	 */
	public static function get_fields() {
		return [
            'general' => [
                'label' => __('General', 'woo-cc'),
                'fields' => [
                    [
                        'id'      => 'theme',
                        'type'    => 'select',
                        'description' => __('Theme', 'woo-cc'),
                        'selector'=> 'theme',
                        'label'   => __('Theme', 'woo-cc'),
                        'description'   => __('Credit card fields base theme, flat, night or stripe default', 'woo-cc' ),
                        'options' => [
                            'stripe' => __( 'Stripe', 'woo-cc' ),
                            'night' => __( 'Night', 'woo-cc' ),
                            'flat' => __( 'Flat', 'woo-cc' ),
                        ],
                    ],
                    [
                        'id'      => 'labels',
                        'type'    => 'select',
                        'description' => __('Select the position of labels, either above input fields or floating within the field.', 'woo-cc'),
                        'selector' => 'labels',
                        'label'   => __('Labels Position', 'woo-cc'),
                        'options' => [
                            'above' => __( 'Above', 'woo-cc' ),
                            'floating' => __( 'Floating', 'woo-cc' ),
                        ],
                    ],
                    [
                        'id'       => 'colorPrimary',
                        'type'     => 'color',
                        'description' => __('Primary color for borders, active, focus etc.', 'woo-cc'),
                        'selector' => 'variables',
                        'label'   => __('Primary Color', 'woo-cc'),
                    ],
                    [
                        'id'      => 'colorText',
                        'type'    => 'color',
                        'description' => __('Text color for elements, input fields, used as a base color for inputs, labels tabs etc.', 'woo-cc'),
                        'selector' => 'variables',
                        'label'   => __('Background Color', 'woo-cc'),
                    ],
                    [
                        'id'       => 'colorDanger',
                        'type'     => 'color',
                        'description' => __('Input fields error color', 'woo-cc'),
                        'selector' => 'variables',
                        'label'   => __('Error Color', 'woo-cc'),
                    ],
                    [
                        'id'      => 'fontSizeBase',
                        'type'    => 'text',
                        'description' => __('Base font size, modifled and then used by input, labels etc', 'woo-cc'),
                        'default' => '16px',
                        'selector' => 'variables',
                        'label'   => __('Font Size', 'woo-cc'),
                    ],
                    [
                        'id'      => 'lineHeight',
                        'type'    => 'text',
                        'description' => __('Text line height for input fields', 'woo-cc'),
                        'selector' => [ '.Input', '.Input--invalid'],
                        'label'   => __('Line Height', 'woo-cc'),
                    ],
                    [
                        'id'      => 'borderRadius',
                        'type'    => 'text',
                        'description' => __('Border radius for input fields', 'woo-cc'),
                        'selector' => '.Input',
                        'label'   => __('Border Radius', 'woo-cc'),
                    ],
                    [
                        'id'      => 'spacingUnit',
                        'type'    => 'text',
                        'description' => __('Base spacing unit for inputs and labels, padding and margins etc.', 'woo-cc'),
                        'selector' => 'variables',
                        'label'   => __('Spacing', 'woo-cc'),
                    ],
                    
                ],
            ],
            'advanced' => [
                'label' => __( 'Advanced Styles', 'woo-cc' ),
                'fields' => [
                    [
                        'id' => 'input_color',
                        'css_property' => 'color',
                        'type' => 'color',
                        'selector' => [ '.Input', '.Input--invalid' ],
                        'label' => __('Input fields text color', 'woo-cc' ),
                        'default' => '',
                    ],
                    [
                        'id' => 'input_background_color',
                        'css_property' => 'color',
                        'css_property' => 'backgroundColor',
                        'type' => 'color',
                        'selector' => [ '.Input', '.Input--invalid' ],
                        'label' => __('Input fields text color', 'woo-cc' ),
                        'default' => '',
                    ],
                    [
                        'id' => 'input_padding',
                        'type' => 'padding',
                        'selector' => '.Input',
                        'validate' => 'spacing',
                        'css_property' => [ 'paddingTop', 'paddingLeft', 'paddingBottom', 'paddingRight' ],
                        'label' => __('Input Fields Padding', 'woo-cc' ),
                        'options' => [ 'top', 'left', 'bottom', 'right' ],
                        'default' => '',
                    ],
                    [
                        'id' => 'input_margin',
                        'type' => 'margin',
                        'selector' => '.Input',
                        'validate' => 'spacing',
                        'css_property' => [ 'marginTop', 'marginLeft', 'marginBottom', 'marginRight' ],
                        'label' => __('Input Fields Margin', 'woo-cc' ),
                        'options' => [ 'top', 'left', 'bottom', 'right' ],
                        'default' => '',
                    ],
                    [
                        'id' => 'label_color',
                        'type' => 'color',
                        'css_property' => 'color',
                        'selector' => '.Label',
                        'label' => __( 'Labels Color', 'woo-cc' ),
                        'default' => '',
                    ],
                    [
                        'id' => 'label_padding',
                        'type' => 'padding',
                        'selector' => '.Label',
                        'validate' => 'spacing',
                        'css_property' => [ 'paddingTop', 'paddingLeft', 'paddingBottom', 'paddingRight' ],
                        'label' => __('Labels Padding', 'woo-cc' ),
                        'description' => __('Labels Padding, select a valid CSS unit as well', 'woo-cc' ),
                        'options' => [ 'top', 'left', 'bottom', 'right' ],
                        'default' => '',
                    ],
                    [
                        'id' => 'label_margin',
                        'type' => 'margin',
                        'selector' => '.Label',
                        'validate' => 'spacing',
                        'css_property' => [ 'marginTop', 'marginLeft', 'marginBottom', 'marginRight' ],
                        'label' => __('Labels Margin', 'woo-cc' ),
                        'description' => __('Labels margin, select a valid CSS unit as well', 'woo-cc' ),
                        'options' => [ 'top', 'left', 'bottom', 'right' ],
                        'default' => '',
                    ],
                ],
            ],
        
        ];
	}

	/**
	 * Helper to get a single option value
	 */
	public static function get_option( $key, $default = null ) {
		$options = get_option( self::$option_name, [] );
		return $options[$key] ?? $default;
	}

	/**
	 * Helper to get all saved options
	 */
	public static function get_all_options() {
		return get_option( self::$option_name, [] );
	}

    /**
	 * To clear transients
	 */
    function clear_woo_appearance_transients( $option_name, $old_value, $new_value ) {

        // Check if the option that was saved is related to your Awesome Options framework
        if ( $option_name === $this->option_name ) {
            delete_transient( 'upe_process_redirect_order_id_mismatched' );
            delete_transient( 'wcpay_upe_appearance' );
            delete_transient( 'wcpay_upe_add_payment_method_appearance' );
            delete_transient( 'wcpay_wc_blocks_upe_appearance' );
            delete_transient( 'wcpay_upe_bnpl_product_page_appearance' );
            delete_transient( 'wcpay_upe_bnpl_classic_cart_appearance' );
            delete_transient( 'wcpay_upe_bnpl_cart_block_appearance' );
            delete_transient( 'wcpay_upe_appearance_theme' );
            delete_transient( 'wcpay_upe_add_payment_method_appearance_theme' );
            delete_transient( 'wcpay_wc_blocks_upe_appearance_theme' );
            delete_transient( 'wcpay_upe_bnpl_product_page_appearance_theme' );
            delete_transient( 'wcpay_upe_bnpl_classic_cart_appearance_theme' );
            delete_transient( 'wcpay_upe_bnpl_cart_block_appearance_theme' );
        }
    }
}

// Initialize the settings class
new CC_Style_Options();
