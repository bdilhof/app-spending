<?php

namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:bdilhof/app-spending.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('production')
    ->setHostname('178.128.181.104')
    ->setRemoteUser('deployer')
    ->setDeployPath('~/app-spending')
    ->set('branch', 'main');

// Hooks

after('deploy:failed', 'deploy:unlock');
