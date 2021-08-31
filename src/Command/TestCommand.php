<?php

namespace App\Command;

use App\Entity\Package;
use App\Entity\Git;
use App\Service\ScanService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TestCommand extends Command
{
    protected static $defaultName = 'app:test-command';
    protected static $defaultDescription = 'Add a short description for your command';

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $git = new Git();
        $git->setName("Test");
        $git->setRepositoryName("unicorns-of-codes/backoffice");
        $git->setBaseUrl("https://gitlab.com");
        $git->setProvider(Git::PROVIDER_GITLAB);
        $git->setAccessToken("6oTnHA-ssmPZ7cg-9ymK");
        
        $package = new Package();
        $package->setGit($git);
        $package->setPath("composer.lock");
        $package->setType(Package::TYPE_COMPOSER);

        $scanService = new ScanService();

        $scanService->scan($package);

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return 0;
    }
}
