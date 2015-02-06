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
class AccountBalanceCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure() {
        $this
            ->setName('nexmo:account:balance')
            ->setDescription('Gets account balance')
            ->setHelp("The <info>nexmo:account:balance</info> command gets Nexmo API account balance");
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
    	$account = $this->getContainer()->get('jhg_nexmo_account');
        $balance = $account->balance();
        $output->writeln(sprintf('Account balance: %f',$balance));
    }
    
}
