# Image importer

=============================

This CLI app performs basic validation on the image and allow it’s storage, retrieval and deletion on the file system, also 
makes it easy to upload to a S3Buckets or FTP server.
On the .env file the "S3_ENABLED=1" enables the s3 bucket upload.
On the .env file the "FTP_ENABLED=1" enables the Ftp upload.

# Installation

Clone the repository to a configured webserver.

```
git clone https://github.com/jonatanSousa/image-importer.git
```

This project  uses composer as dependency manager in the root directory install it,
following the instructions on https://getcomposer.org/doc/00-intro.md

After downloading composer execute this command:
```
composer install
```



At the project root path make a **.env.example** file a copy named **.env** with the following parameters:

```
#S3 bucket configuration
S3_ENABLED=0
S3_BUCKET=<your s3 bucket>
S3_SECRET_KEY=<your s3 bucket key>
S3_BUCKET_REGION="eu-west-2"

#FTP configuration
FTP_ENABLED=0
FTP_HOST=<your FTP host>
FTP_USERNAME=<your FTP username>
FTP_PASSWORD=<your FTP password>
```

Unit Testing
=============================
Unit tests are using are doing basic verifications on image storage class.

```
phpunit
```

Usage
=============================
The console command CLI has 3 actions (GET, SAVE, DELETE) 
eg:

```
bin/console image-import SAVE http://dev-humansciences.au.edu/wp-content/uploads/2022/02/testing.jpg 
```

```
bin/console image-import DELETE testing.jpg 
```

To retrieve all images saved in the server one can use the GET action

```
bin/console image-import GET 
```

