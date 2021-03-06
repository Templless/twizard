<?php
/**
 * Compatibility manager
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Twizard_Importer_Compat' ) ) {

	/**
	 * Define Twizard_Importer_Compat class
	 */
	class Twizard_Importer_Compat {

		/**
		 * Constructor for the class
		 */
		function __construct() {
			$this->load_compat_packages();
		}

		/**
		 * Load compatibility packages
		 *
		 * @return void
		 */
		public function load_compat_packages() {

			$whitelist = array(
				'twiz-menu.php' => array(
					'cb'   => 'class_exists',
					'args' => 'Twiz_Menu',
				),
			);

			foreach ( $whitelist as $file => $condition ) {
				if ( true === call_user_func( $condition['cb'], $condition['args'] ) ) {
					require twiz()->path( 'includes/compat/packages/' . $file );
				}
			}

		}

	}

}
