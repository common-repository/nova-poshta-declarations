<div class="npen_wrapper" data-ajax="<?php echo admin_url( 'admin-ajax.php' ); ?>">
	<div class="npen_row">
		<h1><?php esc_html_e( 'Настройки: Новая почта Электронные накладные', 'novaposhta' ); ?></h1>
		<form action="" method="post">

			<div class="npen_senderInfoTable npen_col npen_col-2">
				<p>
					<label for=""><?php esc_html_e( 'Название поля накладной', 'novaposhta' ); ?><span class="red">*</span>
					</label>
					<input type="text" style="width: 30%;" value="<?php echo get_option( 'npen_label_text' ); ?>"
					       placeholder="<?php esc_html_e( 'Название поля накладной', 'novaposhta' ); ?>" name="npen_label_text">
				</p>

				<p>
					<input type="submit" name="npen_settings_save"
					       value="<?php esc_html_e( 'Сохранить', 'novaposhta' ); ?>">
				</p>
				<?php wp_nonce_field( 'NPEN_settings_nonce', 'NPEN_settings_nonce' ); ?>
			</div>
		</form>

	</div>


</div>
