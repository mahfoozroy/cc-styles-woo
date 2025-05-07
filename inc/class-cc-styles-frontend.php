<?php
defined('ABSPATH') || exit;

class Woo_CC_Styles_Frontend {

	/**
	 * @var StripeAppearanceStyleManager
	 */
	protected $style_engine;

	/* @var style options
	*/
    protected $style_options;

	/* @var style params
	*/
    protected $style_fields;

	public function __construct() {
		$this->style_options = get_option( 'woo_cc_styles', [] );
		$this->style_fields  = CC_Styles_Options::get_fields();
		$this->style_engine  = new CC_Styles_Appearance_Engine( $this->style_fields, $this->style_options );
		
		$this->init_hooks();
	}

	protected function init_hooks() {
		
		// WooCommerce Payments.
		add_filter( 'wcpay_elements_appearance', [ $this, 'filter_stripe_appearance'], 99 );

		// WooCommerce Stripe Gateway
		add_filter('wc_stripe_elements_appearance', [ $this, 'filter_stripe_appearance'] );
	}

	/**
	 * Inject custom Stripe appearance settings into the appearance object.
	 *
	 * @param stdClass $appearance Existing Stripe appearance object passed by Woo plugins.
	 * @return stdClass Modified appearance object.
	 */
	public function filter_stripe_appearance( $appearance ) {
		if ( ! is_object( $appearance ) ) {
			$appearance = new stdClass();
		}
		$custom = $this->style_engine->get_appearance();

		// Set theme if available.
		if ( ! empty( $custom['theme'] ) ) {
			$appearance->theme = $custom['theme'];
		}
		if ( ! empty( $custom['labels'] ) ) {
			$appearance->labels = $custom['labels'];
		}

		// Set variables if available.
		if ( ! empty( $custom['variables'] ) ) {
			if ( ! isset( $appearance->variables ) ) {
				$appearance->variables = new stdClass();
			}

			foreach ( $custom['variables'] as $key => $value ) {
				$appearance->variables->{$key} = $value;
			}
		}

		// Set rules if available.
		if ( ! empty( $custom['rules'] ) ) {
			if ( ! isset( $appearance->rules ) ) {
				$appearance->rules = new stdClass();
			}

			foreach ( $custom['rules'] as $selector => $styles ) {
				if ( ! isset( $appearance->rules->{$selector} ) ) {
					$appearance->rules->{$selector} = new stdClass();
				}

				foreach ( $styles as $property => $val ) {
					$appearance->rules->{$selector}->{$property} = $val;
				}
			}
		}

		return $appearance;
	}
}
new Woo_CC_Styles_Frontend();
