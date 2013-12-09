<?php

namespace Jhg\NexmoBundle\Sender;

use Nexmo\NexmoMessage;
use Symfony\Component\DependencyInjection\Container;

class SmsSender
{
	/**
	 * @var Container
	 */
	protected $container;
	
	/**
	 * @var NexmoMessage
	 */
	protected $nexmoMessage;
	
	public function __construct( Container  $container) {
		$this->container = $container;
		
		$api_key = $this->container->getParameter('jhg_nexmo.api_key');
		$api_secret = $this->container->getParameter('jhg_nexmo.api_secret');
		
		$this->nexmoMessage = new NexmoMessage($api_key, $api_secret);
	}
	
	public function send($number,$fromName=null,$message,$unicode=null, $status_report_req=0) {
		
		if($fromName===null)
			$fromName = $this->container->getParameter('jhg_nexmo.from_name');
		
		return $this->nexmoMessage->sendText($number,$fromName,$message,$unicode,$status_report_req);
	}
}
