<?php
/**
 * Main class
 *
 * @package Kilroy_Was_Here
 */

/**
 * Class definition
 */
class Kilroy_Was_Here {
	/**
	 * Register settings group
	 *
	 * @const SETTINGS
	 */
	const SETTINGS = 'kilroywashere-settings-group';

	/**
	 * Disallow direct access
	 */
	private function __construct() {}

	/**
	 * Create instance
	 *
	 * @return object
	 */
	public static function init() {
		$instance = new self();

		$instance->load_textdomain();

		add_action( 'admin_init', array( $instance, 'register_settings' ) );
		add_action( 'admin_menu', array( $instance, 'admin_menu' ) );

		if ( $instance->in_head() ) {
			add_action( 'wp_head', array( $instance, 'html_comment' ), $instance::priority() );
		} else {
			add_action( 'wp_footer', array( $instance, 'show' ), $instance::priority() );
		}

		add_filter( 'plugin_action_links_' . KILROYWASHERE_BASENAME, array( $instance, 'action_link' ) );

		return $instance;
	}

	/**
	 * Load translations
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'kilroy-was-here', false, KILROYWASHERE_DIR_PATH_BASENAME . '/languages/' );
	}

	/**
	 * Add settings
	 */
	public function register_settings() {
		register_setting( self::SETTINGS, 'kilroywashere-in_head' );
		register_setting( self::SETTINGS, 'kilroywashere-html_comment' );
		register_setting( self::SETTINGS, 'kilroywashere-content' );
		register_setting( self::SETTINGS, 'kilroywashere-priority' );
	}

	/**
	 * Add administration menu
	 */
	public function admin_menu() {
		add_options_page(
			__( 'Kilroy was here', 'kilroy-was-here' ),
			__( 'Kilroy was here', 'kilroy-was-here' ),
			'manage_options',
			KILROYWASHERE_DIR_PATH_BASENAME,
			array( $this, 'options' )
		);
	}

	/**
	 * Options form
	 */
	public function options() {
		$content      = self::content();
		$priority     = self::priority();
		$in_head      = get_option( 'kilroywashere-in_head' );
		$html_comment = $in_head || get_option( 'kilroywashere-html_comment' );
		?>
		<div class="wrap">
			<h2><?php echo esc_html( __( 'Kilroy was here', 'kilroy-was-here' ) ); ?></h2>
			<form action="options.php" method="post">
				<?php settings_fields( self::SETTINGS ); ?>
				<table class="form-table">
					<tr>
						<th><label for="kilroywashere-content"><?php echo esc_html( __( 'Text', 'kilroy-was-here' ) ); ?></label></th>
						<td><textarea name="kilroywashere-content" id="kilroywashere-content" class="code" cols="50" rows="10"><?php echo esc_textarea( $content ); ?></textarea></td>
					</tr>
					<tr>
						<th><label for="kilroywashere-priority"><?php echo esc_html( __( 'Priority', 'kilroy-was-here' ) ); ?></label></th>
						<td>
							<input type="number" name="kilroywashere-priority" id="kilroywashere-priority" aria-describedby="kilroywashere-priority-description" min="1" value="<?php echo absint( $priority ); ?>" />
							<p class="description" id="kilroywashere-priority-description"><?php echo esc_html( __( 'A lower value means a higher priority. The default priority in WordPress is 10.', 'kilroy-was-here' ) ); ?></p>
						</td>
					</tr>
					<tr>
						<th><label for="kilroywashere-in_head"><?php echo esc_html( __( 'Display in HTML &lt;head&gt;', 'kilroy-was-here' ) ); ?></label></th>
						<td><input type="checkbox" name="kilroywashere-in_head" id="kilroywashere-in_head" value="1" <?php checked( 1, $in_head ); ?>/></td>
					</tr>
					<tr>
						<th><label for="kilroywashere-html_comment"><?php echo esc_html( __( 'Display as HTML comment', 'kilroy-was-here' ) ); ?></label></th>
						<td><input type="checkbox" name="kilroywashere-html_comment" id="kilroywashere-html_comment" value="1" <?php checked( 1, $html_comment ); ?>/></td>
					</tr>
				</table>
				<p class="submit">
					<input name="submit" id="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Changes' ); ?>" type="submit" />
				</p>
			</form>
		</div>
		<?php
	}

	/**
	 * Add plugins settings link
	 *
	 * @param array $links Action links.
	 * @return array
	 */
	public function action_link( $links ) {
		return array_merge(
			array( '<a href="options-general.php?page=' . esc_attr( KILROYWASHERE_DIR_PATH_BASENAME ) . '">' . esc_html( __( 'Settings' ) ) . '</a>' ),
			$links
		);
	}

	/**
	 * Get content
	 *
	 * @return string
	 */
	public static function content() {
		return (string) get_option( 'kilroywashere-content' );
	}

	/**
	 * Show content
	 */
	public static function show() {
		if ( get_option( 'kilroywashere-html_comment' ) ) {
			self::html_comment();
		} else {
			$content = self::content();
			if ( strlen( $content ) ) {
				echo '<pre id="kilroywashere">' . esc_html( $content ) . '</pre>';
			}
		}
	}

	/**
	 * Display as HTML comment. Replaces pointy brackets, just to be safe.
	 */
	public static function html_comment() {
		$content = self::content();
		if ( strlen( $content ) ) {
			/* phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped */
			echo "\n<!--\n" . str_replace( array( '>', '<' ), array( '›', '‹' ), $content ) . "\n-->\n\n";
			/* phpcs:enable WordPress.Security.EscapeOutput.OutputNotEscaped */
		}
	}

	/**
	 * Get priority
	 *
	 * @return integer
	 */
	public static function priority() {
		if ( defined( 'KILROYWASHERE_PRIORITY' ) ) {
			return absint( KILROYWASHERE_PRIORITY );
		}

		$option = get_option( 'kilroywashere-priority' );
		if ( is_int( $option ) || ctype_digit( $option ) ) {
			return absint( $option );
		}

		return 99;
	}

	/**
	 * Run on activation
	 */
	public static function install() {
		// Add Kilroy.
		add_option( 'kilroywashere-content', "`     ,,,\n     (o o)\n--ooO-(_)-Ooo---" );
	}

	/**
	 * Setting if content should be displayed in HTML head
	 *
	 * @return boolean
	 */
	protected function in_head() {
		return (bool) get_option( 'kilroywashere-in_head' );
	}
}
