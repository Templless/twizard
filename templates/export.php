<?php wp_enqueue_script( 'twizard-export' ); ?>
<div class="twiz-wrap">
	<div class="twiz-message"><?php
		echo twiz()->get_setting( array( 'export', 'message' ) );
	?></div>
	<a href="<?php echo twiz_export_interface()->get_export_url(); ?>" class="twiz-btn primary" id="twizard-export">
		<span class="dashicons dashicons-arrow-up-alt2"></span>
		<?php _e( 'Export', 'twizard-importer' ); ?>
	</a>
	<div class="twiz-loader twiz-hidden"></div>
</div>