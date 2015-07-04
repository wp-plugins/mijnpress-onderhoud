<?php
/*
Plugin Name: MijnPress onderhoud
Plugin URI: http://www.mijnpress.nl
Description: Plugin used for maintenance clients, prevents clients from breaking sites
Version: 0.0.2
Author: Ramon Fincken
Author URI: http://www.mijnpress.nl
*/
if (!defined('ABSPATH')) die("Aren't you supposed to come here via WP-Admin?");

if(!defined('DISALLOW_FILE_EDIT')) {
	define( 'DISALLOW_FILE_EDIT', true );
}

class mijnpress_onderhoud {
	
	static function init()
	{
		add_filter( 'user_has_cap', array('mijnpress_onderhoud','user_has_cap'), 10, 3 );
		add_filter( 'mijnpress_onderhoud_main_admins', array('mijnpress_onderhoud','get_main_admins'));
		define('MP_SUPPRESS_MP_NOTICES', true);
	}

	static function get_main_admins($aAdmins = array())
	{
		if(!defined('MP_MIJNPRESS_ONDERHOUD') || MP_MIJNPRESS_ONDERHOUD === 0) {
			return $aAdmins;
		}
		return array(MP_MIJNPRESS_ONDERHOUD);
	}

	static function get_must_use_plugins()
	{
		$aMustUsePlugins = array(	'Limit-Login-Attempts',
						'Sucuri-scanner',
						'WP-security-audit-log',);
		
		$aMustUsePlugins = apply_filters( 'mijnpress_onderhoud_get_must_use_plugins', $aMustUsePlugins );
		return $aMustUsePlugins;
	}

	static function user_has_cap( $allcaps, $cap, $args ) {
		$iUserID = 0;
		$aRemoveCaps = array(	'activate_plugins',
					'edit_plugins',
					'install_plugins',
					'update_plugins',
					'delete_plugins',
					'delete_themes',
					'switch_themes',
					'edit_themes',
				);		
		$aRemoveCaps = apply_filters( 'mijnpress_onderhoud_user_has_cap', $aRemoveCaps );
		$aMainAdmins = apply_filters( 'mijnpress_onderhoud_main_admins', array() );

		if(isset($args) && is_array($args) && isset($args[1]) && $args[1] > 0) {
			$iUserID = $args[1];
		}

		if(is_array($aRemoveCaps) && count($aRemoveCaps) > 0) {
			foreach($aRemoveCaps as $sRemoveCap) {
				if(isset($cap) && is_array($cap) && isset($cap[0]) && $cap[0] === $sRemoveCap) {
					if($iUserID && in_array($iUserID, $aMainAdmins)) {
						// Allowed!
					} else {	
						$allcaps[$cap[0]] = false;
					}
				}
			}
		}
		return $allcaps;
	}
}


/**
 * Include the TGM_Plugin_Activation class.
 */
if ( ! class_exists( 'TGM_Plugin_Activation' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/tgmpluginactivation/class-tgm-plugin-activation.php';
}

add_action( 'tgmpa_register', 'mijnpress_onderhoud_register_required_plugins' );
function mijnpress_onderhoud_register_required_plugins()
{

	if ( ! class_exists( 'TGM_Plugin_Activation' ) ) {
		return false;
	}

	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array();

	foreach(mijnpress_onderhoud::get_must_use_plugins() as $plugin) {
		$plugins[] = array(
			'name'               => str_replace('-',' ',$plugin),
			'slug'               => strtolower($plugin),
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		);
	}

	$config = array(
		'id'           => 'tgmpa'.__FILE__,                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}

mijnpress_onderhoud::init();
?>
