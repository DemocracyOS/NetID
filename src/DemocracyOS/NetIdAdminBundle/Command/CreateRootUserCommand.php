<?php
namespace DemocracyOS\NetIdAdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;

class CreateRootUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('netid:root-user:create')
            ->setDescription('Creates the root user for the administration')
            ->setHelp(
                <<<EOT
                    The <info>%command.name%</info> command creates a new root user for the administration if there is not one already.

<info>php %command.full_name%</info>

EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $em = $container->get('doctrine.orm.entity_manager');
        $userRepository = $em->getRepository('ApplicationSonataUserBundle:User');

        $username = $container->getParameter('root_username');
        $root = $userRepository->findOneByUsername($username);
        if (!$root)
        {
            $command = $this->getApplication()->find('fos:user:create');
            $password = $container->getParameter('root_password');
            $email = $container->getParameter('root_email');
            $arguments = array(
                'command' => $command->getName(),
                'username' => $username,
                'email' => $email,
                'password' => $password,
                '--super-admin' => true
            );
            $input = new ArrayInput($arguments);
            $command->run($input, $output);
        } else {
            $output->writeln(
                sprintf(
                    'Already found a root user. No new root user created'
                )
            );
        }
    }
}