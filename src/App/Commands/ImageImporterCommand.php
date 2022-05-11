<?php
namespace Console\App\Commands;
 
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Logger\ConsoleLogger;

class ImageImporterCommand extends Command
{


    protected function configure()
    {
        $this->setName('image-importer')
            ->setDescription('Gets an image from a URl and uploads it to S3 bucket or Server')
            ->setHelp('Demonstration of custom commands created by Symfony Console component.')
            ->addArgument('imageUrl', InputArgument::REQUIRED, 'Pass the image Url.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = new ConsoleLogger($output);

        // Get file contents
        $image = $input->getArgument('imageUrl');
       // $output->writeln(sprintf('Hello World!, %s', $imginfo ));
        $downloadedImage = file_get_contents($image);

        file_put_contents('imagemLALALA.jpg', $downloadedImage);
        // Get config if it's S3 or ftp server

        // Call methods

        return 1;
    }
}
