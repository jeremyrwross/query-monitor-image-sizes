<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class QM_Output_Html_Image_Sizes extends QM_Output_Html {

	/**
	 * Constructor for the QM_Output_Html_Image_Sizes class.
	 *
	 * Sets up the output area for image sizes in the Query Monitor plugin interface.
	 *
	 * @param QM_Collector $collector The collector instance for gathering image size data.
	 */
	public function __construct( QM_Collector $collector ) {
		parent::__construct( $collector );

		add_filter( 'qm/output/menus', array( $this, 'menu' ), 101 );
	}

	/**
	 * Outputs the HTML content for the image sizes panel in Query Monitor.
	 *
	 * Generates a table listing all registered image sizes along with their dimensions and crop settings.
	 *
	 * @return void
	 */
	public function output() {
		$sizes = $this->collector->get_data( 'sizes' );

		echo '<div id="' . esc_attr( $this->collector->id ) . '" class="qm">';
		echo '<table cellspacing="0">';
		echo '<thead>';
		echo '<tr>';
		echo '<th>' . esc_html__( 'Size Name', 'query-monitor' ) . '</th>';
		echo '<th>' . esc_html__( 'Width', 'query-monitor' ) . '</th>';
		echo '<th>' . esc_html__( 'Height', 'query-monitor' ) . '</th>';
		echo '<th>' . esc_html__( 'Crop', 'query-monitor' ) . '</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';

		foreach ( $sizes['sizes'] as $size => $info ) {
			echo '<tr>';
			echo '<td>' . esc_html( $size ) . '</td>';
			echo '<td>' . esc_html( $info['width'] ) . '</td>';
			echo '<td>' . esc_html( $info['height'] ) . '</td>';
			echo '<td>' . esc_html( $info['crop'] ) . '</td>';
			echo '</tr>';
		}

		echo '</tbody>';
		echo '</table>';
		echo '</div>';
	}

	/**
	 * Adds the "Image Sizes" tab to the Query Monitor admin menu.
	 *
	 * @param array $menu The current array of Query Monitor menu items.
	 * @return array The modified menu array, now including the "Image Sizes" tab.
	 */
	public function menu( array $menu ) {
		$menu[] = array(
			'id'    => 'qm-image-sizes',
			'href'  => '#qm-image-sizes',
			'title' => esc_html__( 'Image Sizes', 'query-monitor' ),
		);

		return $menu;
	}
}
