<?php
/**
 * Remove content form template
 */
?>
<div class="twiz-remove-form">
	<div class="twiz-remove-form__message">
		<?php
			esc_html_e( 'Please, enter your WordPress user password to confirm and start content replacing.', 'twizard-importer' );
		?>
		<span class="twiz-remove-form__note"><?php
			esc_html_e( 'NOTE: All your content will be replaced (posts, pages, comments, attachments and terms)', 'twizard-importer' );
		?></span>
	</div>
	<div class="twiz-remove-form__controls">
		<input type="password" class="twiz-remove-form__input" placeholder="<?php esc_html_e( 'Please, enter your password', 'twizard-importer' ); ?>">
		<button class="twiz-btn primary" data-action="remove-content"><span class="text"><?php
				esc_html_e( 'Import Content', 'twizard-importer' );
			?></span><span class="twiz-loader-wrapper-alt"><span class="twiz-loader-alt"></span></span></button>
	</div>
	<div class="twiz-remove-form__notices twiz-hide">
	</div>
</div>