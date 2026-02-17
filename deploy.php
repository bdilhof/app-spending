<?php

namespace Deployer;

use Symfony\Component\Dotenv\Dotenv;

require __DIR__.'/vendor/autoload.php';
require 'recipe/laravel.php';

// Load environment variables
if (file_exists(__DIR__.'/.env')) {
    $dotenv = new Dotenv;
    $dotenv->load(__DIR__.'/.env');
} else {
    // Fallback when .env not exist
    $_ENV['DEP_PROD_HOSTNAME'] = getenv('DEP_PROD_HOSTNAME');
    $_ENV['DEP_PROD_REMOTE_USER'] = getenv('DEP_PROD_REMOTE_USER');
    $_ENV['DEP_PROD_DEPLOY_PATH'] = getenv('DEP_PROD_DEPLOY_PATH');
    $_ENV['DEP_PROD_BRANCH'] = getenv('DEP_PROD_BRANCH');
}

set('repository', 'git@github.com:bdilhof/app-manna.git');
set('keep_releases', 3);
set('use_nvm', false);

host('develop')
    ->setHostname(env('DEPLOYER_DEVELOP_HOSTNAME'))
    ->setRemoteUser(env('DEPLOYER_DEVELOP_REMOTE_USER'))
    ->setDeployPath(env('DEPLOYER_DEVELOP_DEPLOY_PATH'))
    ->set('branch', env('DEPLOYER_DEVELOP_BRANCH'));

task('build', function () {
    $useNvm = get('use_nvm');
    if ($useNvm) {
        run('cd {{release_path}} && {{nvm}} npm install && {{nvm}} npm run build');
    } else {
        run('cd {{release_path}} && npm install && npm run build');
    }
});

after('deploy:failed', 'deploy:unlock');
after('deploy:symlink', 'build');
after('deploy', 'artisan:cache:clear');
