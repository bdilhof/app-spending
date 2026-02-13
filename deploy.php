<?php

namespace Deployer;

require 'recipe/laravel.php';

set('repository', 'git@github.com:bdilhof/app-spending.git');
set('keep_releases', 3);

host('production')
    ->setHostname('178.128.181.104')
    ->setRemoteUser('deployer')
    ->setDeployPath('/var/www/html/app-spending')
    ->set('branch', 'main');

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
