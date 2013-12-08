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
 * TS SendGrid Event Webhook Notifier Module Control Panel File
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Module
 * @author		Michael Pasqualone
 * @link		https://www.mpasqualone.com
 */

class Ts_sendgrid_event_webhook_notifier_mcp {
	
	public $return_data;
	public $perpage = 100;
	
	private $_base_url;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
		
		$this->_base_url = BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=ts_sendgrid_event_webhook_notifier';
		
		$this->EE->cp->set_right_nav(array(
			'module_home'	=> $this->_base_url,
			// Add more right nav items here.
		));
	}
	
	// ----------------------------------------------------------------

	/**
	 * Index Function
	 *
	 * @return 	void
	 */
	public function index()
	{
		ee()->load->library('javascript');
		ee()->load->library('table');
		
		$this->EE->view->cp_page_title = lang('ts_sendgrid_event_webhook_notifier_module_name');
		
		$vars['action_url'] = ee()->functions->fetch_site_index(0, 0).QUERY_MARKER.'ACT='.ee()->cp->fetch_action_id('Ts_sendgrid_event_webhook_notifier', 'event_webhook');
		
		// Get our events data from the database
		if ( ! $rownum = ee()->input->get_post('rownum'))
		{
		    $rownum = 0;
		}
		
		ee()->db->order_by("event_id", "desc");
		$data = ee()->db->get('ts_sendgrid_events', $this->perpage, $rownum);
		
		foreach($data->result_array() as $row)
		{
			$vars['events'][$row['event_id']]['event_type'] = $row['event'];
			$vars['events'][$row['event_id']]['event_timestamp'] = $row['timestamp'];
			$vars['events'][$row['event_id']]['event_email'] = $row['email'];
			$vars['events'][$row['event_id']]['event_smtpid'] = $row['smtp-id'];
			$vars['events'][$row['event_id']]['event_ip'] = $row['ipv4'];
			$vars['events'][$row['event_id']]['event_useragent'] = $row['useragent'];
			$vars['events'][$row['event_id']]['event_subject'] = $row['subject'];
		}
		
		$total = ee()->db->count_all('ts_sendgrid_events');
		
		return ee()->load->view('cp', $vars, TRUE);
	}

	/**
	 * Start on your custom code here...
	 */
	
}
/* End of file mcp.ts_sendgrid_event_webhook_notifier.php */
/* Location: /system/expressionengine/third_party/ts_sendgrid_event_webhook_notifier/mcp.ts_sendgrid_event_webhook_notifier.php */