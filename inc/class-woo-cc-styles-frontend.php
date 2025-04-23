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
		$this->style_fields = CC_Style_Options::get_fields();
		$this->style_engine = new Woo_CC_Appearance_Engine( $this->style_fields, $this->style_options );
		// echo '<pre>';
		// print_r( $this->style_engine->get_appearance() );
		// echo '</pre>';
		//$this->init_hooks();
	}

	protected function init_hooks() {
		// WooCommerce Payments
		add_filter('wcpay_elements_appearance', [ $this, 'filter_stripe_appearance'] );

		// WooCommerce Stripe Gateway
		add_filter('wc_stripe_elements_appearance', [ $this, 'filter_stripe_appearance'] );
	}

	/**
	 * Inject appearance styles to Stripe elements via filters.
	 *
	 * @param array $appearance Existing appearance array.
	 * @return array Merged appearance with our custom styles.
	 */
	public function filter_stripe_appearance( $appearance ) {
		$custom = $this->style_engine->get_appearance();

		return array_merge_recursive( $appearance, $custom );
	}
}
new Woo_CC_Styles_Frontend();
