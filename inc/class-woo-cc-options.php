<?php
defined( 'ABSPATH' ) || exit;

class CC_Style_Options {
    private $option_name = 'woo_cc_styles';
    private $settings;

    public function __construct() {
        $this->settings = new Awesome_Options_Framework( [
            'option_name' => $this->option_name,
            'page_title'  => __( 'Woo CC Styles', 'woo-cc' ),
            'menu_slug'   => 'woo_cc_styles',
            'menu_icon'    => 'dashicons-admin-appearance', 
            'tab_layout'  => 'horizontal',
            'sections'      => $this->get_fields(),
        ] );
    }
    private function get_fields() {
    
        $sections  = [
        'general' => [
            'label' => __('General', 'aof'),
            'fields' => [
                [
                    'id'      => 'theme',
                    'type'    => 'select',
                    'selector'=> 'theme',
                    'label'   => __('Theme', 'aof'),
                    'options' => [
                        'stripe' => __( 'Stripe', 'woo-cc' ),
                        'night' => __( 'Night', 'woo-cc' ),
                        'flat' => __( 'Flat', 'woo-cc' ),
                    ],
                ],
                [
                    'id'       => 'colorPrimary',
                    'type'     => 'color',
                    'selector' => 'variables',
                    'label'   => __('Primary Color', 'aof'),
                ],
                [
                    'id'      => 'colorBackground',
                    'type'    => 'color',
                    'selector' => 'variables',
                    'label'   => __('Background Color', 'aof'),
                ],
                [
                    'id'       => 'colorDanger',
                    'type'     => 'color',
                    'selector' => 'variables',
                    'label'   => __('Error Color', 'aof'),
                ],
                [
                    'id'      => 'fontSizeBase',
                    'type'    => 'text',
                    'default' => '16px',
                    'selector' => 'variables',
                    'label'   => __('Font Size', 'aof'),
                ],
                [
                    'id'      => 'fontLineHeight',
                    'type'    => 'text',
                    'selector' => 'variables',
                    'label'   => __('Line Height', 'aof'),
                ],
                [
                    'id'      => 'borderRadius',
                    'type'    => 'text',
                    'selector' => 'variables',
                    'label'   => __('Border Radius', 'aof'),
                ],
                [
                    'id'      => 'spacingUnit',
                    'type'    => 'text',
                    'selector' => 'variables',
                    'label'   => __('Spacing', 'aof'),
                ],
                
            ],
        ],
        'advanced' => [
            'label' => __('Advanced Styles', 'aof'),
            'fields' => [
                [
                    'id' => 'input_field_color',
                    'type' => 'color',
                    'selector' => '.Input',
                    'label' => __('Input Field Color', 'woo-cc'),
                    'default' => '',
                ],
                [
                    'id' => 'label_color',
                    'type' => 'color',
                    'selector' => '.Input',
                    'label' => __('Labels Color', 'woo-cc' ),
                    'default' => '',
                ],
                [
                    'id' => 'padding_top',
                    'type' => 'text',
                    'selector' => '.Input',
                    'label' => __('Input Field Padding Top', 'woo-cc' ),
                    'default' => '',
                ],
                [
                    'id' => 'padding_left',
                    'type' => 'text',
                    'selector' => '.Input',
                    'label' => __('Input Field Padding Left', 'woo-cc' ),
                    'default' => '',
                ],
                [
                    'id' => 'padding_bottom',
                    'type' => 'text',
                    'selector' => '.Input',
                    'label' => __('Input Field Padding Bottom', 'woo-cc' ),
                    'default' => '',
                ],
                [
                    'id' => 'padding_right',
                    'type' => 'text',
                    'selector' => '.Input',
                    'label' => __('Input Field Padding Right', 'woo-cc' ),
                    'default' => '',
                ],
            ],
        ],
        'labels' => [
            'label' => __('Labels', 'aof'),
            'fields' => [
                [
                    'id'      => 'label_position',
                    'type'    => 'select',
                    'label'   => __( 'Label Position', 'woo-cc' ),
                    'options' => [
                        'above' => __( 'Above', 'woo-cc' ),
                        'floating' => __( 'Floating', 'woo-cc' ),
                    ],
                ]
            ],
        ],
        ];
        return $sections;
    }

    public function get_option( $key, $default = null ) {
        $options = get_option( $this->option_name, [] );
        return $options[ $key ] ?? $default;
    }
}

// Initialize the settings class
new CC_Style_Options();
