<?php
/**
 * Options definitions class.
 *
 */
defined( 'ABSPATH' ) || exit;

class CC_Styles_Options {
	protected static $option_name = 'woo_cc_styles';
	protected $settings;

	public function __construct() {
		$this->settings = new Awesome_Options_Framework( [
			'option_name' => self::$option_name,
			'page_title'  => __( 'CC Styles Woo', 'cc-styles-woo' ),
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
                'label' => __('General', 'cc-styles-woo'),
                'fields' => [
                    [
                        'id'      => 'theme',
                        'type'    => 'select',
                        'description' => __('Theme', 'cc-styles-woo'),
                        'selector'=> 'theme',
                        'label'   => __('Theme', 'cc-styles-woo'),
                        'description'   => __('Credit card fields base theme, flat, night or stripe default', 'cc-styles-woo' ),
                        'options' => [
                            'stripe' => __( 'Stripe', 'cc-styles-woo' ),
                            'night' => __( 'Night', 'cc-styles-woo' ),
                            'flat' => __( 'Flat', 'cc-styles-woo' ),
                        ],
                    ],
                    [
                        'id'      => 'labels',
                        'type'    => 'select',
                        'description' => __('Select the position of labels, either above input fields or floating within the field.', 'cc-styles-woo'),
                        'selector' => 'labels',
                        'label'   => __('Labels Position', 'cc-styles-woo'),
                        'options' => [
                            'above' => __( 'Above', 'cc-styles-woo' ),
                            'floating' => __( 'Floating', 'cc-styles-woo' ),
                        ],
                    ],
                    [
                        'id'       => 'colorPrimary',
                        'type'     => 'color',
                        'description' => __('Primary color for borders, active, focus etc.', 'cc-styles-woo'),
                        'selector' => 'variables',
                        'label'   => __('Primary Color', 'cc-styles-woo'),
                    ],
                    [
                        'id'      => 'colorText',
                        'type'    => 'color',
                        'description' => __('Text color for elements, input fields, used as a base color for inputs, labels tabs etc.', 'cc-styles-woo'),
                        'selector' => 'variables',
                        'label'   => __('Background Color', 'cc-styles-woo'),
                    ],
                    [
                        'id'       => 'colorDanger',
                        'type'     => 'color',
                        'description' => __('Input fields error color', 'cc-styles-woo'),
                        'selector' => 'variables',
                        'label'   => __('Error Color', 'cc-styles-woo'),
                    ],
                    [
                        'id'      => 'fontSizeBase',
                        'type'    => 'text',
                        'description' => __('Base font size, modifled and then used by input, labels etc', 'cc-styles-woo'),
                        'default' => '16px',
                        'selector' => 'variables',
                        'label'   => __('Font Size', 'cc-styles-woo'),
                    ],
                    [
                        'id'      => 'lineHeight',
                        'type'    => 'text',
                        'description' => __('Text line height for input fields', 'cc-styles-woo'),
                        'selector' => [ '.Input', '.Input--invalid'],
                        'label'   => __('Line Height', 'cc-styles-woo'),
                    ],
                    [
                        'id'      => 'borderRadius',
                        'type'    => 'text',
                        'description' => __('Border radius for input fields', 'cc-styles-woo'),
                        'selector' => '.Input',
                        'label'   => __('Border Radius', 'cc-styles-woo'),
                    ],
                    [
                        'id'      => 'spacingUnit',
                        'type'    => 'text',
                        'description' => __('Base spacing unit for inputs and labels, padding and margins etc.', 'cc-styles-woo'),
                        'selector' => 'variables',
                        'label'   => __('Spacing', 'cc-styles-woo'),
                    ],
                    
                ],
            ],
            'advanced' => [
                'label' => __( 'Advanced Styles', 'cc-styles-woo' ),
                'fields' => [
                    [
                        'id' => 'input_color',
                        'css_property' => 'color',
                        'type' => 'color',
                        'selector' => [ '.Input', '.Input--invalid' ],
                        'label' => __('Input Text Color', 'cc-styles-woo' ),
                        'description' => __('Input field text color, will be applied to credit card nummber input, expiry and security code', 'cc-styles-woo' ),
                        'default' => '',
                    ],
                    [
                        'id' => 'input_background_color',
                        'css_property' => 'backgroundColor',
                        'type' => 'color',
                        'selector' => [ '.Input', '.Input--invalid' ],
                        'label' => __('Input Background Color', 'cc-styles-woo' ),
                        'description' => __('Input field background color, applied to credit card nummber input, expiry and security code fields.', 'cc-styles-woo' ),
                        'default' => '',
                    ],
                    [
                        'id' => 'input_padding',
                        'type' => 'padding',
                        'selector' => [ '.Input', '.Input--invalid' ],
                        'validate' => 'spacing',
                        'css_property' => [ 'paddingTop', 'paddingLeft', 'paddingBottom', 'paddingRight' ],
                        'label' => __('Input Padding', 'cc-styles-woo' ),
                        'options' => [ 'top', 'left', 'bottom', 'right' ],
                        'description' => __('Input field padding, applied to credit card nummber input, expiry and security code fields.', 'cc-styles-woo' ),
                        'default' => '',
                    ],
                    [
                        'id' => 'input_margin',
                        'type' => 'margin',
                        'selector' => [ '.Input', '.Input--invalid' ],
                        'validate' => 'spacing',
                        'css_property' => [ 'marginTop', 'marginLeft', 'marginBottom', 'marginRight' ],
                        'label' => __('Input Margin', 'cc-styles-woo' ),
                        'options' => [ 'top', 'left', 'bottom', 'right' ],
                        'description' => __('Input field margin, will be applied to credit card nummber input, expiry and security code', 'cc-styles-woo' ),
                        'default' => '',
                    ],
                    [
                        'id' => 'input_border',
                        'type' => 'border',
                        'selector' => [ '.Input', '.Input--invalid' ],
                        'validate' => 'spacing',
                        'css_property' => [ 'borderTop', 'borderLeft', 'borderBottom', 'borderRight' ],
                        'label' => __('Input Border Width', 'cc-styles-woo' ),
                        'description' => __('Input field border, select a valid CSS unit as well', 'cc-styles-woo' ),
                        'options' => [ 'top', 'left', 'bottom', 'right' ],
                        'default' => '',
                    ],
                    [
                        'id'      => 'borderStyle',
                        'type'    => 'select',
                        'description' => __('Select the border style for input fields.', 'cc-styles-woo'),
                        'selector' => [ '.Input', '.Input--invalid' ],
                        'label'   => __('Border Style', 'cc-styles-woo'),
                        'default' => 'solid',
                        'options' => [
                            'none' => __( 'None', 'cc-styles-woo' ),
                            'solid' => __( 'Solid', 'cc-styles-woo' ),
                            'dashed' => __( 'Dashed', 'cc-styles-woo' ),
                            'dotted' => __( 'Dotted', 'cc-styles-woo' ),
                            'double' => __( 'Double', 'cc-styles-woo' ),
                            'groove' => __( 'Groove', 'cc-styles-woo' ),
                            'inset' => __( 'Inset', 'cc-styles-woo' ),
                            'ridge' => __( 'Ridge', 'cc-styles-woo' ),
                        ],
                    ],
                    [
                        'id' => 'input_border_color',
                        'css_property' => 'borderColor',
                        'type' => 'color',
                        'selector' => [ '.Input', '.Input--invalid' ],
                        'label' => __('Input Border Color', 'cc-styles-woo' ),
                        'description' => __('Input field border color, will be applied to credit card nummber input, expiry and security code', 'cc-styles-woo' ),
                        'default' => '',
                    ],
                    [
                        'id' => 'label_color',
                        'type' => 'color',
                        'css_property' => 'color',
                        'selector' => '.Label',
                        'description' => __('Label text color, will be applied to credit card nummber input, expiry and security code', 'cc-styles-woo' ),
                        'label' => __( 'Labels Color', 'cc-styles-woo' ),
                        'default' => '',
                    ],
                    [
                        'id' => 'label_padding',
                        'type' => 'padding',
                        'selector' => '.Label',
                        'validate' => 'spacing',
                        'css_property' => [ 'paddingTop', 'paddingLeft', 'paddingBottom', 'paddingRight' ],
                        'label' => __('Labels Padding', 'cc-styles-woo' ),
                        'description' => __('Labels Padding, select a valid CSS unit as well', 'cc-styles-woo' ),
                        'options' => [ 'top', 'left', 'bottom', 'right' ],
                        'default' => '',
                    ],
                    [
                        'id' => 'label_margin',
                        'type' => 'margin',
                        'selector' => '.Label',
                        'validate' => 'spacing',
                        'css_property' => [ 'marginTop', 'marginLeft', 'marginBottom', 'marginRight' ],
                        'label' => __('Labels Margin', 'cc-styles-woo' ),
                        'description' => __('Labels margin, select a valid CSS unit as well', 'cc-styles-woo' ),
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
	 * To clear transients on save
	 */
    public function clear_appearance_transients( $option_name, $old_value, $new_value ) {

        // Check if the option that was saved is related to your Awesome Options framework
        if ( $option_name === self::$option_name ) {
            self::clear_woo_transients();
        }
    }
    /**
	 * To clear transients
	 */
    public static function clear_woo_transients() {
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

// Initialize the settings class
new CC_Styles_Options();
