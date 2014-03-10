<?php
namespace Jhg\NexmoBundle\Tests\Command;

use Jhg\NexmoBundle\Command\SmsSendCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Serializer\Exception\RuntimeException;

/**
* Class SmsSendCommandTest
 * @package Jhg\NexmoBundle\Tests\Command
 *
 * @author Javi Hernández
 */
class SmsSendCommandTest extends \PHPUnit_Framework_TestCase {

    public function testExecute()
    {
        $application = new Application();
        $application->add(new SmsSendCommand());

        $command = $application->find('nexmo:sms:send');
        $commandTester = new CommandTester($command);

        try {
            $commandTester->execute(array());
            $this->assertTrue(false);
        } catch(\RuntimeException $e) {
            $this->assertEquals('Not enough arguments.',$e->getMessage());
        }

        $arguments = array(
            'command'   => 'nexmo:sms:send',
            'number'    => 'demo:greet',
            'fromName'  => 'Fabien',
            'message'   => '',
        );

        $input = new ArrayInput($arguments);
        $returnCode = $command->run($input, $output);

        $commandTester->execute(array("+34666555444","MyApp","Hello World!!"));

//        $this->assertRegExp('/.../', $commandTester->getDisplay());
    }
}