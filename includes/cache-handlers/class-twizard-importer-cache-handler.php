<?php
/**
 * Base class for caching method. All caching methods must be extends from this class.
 * All methods are required for child classes
 *
 * @package   package_name
 * @author    Twizard Team
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Twizard_Importer_Cache_Handler' ) ) {

	/**
	 * Define Twizard_Importer_Cache_Handler class
	 */
	class Twizard_Importer_Cache_Handler {

		/**
		 * Store passed value in cache with passed key.
		 *
		 * @param  string $key   Caching key.
		 * @param  mixed  $value Value to save.
		 * @param  string $group Caching group.
		 * @return bool
		 */
		public function update( $key = null, $value = null, $group = 'global' ) {}
		/**
		 * Create base caching group if not exist.
		 */
		public function setup_cahe() {}

		/**
		 * Create new group in base caching group if not exists
		 */
		public function setup_cahe_group( $group = 'global' ) {}

		/**
		 * Returns all stored cache
		 *
		 * @return array
		 */
		public function get_all() {}

		/**
		 * Returns whole stored group
		 *
		 * @return array
		 */
		public function get_group( $group = 'global' ) {}

		/**
		 * Returns whole stored group
		 *
		 * @return void
		 */
		public function clear_cache( $group = null ) {}


		/**
		 * Returns current value by key
		 *
		 * @return array
		 */
		public function get( $key = null, $group = 'global' ) {}
	}

}
