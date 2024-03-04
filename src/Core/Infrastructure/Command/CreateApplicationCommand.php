<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Command;

use App\Core\Domain\Entity\Application;
use App\Core\Infrastructure\Repository\ApplicationRepository;
use App\Shared\Domain\ValueObject\Url;
use DomainException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'application:create',
    description: 'Creates new application'
)]
class CreateApplicationCommand extends Command
{
    public function __construct(
        private readonly ApplicationRepository $repository,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');

        /** @var string $applicationName */
        $applicationName = $helper->ask($input, $output, new Question('Please enter the Name: '));

        if ($this->repository->findOneBy(['name' => $applicationName])) {
            throw new DomainException('Application with this name already registered');
        }

        /** @var string $applicationUrlString */
        $applicationUrlString = $helper->ask($input, $output, new Question('Please enter the Url: '));
        $url = new Url($applicationUrlString);

        if ($this->repository->findOneBy(['url' => $url->getValue()])) {
            throw new DomainException('Application with this url already registered');
        }

        $application = new Application(
            $applicationName,
            $url
        );

        $output->writeln(sprintf('<info>Application %s created for url: %s with key: %s</info>', $application->getName(), $application->getUrl(), $application->getApiKey()));

        $this->repository->add($application);

        return Command::SUCCESS;
    }
}
