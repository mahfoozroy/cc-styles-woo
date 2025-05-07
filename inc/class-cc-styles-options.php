<?php
defined( 'ABSPATH' ) || exit;

class CC_Styles_Options {
	protected static $option_name = 'woo_cc_styles';
	protected $settings;

	public function __construct() {
		$this->settings = new Awesome_Options_Framework( [
			'option_name' => self::$option_name,
			'page_title'  => __( 'CC Styles Woo', 'cc-styles' ),
			'menu_slug'   => 'cc_styles',
			'menu_icon'   => 'dashicons-admin-appearance',
			'tab_layout'  => 'horizontal',
			'sections'    => self::get_fields(),
		] );

        // Clear woo transient caches for appearance on save
        add_action('update_option', [ $this, 'clear_appearance_transients' ], 99, 3);
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
                'label' => __('General', 'cc-styles'),
                'fields' => [
                    [
                        'id'      => 'theme',
                        'type'    => 'select',
                        'description' => __('Theme', 'cc-styles'),
                        'selector'=> 'theme',
                        'label'   => __('Theme', 'cc-styles'),
                        'description'   => __('Credit card fields base theme, flat, night or stripe default', 'cc-styles' ),
                        'options' => [
                            'stripe' => __( 'Stripe', 'cc-styles' ),
                            'night' => __( 'Night', 'cc-styles' ),
                            'flat' => __( 'Flat', 'cc-styles' ),
                        ],
                    ],
                    [
                        'id'      => 'labels',
                        'type'    => 'select',
                        'description' => __('Select the position of labels, either above input fields or floating within the field.', 'cc-styles'),
                        'selector' => 'labels',
                        'label'   => __('Labels Position', 'cc-styles'),
                        'options' => [
                            'above' => __( 'Above', 'cc-styles' ),
                            'floating' => __( 'Floating', 'cc-styles' ),
                        ],
                    ],
                    [
                        'id'       => 'colorPrimary',
                        'type'     => 'color',
                        'description' => __('Primary color for borders, active, focus etc.', 'cc-styles'),
                        'selector' => 'variables',
                        'label'   => __('Primary Color', 'cc-styles'),
                    ],
                    [
                        'id'      => 'colorText',
                        'type'    => 'color',
                        'description' => __('Text color for elements, input fields, used as a base color for inputs, labels tabs etc.', 'cc-styles'),
                        'selector' => 'variables',
                        'label'   => __('Background Color', 'cc-styles'),
                    ],
                    [
                        'id'       => 'colorDanger',
                        'type'     => 'color',
                        'description' => __('Input fields error color', 'cc-styles'),
                        'selector' => 'variables',
                        'label'   => __('Error Color', 'cc-styles'),
                    ],
                    [
                        'id'      => 'fontSizeBase',
                        'type'    => 'text',
                        'description' => __('Base font size, modifled and then used by input, labels etc', 'cc-styles'),
                        'default' => '16px',
                        'selector' => 'variables',
                        'label'   => __('Font Size', 'cc-styles'),
                    ],
                    [
                        'id'      => 'lineHeight',
                        'type'    => 'text',
                        'description' => __('Text line height for input fields', 'cc-styles'),
                        'selector' => [ '.Input', '.Input--invalid'],
                        'label'   => __('Line Height', 'cc-styles'),
                    ],
                    [
                        'id'      => 'borderRadius',
                        'type'    => 'text',
                        'description' => __('Border radius for input fields', 'cc-styles'),
                        'selector' => '.Input',
                        'label'   => __('Border Radius', 'cc-styles'),
                    ],
                    [
                        'id'      => 'spacingUnit',
                        'type'    => 'text',
                        'description' => __('Base spacing unit for inputs and labels, padding and margins etc.', 'cc-styles'),
                        'selector' => 'variables',
                        'label'   => __('Spacing', 'cc-styles'),
                    ],
                    
                ],
            ],
            'advanced' => [
                'label' => __( 'Advanced Styles', 'cc-styles' ),
                'fields' => [
                    [
                        'id' => 'input_color',
                        'css_property' => 'color',
                        'type' => 'color',
                        'selector' => [ '.Input', '.Input--invalid' ],
                        'label' => __('Input Text Color', 'cc-styles' ),
                        'description' => __('Input field text color, will be applied to credit card nummber input, expiry and security code', 'cc-styles' ),
                        'default' => '',
                    ],
                    [
                        'id' => 'input_background_color',
                        'css_property' => 'backgroundColor',
                        'type' => 'color',
                        'selector' => [ '.Input', '.Input--invalid' ],
                        'label' => __('Input Background Color', 'cc-styles' ),
                        'description' => __('Input field background color, applied to credit card nummber input, expiry and security code fields.', 'cc-styles' ),
                        'default' => '',
                    ],
                    [
                        'id' => 'input_padding',
                        'type' => 'padding',
                        'selector' => [ '.Input', '.Input--invalid' ],
                        'validate' => 'spacing',
                        'css_property' => [ 'paddingTop', 'paddingLeft', 'paddingBottom', 'paddingRight' ],
                        'label' => __('Input Padding', 'cc-styles' ),
                        'options' => [ 'top', 'left', 'bottom', 'right' ],
                        'description' => __('Input field padding, applied to credit card nummber input, expiry and security code fields.', 'cc-styles' ),
                        'default' => '',
                    ],
                    [
                        'id' => 'input_margin',
                        'type' => 'margin',
                        'selector' => [ '.Input', '.Input--invalid' ],
                        'validate' => 'spacing',
                        'css_property' => [ 'marginTop', 'marginLeft', 'marginBottom', 'marginRight' ],
                        'label' => __('Input Margin', 'cc-styles' ),
                        'options' => [ 'top', 'left', 'bottom', 'right' ],
                        'description' => __('Input field margin, will be applied to credit card nummber input, expiry and security code', 'cc-styles' ),
                        'default' => '',
                    ],
                    [
                        'id' => 'input_border',
                        'type' => 'border',
                        'selector' => [ '.Input', '.Input--invalid' ],
                        'validate' => 'spacing',
                        'css_property' => [ 'borderTop', 'borderLeft', 'borderBottom', 'borderRight' ],
                        'label' => __('Input Border Width', 'cc-styles' ),
                        'description' => __('Input field border, select a valid CSS unit as well', 'cc-styles' ),
                        'options' => [ 'top', 'left', 'bottom', 'right' ],
                        'default' => '',
                    ],
                    [
                        'id'      => 'borderStyle',
                        'type'    => 'select',
                        'description' => __('Select the border style for input fields.', 'cc-styles'),
                        'selector' => [ '.Input', '.Input--invalid' ],
                        'label'   => __('Border Style', 'cc-styles'),
                        'default' => 'solid',
                        'options' => [
                            'none' => __( 'None', 'cc-styles' ),
                            'solid' => __( 'Solid', 'cc-styles' ),
                            'dashed' => __( 'Dashed', 'cc-styles' ),
                            'dotted' => __( 'Dotted', 'cc-styles' ),
                            'double' => __( 'Double', 'cc-styles' ),
                            'groove' => __( 'Groove', 'cc-styles' ),
                            'inset' => __( 'Inset', 'cc-styles' ),
                            'ridge' => __( 'Ridge', 'cc-styles' ),
                        ],
                    ],
                    [
                        'id' => 'input_border_color',
                        'css_property' => 'borderColor',
                        'type' => 'color',
                        'selector' => [ '.Input', '.Input--invalid' ],
                        'label' => __('Input Border Color', 'cc-styles' ),
                        'description' => __('Input field border color, will be applied to credit card nummber input, expiry and security code', 'cc-styles' ),
                        'default' => '',
                    ],
                    [
                        'id' => 'label_color',
                        'type' => 'color',
                        'css_property' => 'color',
                        'selector' => '.Label',
                        'description' => __('Label text color, will be applied to credit card nummber input, expiry and security code', 'cc-styles' ),
                        'label' => __( 'Labels Color', 'cc-styles' ),
                        'default' => '',
                    ],
                    [
                        'id' => 'label_padding',
                        'type' => 'padding',
                        'selector' => '.Label',
                        'validate' => 'spacing',
                        'css_property' => [ 'paddingTop', 'paddingLeft', 'paddingBottom', 'paddingRight' ],
                        'label' => __('Labels Padding', 'cc-styles' ),
                        'description' => __('Labels Padding, select a valid CSS unit as well', 'cc-styles' ),
                        'options' => [ 'top', 'left', 'bottom', 'right' ],
                        'default' => '',
                    ],
                    [
                        'id' => 'label_margin',
                        'type' => 'margin',
                        'selector' => '.Label',
                        'validate' => 'spacing',
                        'css_property' => [ 'marginTop', 'marginLeft', 'marginBottom', 'marginRight' ],
                        'label' => __('Labels Margin', 'cc-styles' ),
                        'description' => __('Labels margin, select a valid CSS unit as well', 'cc-styles' ),
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
    public function clear_appearance_transients( $option_name, $old_value, $new_value ) {

        // Check if the option that was saved is related to your Awesome Options framework
        if ( $option_name === self::$option_name ) {
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
new CC_Styles_Options();
