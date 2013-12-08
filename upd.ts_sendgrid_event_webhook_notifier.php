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
 * TS SendGrid Event Webhook Notifier Module Install/Update File
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Module
 * @author		Michael Pasqualone
 * @link		https://www.mpasqualone.com
 */

class Ts_sendgrid_event_webhook_notifier_upd {
	
	public $version = '0.1';
	
	// ----------------------------------------------------------------
	
	/**
	 * Installation Method
	 *
	 * @return 	boolean 	TRUE
	 */
	public function install()
	{
		ee()->load->dbforge();
		
		$mod_data = array(
			'module_name'			=> 'Ts_sendgrid_event_webhook_notifier',
			'module_version'		=> $this->version,
			'has_cp_backend'		=> "y",
			'has_publish_fields'	=> 'n'
		);
		
		ee()->db->insert('modules', $mod_data);
		
		$act_data = array(
			'class'     => 'Ts_sendgrid_event_webhook_notifier',
			'method'    => 'event_webhook'
		);
			
		ee()->db->insert('actions', $act_data);
		
		/* Create our ts_sendgrid_events database */		
		$fields = array(
			'event_id'   => array('type' => 'int', 'constraint' => '10', 'unsigned' => TRUE, 'auto_increment' => TRUE),
			'email'    => array('type' => 'varchar', 'constraint'  => '254'),
			'timestamp' => array('type' => 'int', 'constraint' => '10', 'unsigned' => TRUE, 'default' => '0', 'null' => FALSE),
			'smtp-id'    => array('type' => 'varchar', 'constraint' => '1000'),
			'event' => array('type' => 'varchar', 'constraint' => '32'),
			'ipv4' => array('type' => 'int', 'unsigned' => TRUE, 'null' => TRUE),
			'ipv6' => array('type' => 'binary', 'constraint' => '16'),
			'useragent' => array('type' => 'text', 'null' => TRUE),
			'subject' => array('type' => 'text', 'null' => TRUE)
		);
		
		ee()->dbforge->add_field($fields);
		ee()->dbforge->add_key('event_id', TRUE);

		ee()->dbforge->create_table('ts_sendgrid_events');
		
		return TRUE;
	}

	// ----------------------------------------------------------------
	
	/**
	 * Uninstall
	 *
	 * @return 	boolean 	TRUE
	 */	
	public function uninstall()
	{
		ee()->load->dbforge();
		
		$mod_id = ee()->db->select('module_id')
								->get_where('modules', array(
									'module_name'	=> 'Ts_sendgrid_event_webhook_notifier'
								))->row('module_id');
		
		ee()->db->where('module_id', $mod_id)
					 ->delete('module_member_groups');
		
		ee()->db->where('module_name', 'Ts_sendgrid_event_webhook_notifier')
					 ->delete('modules');
					 
		ee()->db->where('class', 'Ts_sendgrid_event_webhook_notifier');
		ee()->db->delete('actions');				
					
		ee()->dbforge->drop_table('ts_sendgrid_events');
		
		return TRUE;
	}
	
	// ----------------------------------------------------------------
	
	/**
	 * Module Updater
	 *
	 * @return 	boolean 	TRUE
	 */	
	public function update($current = '')
	{
		// If you have updates, drop 'em in here.
		return TRUE;
	}
	
}
/* End of file upd.ts_sendgrid_event_webhook_notifier.php */
/* Location: /system/expressionengine/third_party/ts_sendgrid_event_webhook_notifier/upd.ts_sendgrid_event_webhook_notifier.php */