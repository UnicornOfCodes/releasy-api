Releasy-App is an Open Source Maintenance platform.

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/d1cc65f18af34f68a01645226fccd518)](https://app.codacy.com/gh/UnicornOfCodes/releasy-api?utm_source=github.com&utm_medium=referral&utm_content=UnicornOfCodes/releasy-api&utm_campaign=Badge_Grade_Settings)

⚙️ Installation
--------------

Requirement (you can use this command "composer check" for verify): 
 - php 7.4.9+
 - composer > 2.0.0



For install dependencies : 

    $ composer install

You need to create your .env.local with .env and modify with your parameters.

To create a database and install migrations :

    $ php bin/console doctrine:database:create
    $ php bin/console doctrine:migrations:migrate

To generate SSL keys for JWT Token :

    $ mkdir config/jwt
    $ php bin/console lexik:jwt:generate-keypair

After that, you can use this command to run this Api : 

    $ symfony serve

You can access to Swagger Api from this link : http://localhost:8000/api.


👮 Security issues
------------------

If you think that you have found a security issue in Releasy, please do not use the issue tracker and do not post it publicly. 
Instead, all security issues must be sent to `gary.houbre@gmail.com`.
