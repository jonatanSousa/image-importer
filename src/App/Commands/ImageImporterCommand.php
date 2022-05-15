<?php
namespace Console\App\Commands;
 
use Console\App\Library\Image\FileSystem\Image;
use Console\App\Library\Image\FtpHandler;
use Console\App\Library\Image\S3Handler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Logger\ConsoleLogger;

/**
 * TODO: Inherintance should be avoided one should consider find a way to use symfony console without it
 */
class ImageImporterCommand extends Command
{
    private $imageClass;
    private $s3Handler;
    private $ftpHandler;

    public function __construct()
    {
        $this->imageClass = new Image();
        $this->s3Handler = New S3Handler();
        $this->ftpHandler = new FtpHandler();

        parent::__construct(  );
    }

    protected function configure()
    {
        $this->setName('image:importer')
            ->setDescription('Gets an image from a URl and saves it locally to Images directory optionally it can send the image to a S3 bucket or FTP Server')
            ->setHelp('Demonstration of custom commands created by Symfony Console component.')
            ->addArgument('action', InputArgument::REQUIRED, 'can be: SAVE,DELETE,GET ')
            ->addArgument('image', InputArgument::OPTIONAL, 'Pass the image Url or Array of URL');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $logger = new ConsoleLogger($output, []);

        try {
            // Get Console Arguments
            $image = $input->getArgument('image');
            $action = $input->getArgument('action');



            if ($action == $this->imageClass::SAVE) {
                $saveResult = $this->imageClass->save($image);
                if($saveResult) {

                    $output->writeln([
                        'CONSOLE SAVE : image name '.basename($image),
                        '============',
                        '',
                    ]);

                    if($_ENV['S3_ENABLED']) {
                        $this->s3Handler->uploadFile(basename($image));
                    }

                    //put file in FTP Server
                    if($_ENV['FTP_ENABLED']) {
                        $this->ftpHandler->uploadFTP(basename($image), basename($image));
                    }

                    return 1;
                }
            }

            //delete the image
            if ($action == $this->imageClass::DELETE) {
                $deleteResult = $this->imageClass->delete($image);
                if($deleteResult) {
                    $output->writeln('CONSOLE DELETE : image name '.$image);
                    return 1;
                }
            }

            //get all Images
            if ($action == $this->imageClass::GET) {
                $files = $this->imageClass->getImageList();
                $output->writeln([
                    'CONSOLE GET: there are '.count($files).' files in the images directory'
                ]);
                foreach($files as $file){
                    $output->writeln([
                        'CONSOLE GET: image name:  '.$file,
                    ]);
                }
            }

            return 1;
        } catch (\Exception $e) {
            $logger->error('CONSOLE ERROR: '.$e->getMessage());
            return 0;
        }
    }
}
