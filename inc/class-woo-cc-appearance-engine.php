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
            'theme'     => 'stripe',
            'labels'     => 'above',
			'variables' => [],
			'rules'     => [],
		];

		foreach ( $field_definitions as $section ) {
			foreach ( $section['fields'] as $field ) {
				$id       = $field['id'];
				$selector = $field['selector'] ?? '';
                $default_value = $field['default'] ?? '';
				$value    = $option_data[ $id ] ?? $default_value;
                
                if ( isset( $field['validate'] ) ) {
                    $value = $this->validate_value( $value, $field['validate'] );
                }

				if ( empty( $selector ) || $value === null || $value === '' ) {
					continue;
				}

				if ( $selector === 'theme' ) {
					$appearance['theme'] = $value;
				} elseif ( $selector === 'labels' ) {
					$appearance['labels'] = $value;
				} elseif ( $selector === 'variables' ) {
					$appearance['variables'][ $id ] = $value;
				} elseif ( str_starts_with( $selector, '.' )) {
					if ( ! isset( $appearance['rules'][ $selector ] ) ) {
						$appearance['rules'][ $selector ] = [];
					}
					$appearance['rules'][ $selector ][ $id ] = $value;
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
       if ( '' === $value || null === $value ) {
            return '';
       }
       if ( 'spacing' === $validate ) {
            $value = AOF_Helper::sanitize_unit_value( $value );
       } 
       return $value;
    }
}
