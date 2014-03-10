<?php
namespace Jhg\NexmoBundle\Tests\Sender;
use Jhg\NexmoBundle\Sender\SmsSender;

/**
 * Class SmsSenderTest
 * @package Jhg\NexmoBundle\Tests\Sender
 *
 * @author Javi Hernández
 */
class SmsSenderTest extends \PHPUnit_Framework_TestCase
{
    public function getSendData() {
        return array(
            array(
                array(
                    'jhg_nexmo.api_key'=>'asdfghjkl',
                    'jhg_nexmo.api_secret'=>'1234567890',
                    'jhg_nexmo.from_name'=>'From Name',
                ),
                '+34666555444',
                'From Name',
                'Message',
                null,
                0,
                array(),
            ),
        );
    }


    /**
     * @dataProvider getSendData
     */
    public function testSend($containerParameters,$number,$fromName,$message,$unicode,$status_report_req,$sendRequestReturnData) {
        $containerMock = $this->getMock('Symfony\Component\DependencyInjection\Container');

        $nexmoMessageMock = $this->getMock('Nexmo\NexmoMessage',array(),array($containerMock,$containerParameters['jhg_nexmo.api_key'],$containerParameters['jhg_nexmo.api_secret']));
        $nexmoMessageMock->expects($this->any())
                            ->method('sendRequest')
                            ->will($this->returnValue($sendRequestReturnData));


        $sender = new SmsSender($containerMock,$nexmoMessageMock);
        $result = $sender->send($number,$fromName,$message,$unicode,$status_report_req);

        $this->assertEquals(null,$result);
    }
} 