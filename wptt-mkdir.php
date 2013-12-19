<?php
/*
Plugin Name: WPTT mkdir
Plugin URI: http://wpthemetutorial.com
Description: Demo to make a directory on plugin activation
Version: 1.0
Author: WPTT, Curtis McHale
Author URI: http://wpthemetutorial.com
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

class WPTT_Mkdir{

	function __construct(){

		add_action( 'admin_notices', array( $this, 'check_required_plugins' ) );

		// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
		register_uninstall_hook( __FILE__, array( __CLASS__, 'uninstall' ) );

	} // construct

	/**
	 * Checks for WooCommerce and GF and kills our plugin if they aren't both active
	 *
	 * @uses    function_exists     Checks for the function given string
	 * @uses    deactivate_plugins  Deactivates plugins given string or array of plugins
	 *
	 * @action  admin_notices       Provides WordPress admin notices
	 *
	 * @since   1.0
	 * @author  SFNdesign, Curtis McHale
	 */
	public function check_required_plugins(){

		if( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ){ ?>

			<div id="message" class="error">
				<p>WPTT mkdir expects WooCommerce to be active. This plugin has been deactivated.</p>
			</div>

			<?php
			deactivate_plugins( '/wptt-mkdir/wptt-mkdir.php' );
		} // compmany team if

	} // check_required_plugins

	/**
	 * Returns true if the custom directory is in the uploads folder
	 *
	 * @since 1.0
	 * @author SFNdesign, Curtis Mchale
	 * @access private
	 */
	private function check_custom_dir(){

		$url = WP_CONTENT_DIR . '/uploads/wpttcustom';

		if ( file_exists( $url ) ){
			return true;
		}

		return false;

	} // check_custom_dir

	/**
	 * Creates our custom upload directory
	 *
	 * @since 1.0
	 * @author SFNdesign, Curtis McHale
	 * @access private
	 *
	 * @uses $this->check_custom_dir()          Returns true if the dir already exists
	 * @uses wp_mkdir_p()                       Creates dirpath recursively and sets file permissions if possible
	 */
	public function create_custom_dir(){

		if ( $this->check_custom_dir() === true ) return;

		$url = WP_CONTENT_DIR . '/uploads/wpttcustom';

		wp_mkdir_p( $url );

	} // create_custom_dir

	/**
	 * Fired when plugin is activated
	 *
	 * @param   bool    $network_wide   TRUE if WPMU 'super admin' uses Network Activate option
	 */
	public function activate( $network_wide ){

		$this->create_custom_dir();

	} // activate

	/**
	 * Fired when plugin is deactivated
	 *
	 * @param   bool    $network_wide   TRUE if WPMU 'super admin' uses Network Activate option
	 */
	public function deactivate( $network_wide ){

	} // deactivate

	/**
	 * Fired when plugin is uninstalled
	 *
	 * @param   bool    $network_wide   TRUE if WPMU 'super admin' uses Network Activate option
	 */
	public function uninstall( $network_wide ){

	} // uninstall

} // WPTT_Mkdir

new WPTT_Mkdir();
