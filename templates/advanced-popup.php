<?php
/**
 * Template part for displaying advanced popup
 */
?>
<div class="twiz-advanced-popup popup-hidden">
	<div class="twiz-advanced-popup__content">
		<h3><?php esc_html_e( 'Attention!', 'twizard-importer' ); ?></h3>
		<?php esc_html_e( 'We are ready to install demo data. Do you want to append demo content to your existing content or completely rewrite it?', 'twizard-importer' ); ?>
		<div class="twiz-advanced-popup__select">
			<label class="twiz-advanced-popup__item">
				<input type="radio" name="install-type" value="append" checked>
				<span class="twiz-advanced-popup__item-mask"></span>
				<span class="twiz-advanced-popup__item-label"><?php
					esc_html_e( 'Append demo content to my existing content', 'twizard-importer' );
				?></span>
			</label>
			<label class="twiz-advanced-popup__item">
				<input type="radio" name="install-type" value="replace">
				<span class="twiz-advanced-popup__item-mask"></span>
				<span class="twiz-advanced-popup__item-label"><?php
					esc_html_e( 'Replace my existing content with demo content', 'twizard-importer' );
				?></span>

			</label>
		</div>
		<div class="twiz-advanced-popup__warning twiz-hide">
			<b><?php esc_html_e( 'NOTE:', 'twizard-importer' ); ?></b>
			<?php esc_html_e( 'This option will remove all your existing content - posts, pages, attachments, terms and comments', 'twizard-importer' ); ?>
		</div>
		<div class="twiz-advanced-popup__action">
			<button class="twiz-btn primary" data-action="confirm-install"><span class="text"><?php
				esc_html_e( 'Start Install', 'twizard-importer' );
			?></span><span class="twiz-loader-wrapper-alt"><span class="twiz-loader-alt"></span></span></button>
		</div>
		<button class="twiz-advanced-popup__close"><span class="dashicons dashicons-no"></span></button>
	</div>
</div>