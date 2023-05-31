# unraveled-aws-s3-php

List, get and put objects to a s3 bucket with a clean version of aws php sdk.


How to use:
1. Clone the repository
2. Install required packages: "composer install"
3. Delete folder "aws" inside "vendor" folder
4. Move "custom-aws" folder to "vendor" and rename it to "aws"
5. Insert your aws credentials, region and bucket name on ".env-example" file and rename it to ".env"