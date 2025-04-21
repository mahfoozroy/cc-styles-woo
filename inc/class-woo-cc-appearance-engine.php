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
	public function __construct( $style_options = [] ) {
		$this->appearance = $this->sanitize_appearance_options( $style_options );
	}

	/**
	 * Returns the structured appearance array for Stripe Elements.
	 *
	 * @return array
	 */
	public function get_appearance() {
		return [
			'theme'     => $this->appearance['theme'] ?? 'stripe',
			'variables' => $this->appearance['variables'] ?? [],
			'rules'     => $this->appearance['rules'] ?? [],
		];
	}

	/**
	 * Set or override the appearance options.
	 *
	 * @param array $new_options
	 */
	public function set_appearance( array $new_options ) {
		$this->appearance = array_merge_recursive( $this->appearance, $this->sanitize_appearance_options( $new_options ) );
	}

	/**
	 * Sanitize/validate the appearance options before use.
	 *
	 * @param array $options
	 * @return array
	 */
	protected function sanitize_appearance_options( array $options ) {
		$valid_keys = [ 'theme', 'variables', 'rules' ];

		// Only keep known appearance keys
		return array_filter(
			$options,
			fn( $key ) => in_array( $key, $valid_keys, true ),
			ARRAY_FILTER_USE_KEY
		);
	}
}
