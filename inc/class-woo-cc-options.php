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
                        'description' => __('Theme', 'aof'),
                        'selector'=> 'theme',
                        'label'   => __('Theme', 'aof'),
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
                        'description' => __('Select the position of labels, either above input fields or floating within the field.', 'aof'),
                        'selector' => 'labels',
                        'label'   => __('Labels Position', 'aof'),
                        'options' => [
                            'above' => __( 'Above', 'woo-cc' ),
                            'floating' => __( 'Floating', 'woo-cc' ),
                        ],
                    ],
                    [
                        'id'       => 'colorPrimary',
                        'type'     => 'color',
                        'description' => __('Primary color for borders, active, focus etc.', 'aof'),
                        'selector' => 'variables',
                        'label'   => __('Primary Color', 'aof'),
                    ],
                    [
                        'id'      => 'colorBackground',
                        'type'    => 'color',
                        'description' => __('Background color for elements, input fields, used as a base color for inputs, labels tabs etc.', 'aof'),
                        'selector' => 'variables',
                        'label'   => __('Background Color', 'aof'),
                    ],
                    [
                        'id'       => 'colorDanger',
                        'type'     => 'color',
                        'description' => __('Input fields error color', 'aof'),
                        'selector' => 'variables',
                        'label'   => __('Error Color', 'aof'),
                    ],
                    [
                        'id'      => 'fontSizeBase',
                        'type'    => 'text',
                        'description' => __('Base font size, modifled and then used by input, labels etc', 'aof'),
                        'default' => '16px',
                        'selector' => 'variables',
                        'label'   => __('Font Size', 'aof'),
                    ],
                    [
                        'id'      => 'lineHeight',
                        'type'    => 'text',
                        'description' => __('Text line height for input fields', 'aof'),
                        'selector' => '.Input',
                        'label'   => __('Line Height', 'aof'),
                    ],
                    [
                        'id'      => 'borderRadius',
                        'type'    => 'text',
                        'description' => __('Border radius for input fields', 'aof'),
                        'selector' => '.Input',
                        'label'   => __('Border Radius', 'aof'),
                    ],
                    [
                        'id'      => 'spacingUnit',
                        'type'    => 'text',
                        'description' => __('Base spacing for inputs and labels, padding and margins etc.', 'aof'),
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
                        'selector' => '.Input',
                        'label' => __('Input Fields Color', 'woo-cc' ),
                        'default' => '',
                    ],
                    [
                        'id' => 'input_padding',
                        'type' => 'spacing',
                        //'selector' => '.Input',
                        'label' => __('Input Fields Padding', 'woo-cc' ),
                        'options' => [ 'top', 'left', 'bottom', 'right' ],
                        'default' => '',
                    ],
                    [
                        'id' => 'input_margin',
                        'type' => 'spacing',
                       // 'selector' => '.Input',
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
                        'type' => 'spacing',
                        //'selector' => '.Label',
                        'label' => __('Labels Padding', 'woo-cc' ),
                        'description' => __('Labels Padding, select a valid CSS unit as well', 'woo-cc' ),
                        'options' => [ 'top', 'left', 'bottom', 'right' ],
                        'default' => '',
                    ],
                    [
                        'id' => 'label_margin',
                        'type' => 'spacing',
                        //'selector' => '.Label',
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
}

// Initialize the settings class
new CC_Style_Options();
