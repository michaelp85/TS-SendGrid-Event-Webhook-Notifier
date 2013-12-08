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

class Ts_sendgrid_event_webhook_notifier {
	
	public $return_data;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
	}
	
	// ----------------------------------------------------------------

	public function event_webhook()
	{
		/* Get raw POST'ed JSON data */
		$data = json_decode( file_get_contents('php://input') );
	
		/* Debugging */
		/* $fh = fopen('/mnt/san-cbr/internal/dev/frameworks/expressionengine2/totalserve.net.au/system/expressionengine/third_party/ts_sendgrid_event_webhook_notifier/events.log', 'a+');
		if ( $fh )
		{			
			fwrite($fh, print_r($data, true));
			fclose($fh);
		} */
		
		foreach($data as $event)
		{
			$data = array(
				'email' => $event->email,
				'timestamp' => $event->timestamp,
				'smtp-id' => $event->{'smtp-id'},
				'event' => $event->event,
				'subject' => $event->subject
			);
			
			// If it's an open, event
			switch ($event->event)
			{
				case 'open':
					$data['ipv4'] = ip2long ( $event->ip );
					$data['useragent'] = $event->useragent;
					break;
			}
			
			ee()->db->insert('ts_sendgrid_events', $data);
		}
	}	
}
/* End of file mod.ts_sendgrid_event_webhook_notifier.php */
/* Location: /system/expressionengine/third_party/ts_sendgrid_event_webhook_notifier/mod.ts_sendgrid_event_webhook_notifier.php */