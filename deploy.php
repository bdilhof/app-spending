<?php

namespace Deployer;

use Symfony\Component\Dotenv\Dotenv;

require __DIR__.'/vendor/autoload.php';
require 'recipe/laravel.php';

$dotenv = new Dotenv;
$dotenv->load(__DIR__.'/.env');

set('repository', 'git@github.com:bdilhof/app-manna.git');
set('keep_releases', 3);
set('use_nvm', false);

host('develop')
    ->setHostname(env('DEPLOYER_DEVELOP_HOSTNAME'))
    ->setRemoteUser(env('DEPLOYER_DEVELOP_REMOTE_USER'))
    ->setDeployPath(env('DEPLOYER_DEVELOP_DEPLOY_PATH'))
    ->set('branch', env('DEPLOYER_DEVELOP_BRANCH'));

/*
task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'artisan:storage:link',
    'artisan:config:cache',
    'artisan:route:cache',
    'artisan:view:cache',
    'artisan:event:cache',
    'artisan:migrate',
    'deploy:publish',
]);
*/

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
