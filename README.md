Releasy-App is an Open Source Maintenance platform.

[![SymfonyInsight](https://insight.symfony.com/projects/c42b623e-cb1d-4b43-9a20-74d365f86661/big.svg)](https://insight.symfony.com/projects/c42b623e-cb1d-4b43-9a20-74d365f86661)

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

    $ php bin/console lexik:jwt:generate-keypair

After that, you can use this command to run this Api : 

    $ symfony serve

You can access to Swagger Api from this link : http://localhost:8000/api.


👮 Security issues
------------------

If you think that you have found a security issue in Releasy, please do not use the issue tracker and do not post it publicly. 
Instead, all security issues must be sent to `gary.houbre@gmail.com`.
