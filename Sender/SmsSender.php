<?php
namespace Jhg\NexmoBundle\Sender;

use Nexmo\NexmoMessage;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class SmsSender
 * @package Jhg\NexmoBundle\Sender
 *
 * @author Javi Hernández
 */
class SmsSender
{
    /**
     * @var \Nexmo\NexmoMessage
     */
    protected $nexmoMessage;

    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    /**
     * @param Container $container
     * @param NexmoMessage $nexmoMessage
     */
    public function __construct(Container $container,NexmoMessage $nexmoMessage) {
		$this->container = $container;
        $this->nexmoMessage = $nexmoMessage;
	}

    /**
     * @param $number
     * @param null $fromName
     * @param $message
     * @param null $unicode
     * @param int $status_report_req
     * @return array|bool|\Nexmo\stdClass
     */
    public function send($number,$fromName=null,$message,$unicode=null, $status_report_req=0) {
		
		if($fromName===null)
			$fromName = $this->container->getParameter('jhg_nexmo.from_name');
		
		return $this->nexmoMessage->sendText($number,$fromName,$message,$unicode,$status_report_req);
	}
}
