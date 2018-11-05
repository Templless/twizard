<?php
/**
 * Starter import template
 */
?>
<div>
	<div class="twiz-success-mesage"><?php
		_e( 'Now you can visit your website, start customization… or install another skin ;)', 'twizard-importer' );
	?></div>
	<div class="twiz-success-links"><?php

		$buttons  = twiz()->get_setting( array( 'success-links' ) );
		$format   = '<a href="%4$s" class="twiz-btn %2$s" target="%3$s">%1$s</a>';
		$defaults = array(
			'label'  => __( 'View your site', 'twizard-importer' ),
			'type'   => 'primary',
			'target' => '_self',
			'url'    => home_url( '/' ),
		);

		if ( ! empty( $buttons ) ) {
			foreach ( $buttons as $button ) {
				$button = wp_parse_args( $button, $defaults );
				printf( $format, $button['label'], $button['type'], $button['target'], $button['url'] );
			}
		}

	?></div>
</div>