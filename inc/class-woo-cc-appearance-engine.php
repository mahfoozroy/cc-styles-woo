<?php

class Woo_CC_Appearance_Engine {
	/**
	 * @var array Default appearance options
	 */
	protected $appearance = [];

	/**
	 * Constructor to set initial appearance styles.
	 *
	 * @param array $style_options Your global options array.
	 */
	public function __construct( $fields, $style_options = [] ) {
		$this->appearance = $this->build_appearance_from_fields( $fields, $style_options );
	}

	/**
	 * Returns the structured appearance array for Stripe Elements.
	 *
	 * @return array
	 */
	public function get_appearance() {
		return [
			'theme'     => $this->appearance['theme'] ?? 'stripe',
            'labels'     => $this->appearance['labels'] ?? 'above',
			'variables' => $this->appearance['variables'] ?? [],
			'rules'     => $this->appearance['rules'] ?? [],
		];
	}

	/**
	 * Sanitize/validate the appearance options before use.
	 *
	 * @param array $options
	 * @return array
	 */
	protected function sanitize_appearance_options( array $options ) {
		$valid_keys = [ 'theme', 'variables', 'rules', 'labels' ];

		// Only keep known appearance keys
		return array_filter(
			$options,
			fn( $key ) => in_array( $key, $valid_keys, true ),
			ARRAY_FILTER_USE_KEY
		);
	}

    /**
	 * Converts the settings and their selector types into Stripe appearance structure.
	 *
	 * @param array $field_definitions Fields from AOF
	 * @param array $option_data Values stored in wp_options
	 * @return array
	 */
	protected function build_appearance_from_fields( $field_definitions, $option_data )  {
		$appearance = [
			'variables' => [],
			'rules'     => [],
		];

		foreach ( $field_definitions as $section ) {
			foreach ( $section['fields'] as $field ) {
				$id       = $field['id'] ?? '';
				$selector = $field['selector'] ?? '';
                $default_value = $field['default'] ?? '';
				$value    = $option_data[ $id ] ?? $default_value;
                $property = $field['css_property'] ? $field['css_property'] : $field['id'];

                if ( isset( $field['validate'] ) ) {
                    $value = $this->validate_value( $value, $field['validate'] );
                }
                if ( is_array( $value ) ) {
                    $value = $this->map_spacing( $value, $field['type'] );
                }   

				if ( empty( $selector ) || $value === null || empty( $value ) ) {
					continue;
				}

				if ( $selector === 'theme' ) {
					$appearance['theme'] = $value;
				} elseif ( $selector === 'labels' ) {
					$appearance['labels'] = $value;
				} elseif ( $selector === 'variables' ) {
					$appearance['variables'][ $property ] = $value;
				} elseif ( is_array( $selector ) || str_starts_with( $selector, '.' ) ) {
                    if ( is_array( $selector ) ) {
                        foreach( $selector as $class ) {
                            if ( ! isset( $appearance['rules'][ $class ] ) ) {
                                $appearance['rules'][ $class ] = [];
                            } 
                            if ( str_starts_with( $class, '.' ) ) {
                                if ( is_array( $property ) && is_array( $value )  ) {
                                    foreach( $property as $prop ) {
                                        $appearance['rules'][ $class ][ $prop ] = isset( $value[ $prop ] ) ?? '';
                                    }

                                } else {
                                    $appearance['rules'][ $class ][ $property ] = $value;
                                }
                            }
                        }
 
                    } else {
                        if ( ! isset( $appearance['rules'][ $selector ] ) ) {
                            $appearance['rules'][ $selector ] = [];
                        } 
                        if ( is_array( $property ) && is_array( $value )  ) {
                            foreach( $property as $prop ) {
                                $appearance['rules'][ $selector ][ $prop ] = $value[ $prop ] ?? '';
                            }

                        } else {
                            $appearance['rules'][ $selector ][ $property ] = $value;
                        }
                    }
				}
			}
		}

		return $appearance;
	}

    /**
     * Sanitize or validate values according to validate type.
     *
     * @param string|int|float $value The value to sanitize.
     *
     */
    protected function validate_value( $value, $validate ) {
       if ( empty( $value ) || null === $value ) {
            return '';
       }
       if ( 'spacing' === $validate ) {
            if ( is_array( $value ) ) {
                foreach( $value as $key => $side ) {
                    $value[ $key ] = AOF_Helper::sanitize_unit_value( $side );
                }
            } else {
                $value = AOF_Helper::sanitize_unit_value( $value );
            }
       } 
       return $value;
    }

     /**
     * Sanitize or validate values according to validate type.
     *
     * @param string|int|float $value The value to sanitize.
     *
     */
    protected function map_spacing( $value, $type = '' ) {
        if ( ! is_array( $value ) ) {
             return '';
        }
        $result = [];
        foreach ( $value as $edge => $value ) {
            $key = $type . ucfirst($edge);
            $result[ $key ] = $value;
        }
        return $result;
    }
}
