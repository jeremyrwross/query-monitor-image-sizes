<?php
/**
 * Plugin Name: Query Monitor: Image Sizes
 * Description: A Query Monitor extension that adds a tab to show registered image sizes.
 * Version: 1.0
 * Plugin URI: https://github.com/jeremyrwross/qm-image-sizes
 * Author: Jeremy Ross
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Query Monitor Image Sizes Class
 *
 * This class extends the functionality of Query Monitor to include a tab showing registered image sizes.
 */
class QM_Image_Sizes {

	/**
	 * Constructor.
	 *
	 * Initializes the class by setting up the necessary hooks and loading the required components
	 * if Query Monitor is active.
	 */
	public function __construct() {

		if ( class_exists( 'QM_Collectors' ) ) {
			$this->register_collector();
			add_filter( 'qm/outputter/html', array( $this, 'register_output' ), 101, 1 );
		}
	}

	/**
	 * Registers the image sizes collector.
	 *
	 * Includes the collector class file and adds it to the Query Monitor collectors array.
	 *
	 * @return void
	 */
	private function register_collector() {
		require_once 'classes/class-qm-collector-image-sizes.php';
		QM_Collectors::add( new QM_Collector_Image_Sizes() );
	}

	/**
	 * Registers the output renderer for image sizes.
	 *
	 * Includes the output class file and, if the collector is available, adds it to the Query Monitor output array.
	 *
	 * @param array $output The existing array of Query Monitor outputs.
	 * @return array The modified array of Query Monitor outputs including the image sizes output.
	 */
	public function register_output( $output ) {

		require_once 'classes/class-qm-output-html-image-sizes.php';

		if ( $collector = QM_Collectors::get( 'qm-image-sizes' ) ) {

			$output['image-sizes'] = new QM_Output_Html_Image_Sizes( $collector );
		}

		return $output;
	}
}

// Initialize the plugin once all plugins have loaded.
add_action(
	'plugins_loaded',
	function () {
		new QM_Image_Sizes();
	}
);
