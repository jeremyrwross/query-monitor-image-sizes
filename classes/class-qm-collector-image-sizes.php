<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Collector for gathering image size data.
 */
class QM_Collector_Image_Sizes extends QM_Collector {

	public $id = 'qm-image-sizes';

	/**
	 * Returns the name of the collector.
	 *
	 * Useful for identifying the collector in the Query Monitor interface.
	 *
	 * @return string The collector name.
	 */
	public function name() {
		return esc_html__( 'Image Sizes', 'query-monitor' );
	}

	/**
	 * Processes and collects data about registered image sizes.
	 *
	 * Gathers data on both default and additional image sizes registered in WordPress.
	 *
	 * @return void
	 */
	public function process() {

		$image_sizes = wp_get_registered_image_subsizes();

		// Adding custom image sizes.
		global $_wp_additional_image_sizes;
		if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) ) {
			$image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
		}

		foreach ( $image_sizes as $size => &$details ) {
			if ( is_bool( $details['crop'] ) ) {
				$details['crop'] = $details['crop'] ? 'Yes' : '';
			} elseif ( is_array( $details['crop'] ) ) {
				$details['crop'] = implode( ', ', $details['crop'] );
			}
		}

		$this->data['sizes'] = $image_sizes;
	}
}
