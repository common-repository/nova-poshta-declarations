<div class="npen_wrapper" data-ajax="<?php echo admin_url( 'admin-ajax.php' ); ?>">
	<?php
	// получение существующих метаданных
	$data            = get_post_meta( $post->ID, '_metatest_data', true );
	$npen_label_text = get_option( 'npen_label_text' );

	$is_widget = true;
	?>
	<label for=""><span class="nptitle"><?php echo ( $npen_label_text ) ? $npen_label_text : esc_html( 'Номер ЭН', 'novaposhta' ); ?></span> <input type="text" class="np-user-input" name="metadata_field" value="<?php echo esc_attr( $data ); ?>" placeholder="<?php echo ( $npen_label_text ) ? $npen_label_text : esc_html( 'Номер ЭН', 'novaposhta' ); ?>" style="width: 60%;"></label>

	<?php if ( $is_widget ){ ?>

	<div class="track-wrap">
		<div id="np-tracking" class="np-w-br-0" style="">
			<div id="np-first-state">
				<div id="np-tracking-logo"></div>
				<div id="np-title">
					<div class="np-h1">ВІДСТЕЖЕННЯ<br>ПОСИЛОК</div>
				</div>
				<div id="np-input-container">
					<div id="np-clear-input"></div>
					<input id="np-user-input" type="text" value="<?php echo esc_attr( $data ); ?>" name="number" placeholder="Номер посилки"></div>
				<div id="np-warning-message"></div>
				<button id="np-submit-tracking" type="button"><span id="np-text-button-tracking">ВІДСТЕЖИТИ</span>
					<div id="np-load-image-tracking"></div>
				</button>
				<div id="np-error-status"></div>
			</div>
			<div id="np-second-state">
				<div id="np-status-icon"></div>
				<div id="np-status-message"></div>
				<div class="np-track-mini-logo">
					<div class="np-line-right"></div>
					<div class="np-line-left"></div>
				</div>
				<a href="#" id="np-more">Детальніше на сайті</a>
				<div id="np-return-button"><span>Інша посилка</span></div>
			</div>
		</div>

	</div>
</div>
<?php }?>
