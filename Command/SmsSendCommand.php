<?php
namespace Jhg\NexmoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Javi Hernández
 */
class SmsSendCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure() {
        $this
            ->setName('nexmo:sms:send')
            ->setDescription('Send a SMS message')
            ->setDefinition(array(
                new InputArgument('number', InputArgument::REQUIRED, 'The number'),
                new InputArgument('fromName', InputArgument::REQUIRED, 'The name shown as origin'),
                new InputArgument('message', InputArgument::REQUIRED, 'The message'),
                new InputOption('report','r',InputOption::VALUE_OPTIONAL,'Ask for status report'),
            ))
            ->setHelp(<<<EOT
The <info>nexmo:sms:send</info> command sends a SMS message through Nexmo API
<info>php app/console nexmo:sms:send +34666555444 MyApp "Hello World!!"</info>
EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $number = $input->getArgument('number');
        $fromName = $input->getArgument('fromName');
        $message = $input->getArgument('message');
        $report = (int)$input->getOption('report');

    	$smsManager = $this->getContainer()->get('jhg_nexmo_sms');

    	if($response = $smsManager->sendText($number,$message,$fromName,$report)) {
	        $output->writeln(sprintf('SMS send to %s from %s: "%s"',$number,$fromName,$message));
	        $output->writeln(sprintf('   message id: %s',$response->getMessageId()));
	        $output->writeln(sprintf('   status: %s',$response->getStatus()));
            $output->writeln(sprintf('   message price: %f',$response->getMessagePrice()));
	        $output->writeln(sprintf('   remaining balance: %f',$response->getRemainingBalance()));
	        $output->writeln(sprintf('   network: %u',$response->getNetwork()));
    	} else {
    		$output->writeln(sprintf('There was an error sending SMS to %s from %s: "%s"',$number,$fromName,$message));
    	}
    }
    
}
