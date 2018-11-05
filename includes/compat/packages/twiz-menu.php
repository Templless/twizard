<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Twizard_Importer_Twiz_Menu_Compat' ) ) {

	/**
	 * Define Twizard_Importer_Twiz_Menu_Compat class
	 */
	class Twizard_Importer_Twiz_Menu_Compat {

		public $node = 'twiz_menu_settings';

		/**
		 * Constructor for the class
		 */
		public function __construct() {
			// Export
			add_action( 'twizard-importer/export/custom-data', array( $this, 'add_menu_meta_on_export' ) );

			// Import
			add_filter( 'twizard-importer/increment-import-node', array( $this, 'increment_import_node' ), 10, 2 );
			add_action( 'twizard-importer/import-node/wp:' . $this->node, array( $this, 'process_import_node' ) );
			add_action( 'twizard_data_import_remap_terms', array( $this, 'add_menu_meta_on_import' ) );
		}

		public function increment_import_node( $count = 1, $node = null ) {

			if ( $node === $this->node ) {
				$count++;
			}

			return $count;
		}

		public function process_import_node( $importer ) {

			$node          = $importer->reader->expand();
			$menu_settings = $node->textContent;

			if ( $menu_settings ) {
				set_transient( $this->node, $menu_settings, DAY_IN_SECONDS );
			}

		}

		public function add_menu_meta_on_import( $terms = array() ) {
			$menu_settings = get_transient( $this->node );
			$menu_settings = json_decode( $menu_settings, true );

			if ( $menu_settings ) {
				foreach ( $menu_settings as $old_id => $settings ) {

					if ( isset( $terms[ $old_id ] ) ) {
						twiz_menu_settings_nav()->update_settings( $terms[ $old_id ], $settings );
					}

				}
			}

		}

		/**
		 * Add menu meta on export
		 */
		public function add_menu_meta_on_export() {

			$locations = get_nav_menu_locations();

			if ( empty( $locations ) ) {
				return;
			}

			$result = array();

			foreach ( $locations as $location => $menu_id ) {
				$settings = twiz_menu_settings_nav()->get_settings( $menu_id );

				if ( ! empty( $settings ) ) {
					$result[ $menu_id ] = $settings;
				}

			}

			printf(
				"\t<wp:%1\$s>%2\$s</wp:%1\$s>\r\n",
				$this->node,
				wxr_cdata( json_encode( $result ) )
			);

		}

	}

}

new Twizard_Importer_Twiz_Menu_Compat();
