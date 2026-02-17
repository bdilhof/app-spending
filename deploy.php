<?php

namespace Deployer;

use Symfony\Component\Dotenv\Dotenv;

require __DIR__.'/vendor/autoload.php';
require 'recipe/laravel.php';

$dotenv = new Dotenv;
$dotenv->load(__DIR__.'/.env');

set('repository', 'git@github.com:bdilhof/app-manna.git');
set('keep_releases', 3);

host('production')
    ->setHostname(env('DEPLOYER_PRODUCTION_HOSTNAME'))
    ->setRemoteUser(env('DEPLOYER_PRODUCTION_REMOTE_USER'))
    ->setDeployPath(env('DEPLOYER_PRODUCTION_DEPLOY_PATH'))
    ->set('branch', env('DEPLOYER_PRODUCTION_BRANCH'));

task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'artisan:storage:link',
    'artisan:config:cache',
    'artisan:route:cache',
    'artisan:view:cache',
    'artisan:event:cache',
    // 'artisan:migrate',
    'deploy:publish',
]);

after('deploy:failed', 'deploy:unlock');
// after('deploy:symlink', 'build');
// after('deploy', 'artisan:cache:clear');
