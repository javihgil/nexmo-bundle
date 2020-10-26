<?php

declare(strict_types=1);

namespace Jhg\NexmoBundle\Command;

use Jhg\NexmoBundle\Managers\AccountManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Javi Hernández
 */
class AccountBalanceCommand extends Command
{
    protected static $defaultName = 'nexmo:account:balance';

    private $nexmoAccount;

    public function __construct(AccountManager $nexmoAccount) {
        $this->nexmoAccount = $nexmoAccount;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Gets account balance');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $balance = $this->nexmoAccount->balance();
        $output->writeln(sprintf('Account balance: %f', $balance));

        return 0;
    }
}
