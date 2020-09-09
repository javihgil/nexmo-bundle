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
class SmsPricingCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure() {
        $this
            ->setName('nexmo:sms:pricing')
            ->setDescription('Gets sms price for given country')
            ->setDefinition(array(
                new InputArgument('country', InputArgument::REQUIRED, 'The country code'),
            ))
            ->setHelp("The <info>nexmo:sms:pricing</info> command gets Nexmo API SMS pricing for a given country");
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $country = $input->getArgument('country');

    	$account = $this->getContainer()->get('jhg_nexmo_account');
        $price = $account->smsPricing($country);

        if($price===false) {
            throw new \Exception("Country not valid");
        } else {
            $output->writeln(sprintf('SMS sending price for "%s": %f',$country,$price));
        }
    }
    
}
