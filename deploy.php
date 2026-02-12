<?php

namespace Deployer;

require 'recipe/laravel.php';

set('repository', 'git@github.com:bdilhof/app-spending.git');

host('production')
    ->setHostname('178.128.181.104')
    ->setRemoteUser('deployer')
    ->setDeployPath('/var/www/html/app-spending')
    ->set('branch', 'main');

after('deploy:failed', 'deploy:unlock');
