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

class ImageImporterCommand extends Command
{
    protected function configure()
    {
        $this->setName('image-importer')
            ->setDescription('Gets an image from a URl and uploads it to S3 bucket or Server')
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
        $imageClass = New Image();

        try {
            // Get Console Arguments
            $image = $input->getArgument('image');
            $action = $input->getArgument('action');

            //basic image validation
            if (!preg_match('~\.(png|gif|jpe?g|bmp|svg)~i', $image) && $action !== $imageClass::get) {
                throw new \Exception('Only Images are allowed');
            }

            if ($action == $imageClass::save) {
                $saveResult = $imageClass->save($image);
                if($saveResult) {
                    $logger->warning('CONSOLE SAVE : image name '.basename($image));
                    //put file in S3 Bucket
                    if($_ENV['S3_ENABLED']) {
                        $s3Handler = New S3Handler();
                        $s3Handler->uploadFile(basename($image));
                    }

                    //put file in FTP Server
                    if($_ENV['FTP_ENABLED']) {
                        $ftpHandler = new FtpHandler();
                        $ftpHandler->uploadFTP(basename($image), basename($image));
                    }

                    return 1;
                }
            }

            //delete the image
            if ($action == $imageClass::delete) {
                $deleteResult = $imageClass->delete($image);
                if($deleteResult) {
                    $logger->warning('CONSOLE DELETE : image name '.$image);
                    return 1;
                }
            }

            //get all Images
            if ($action == $imageClass::get) {
                $files = $imageClass->getImageList();
                foreach($files as $file){
                    $logger->warning('CONSOLE GET : image name '.$file);
                }
            }

            return 1;
        } catch (\Exception $e) {
            $logger->error('CONSOLE ERROR: '.$e->getMessage());
            return 0;
        }
    }
}
