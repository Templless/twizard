<?php
/**
 * Starter import template
 */
?>
<div>
	<?php
		/**
		 * Hook before importer messages output.
		 *
		 * @hooked Twizard_Importer_Interface::check_server_params - 10;
		 */
		do_action( 'twizard_importer_before_messages' );
	?>
	<?php echo twiz_interface()->get_welcome_message(); ?>
	<?php if ( twiz_interface()->is_advanced_import() ) : ?>
		<?php twiz_interface()->advanced_import(); ?>
	<?php else : ?>
	<div class="twiz-actions">
		<?php echo twiz_interface()->get_import_files_select( '<div class="twiz-file-select">', '</div>' ); ?>
		<?php if ( 1 <= twiz_interface()->get_xml_count() && twiz()->get_setting( array( 'xml', 'use_upload' ) ) ) {
			echo '<span class="twiz-delimiter">' . __( 'or', 'twizard-importer' ) . '</span>';
		} ?>
		<?php echo twiz_interface()->get_import_file_input( '<div class="twiz-file-upload">', '</div>' ); ?>
	</div>
	<input type="hidden" name="referrer" value="<?php echo twiz_tools()->get_page_url(); ?>">
	<button id="twizard-import-start" class="twiz-btn primary">
		<span class="dashicons dashicons-arrow-down-alt2"></span>
		<?php esc_html_e( 'Start import', 'twizard-importer' ); ?>
	</button>
	<?php endif; ?>
</div>
