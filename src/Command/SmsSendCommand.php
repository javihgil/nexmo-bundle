<?php

declare(strict_types=1);

namespace Jhg\NexmoBundle\Command;

use Jhg\NexmoBundle\Managers\SmsManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Javi Hernández
 */
class SmsSendCommand extends Command
{
    protected static $defaultName = 'nexmo:sms:send';

    private $smsManager;

    public function __construct(SmsManager $smsManager)
    {
        $this->smsManager = $smsManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Send a SMS message')
            ->setDefinition([
                new InputArgument('number', InputArgument::REQUIRED, 'The number'),
                new InputArgument('fromName', InputArgument::REQUIRED, 'The name shown as origin'),
                new InputArgument('message', InputArgument::REQUIRED, 'The message'),
                new InputOption('report', 'r', InputOption::VALUE_OPTIONAL, 'Ask for status report'),
            ])
            ->setHelp(<<<EOT
The <info>nexmo:sms:send</info> command sends a SMS message through Nexmo API
<info>php app/console nexmo:sms:send +34666555444 MyApp "Hello World!!"</info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $number   = (string) $input->getArgument('number'); // @phpstan-ignore-line
        $fromName = (string) $input->getArgument('fromName'); // @phpstan-ignore-line
        $message  = (string) $input->getArgument('message'); // @phpstan-ignore-line
        $report   = (int) $input->getOption('report'); // @phpstan-ignore-line

        $response = $this->smsManager->sendText($number, $message, $fromName, $report);

        $output->writeln(sprintf('SMS send to %s from %s: "%s"', $number, $fromName, $message));
        $output->writeln(sprintf('   message id: %s', $response->getMessageId()));
        $output->writeln(sprintf('   status: %s', $response->getStatus()));
        $output->writeln(sprintf('   message price: %f', $response->getMessagePrice()));
        $output->writeln(sprintf('   remaining balance: %f', $response->getRemainingBalance()));
        $output->writeln(sprintf('   network: %u', $response->getNetwork()));

        return 0;
    }
}
