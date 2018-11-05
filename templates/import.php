<?php
/**
 * Main import template
 */
?>
<div class="twiz-content">
	<?php twiz_slider()->slider_assets(); ?>
	<?php twiz_interface()->remove_content_form(); ?>
	<?php
		if ( isset( $_GET['type'] ) && 'append' === $_GET['type'] ) {
			twiz_slider()->render();
		}
	?>
	<div id="twizard-import-progress" class="twiz-progress">
		<span class="twiz-progress__bar">
			<span class="twiz-progress__label"><span></span></span>
		</span>
		<span class="twiz-progress__sub-label"></span>
	</div>
	<table class="twiz-install-summary">
		<thead>
			<tr>
				<th><?php esc_html_e( 'Import Summary', 'twizard-importer' ); ?></th>
				<th class="completed-cell"><?php esc_html_e( 'Completed', 'twizard-importer' ); ?></th>
				<th colspan="3"><?php esc_html_e( 'Progress', 'twizard-importer' ); ?></th>
			</tr>
		</theead>
		<tbody>
		<?php

			$summary = twiz_cache()->get( 'import_summary' );
			$labels  = array(
				'posts'    => esc_html__( 'Posts', 'twizard-importer' ),
				'authors'  => esc_html__( 'Authors', 'twizard-importer' ),
				'comments' => esc_html__( 'Comments', 'twizard-importer' ),
				'media'    => esc_html__( 'Media', 'twizard-importer' ),
				'terms'    => esc_html__( 'Terms', 'twizard-importer' ),
				'tables'   => esc_html__( 'Tables', 'twizard-importer' ),
			);

			foreach ( $summary as $type => $total ) {

				if ( 0 === $total ) {
					continue;
				}

				?>
				<tr data-item="<?php echo $type; ?>" data-total="<?php echo $total; ?>">
					<td><?php echo $labels[ $type ]; ?></td>
					<td class="completed-cell">
						<span class="twiz-install-summary__done">0</span>
						/
						<span class="twiz-install-summary__total"><?php echo $total; ?></span>
					</td>
					<td class="twiz-complete-val">
						<span class="twiz-install-summary__percent">0</span>%
					</td>
					<td class="twiz-complete-progress">
						<div class="twiz-progress progress-tiny"><span class="twiz-progress__bar"><span></span></span></div>
					</td>
					<td class="twiz-complete-status">
						<div class="twiz-progress-status"></div>
					</td>
				</tr>
				<?php

			}

		?>
		</tbody>
	</table>
</div>