# Coding task for Supermetrics 

## How to run
1. `git clone` (https://git-scm.com/)
2. `cd supermetrics`
3. `composer install --no-dev` (https://getcomposer.org/)
4. `php -S 127.0.0.1:9001 -t ./web` (http://php.net/manual/en/features.commandline.webserver.php)

## How to use
1. http://localhost:9001/ - welcome page, just to have something at /
2. http://localhost:9001/statistics - get posts statistics.

## Configs
1. Right now all provided credentials stored in configs file. 
In prod-ready app it should be in request or in session.
Located in configs to simplify app run.
2. DI hardcoded in dependency_injection config. 
In prod-ready app it should take only path and exclusions as input.