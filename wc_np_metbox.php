<?php
namespace NP;


class Wc_np_metabox {
	public function __construct() {
		add_action( 'save_post', array( $this, 'NPEN_meta_box_save' ), 10, 2 );
	}

	function NPEN_meta_box_add() {
		add_meta_box( 'novaposhta_declaration', 'Номер ЭН Новой почты', array( $this, 'NPEN_meta_box_cb' ),
			'shop_order', 'normal',
			'core' );

	}

	function NPEN_meta_box_cb( $post, $box ) {
		global $nppost;
		wp_nonce_field( "metatest_nonce", "metatest_nonce" );
		include_once( WC_NP_DIR . 'views/npen_template.php' );
	}


	function NPEN_meta_box_save( $postID, $post ) {
		if ( ! isset( $_POST['metatest_nonce'] )) {
			return;
		}
		// пришло ли поле наших данных?
		if ( ! isset( $_POST['metadata_field'] ) && ! empty( $_POST['metadata_field'] ) ) {
			return;
		}

		// не происходит ли автосохранение?
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// не ревизию ли сохраняем?
		if ( wp_is_post_revision( $postID ) ) {
			return;
		}
		// может ли юзер редактировать эту запись?
		if ( ! current_user_can( 'edit_post', $postID ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['metatest_nonce'], 'metatest_nonce' ) ) {
			return;
		}

		// коррекция данных
		$data = sanitize_text_field( $_POST['metadata_field'] );

		// запись
		update_post_meta( $postID, '_metatest_data', $data );

	}
}