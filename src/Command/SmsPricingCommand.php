<?php

declare(strict_types=1);

namespace Jhg\NexmoBundle\Command;

use Jhg\NexmoBundle\Managers\AccountManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Javi Hernández
 */
class SmsPricingCommand extends Command
{
    protected static $defaultName = 'nexmo:sms:pricing';

    private $nexmoAccount;

    public function __construct(AccountManager $nexmoAccount)
    {
        $this->nexmoAccount = $nexmoAccount;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Gets sms price for given country')
            ->setDefinition([
                new InputArgument('country', InputArgument::REQUIRED, 'The country code'),
            ])
            ->setHelp('The <info>nexmo:sms:pricing</info> command gets Nexmo API SMS pricing for a given country');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $country = (string) $input->getArgument('country'); // @phpstan-ignore-line

        $price = $this->nexmoAccount->smsPricing($country);

        $output->writeln(sprintf('SMS sending price for "%s": %f', $country, $price));

        return 0;
    }
}
