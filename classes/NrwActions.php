<?php

class NrwActions {

	public function __construct() {
		 add_action( 'post_submitbox_misc_actions' , array($this, 'nrw_set_to_private' ));
		 add_action( 'transition_post_status', array($this,'nrw_set_post_status_private'), 10, 3 );
	}

	public function nrw_set_to_private(){
		global $post;
		if ($post->post_type != 'nrw_accounts')
			return;
		$message = __('<strong>Note:</strong> Accounts are always <strong>private</strong>.');
		$post->post_password = '';
		$visibility = 'private';
		$visibility_trans = __('Private');
		?>
		<style type="text/css">
			.priv_pt_note {
				background-color: lightgreen;
				border: 1px solid green;
				border-radius: 2px;
				margin: 4px;
				padding: 4px;
			}
		</style>
		<script type="text/javascript">
            (function($){
                try {
                    $('#post-visibility-display').text('<?php echo $visibility_trans; ?>');
                    $('#hidden-post-visibility').val('<?php echo $visibility; ?>');
                } catch(err){}
            }) (jQuery);
		</script>
		<div class="priv_pt_note">
			<?php echo $message; ?>
		</div>
		<?php
	}

	public function nrw_set_post_status_private( $new_status, $old_status, $post ) {
		if ( $post->post_type == 'nrw_accounts' && $new_status == 'publish' && $old_status  != $new_status ) {
			$post->post_status = 'private';
			wp_update_post( $post );
		}
	}


}
$nrw_actions = new NrwActions();