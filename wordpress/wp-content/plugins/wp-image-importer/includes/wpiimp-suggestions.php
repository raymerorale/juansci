<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="<?php echo WPIIMP_PREFIX;?>suggestions-wrap">
	<h4>
		<?php _e( 'Please help us to serve you better. How can we improve this plugin, any suggestions or ideas would be greatly appreciated.', 'wp-image-importer' ); ?>
	</h4>
	<form id="<?php echo WPIIMP_PREFIX;?>suggestions-form" action="" method="post">
		<div class="<?php echo WPIIMP_PREFIX;?>suggestions-inner form-table">
			<div class="<?php echo WPIIMP_PREFIX;?>suggestions-title  <?php echo WPIIMP_PREFIX;?>suggestions">
				<label for="<?php echo WPIIMP_PREFIX;?>suggestions_title">
					<?php _e( 'Suggestions title', 'wp-image-importer' );?>
				</label>
				<input type="text" id="<?php echo WPIIMP_PREFIX;?>suggestions_title" name="<?php echo WPIIMP_PREFIX;?>suggestions_title" value="" placeholder="<?php _e( "Enter the suggestion title you're writing about", 'wp-image-importer' );?>">
			</div>
			<div class="<?php echo WPIIMP_PREFIX;?>suggestions-desc <?php echo WPIIMP_PREFIX;?>suggestions">
				<label for="<?php echo WPIIMP_PREFIX;?>suggestions_description">
					<?php _e( 'Suggestions description', 'wp-image-importer' );?>
				</label>
				<?php  
				$content = '';
				$editor_id = WPIIMP_PREFIX . 'suggestions_description';
				$settings = array(
					'textarea_rows' => '5',
					'editor_class' 	=> WPIIMP_PREFIX.'suggestions_description',
					'textarea_name' => WPIIMP_PREFIX.'suggestions_description',
					'editor_height' => "40px",
					'wpautop' 		=> false,
					'media_buttons' => false
				);
				wp_editor( $content, $editor_id, $settings ); 
				?>
			</div>
			<div class="<?php echo WPIIMP_PREFIX;?>suggestions">
				<label for="">&nbsp;</label>
				<button name="<?php echo WPIIMP_PREFIX;?>suggestions" id="<?php echo WPIIMP_PREFIX;?>suggestions" class="button button-primary" type="submit">
					<?php _e( 'Submit', 'wp-image-importer' ); ?>
				</button>
			</div>
		</div>
	</form>
</div>