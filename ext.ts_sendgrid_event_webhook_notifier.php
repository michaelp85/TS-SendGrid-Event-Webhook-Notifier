<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * TS SendGrid Event Webhook Notifier Module Front End File
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Module
 * @author		Michael Pasqualone
 * @link		https://www.mpasqualone.com
 */
 
class Ts_sendgrid_event_webhook_notifier_ext {
	
	var $name       	= 'TS SendGrid Event Webhook Notifier';
    var $version        = '0.1';
    var $description    = 'Receive information about events that occur as SendGrid processes your email.';
    var $settings_exist = 'n';
    var $docs_url       = '';
	var $settings       = array();
	
	/**
	 * Constructor
	 *
	 * @param   mixed   Settings array or empty string if none exist.
	 */
	function __construct($settings='')
	{
	    $this->settings = $settings;
	}
	
	/**
	 * Activate Extension
	 *
	 * @return void
	 */
	function activate_extension()
	{
	    $data = array(
	        'class'     => __CLASS__,
	        'method'    => 'add_xsmtpapi_data',
	        'hook'      => 'email_send',
	        'settings'  => serialize($this->settings),
	        'priority'  => 10,
	        'version'   => $this->version,
	        'enabled'   => 'y'
	    );
	
	    ee()->db->insert('extensions', $data);
	}
	
	/**
	 * Add x-smtpapi data to outbound e-mail.
	 * @see: http://ellislab.com/expressionengine/user-guide/development/extension_hooks/global/email/index.html
	 */
	function add_xsmtpapi_data($email)
	{
		// Do stuff here ...
		return $email;
	}
}
 
/* End of file ext.ts_sendgrid_event_webhook_notifier.php */
/* Location: /system/expressionengine/third_party/ts_sendgrid_event_webhook_notifier/ext.ts_sendgrid_event_webhook_notifier.php */