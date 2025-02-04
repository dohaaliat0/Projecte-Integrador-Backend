<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config
set('application', 'Projecte-Integrador-Backend');
set('repository', 'https://github.com/dohaaliat0/Projecte-Integrador-Backend.git');
set('branch', 'develop');

set('deploy_subdir', 'projecteBackend');

add('shared_dirs', ['storage', 'bootstrap/cache']);
add('shared_files', ['.env']);
add('writable_dirs', ['storage', 'bootstrap/cache']);


// Hosts

host('3.93.183.56')
    ->set('remote_user', 'ddaw-ud4-deployer')
    ->set('identity_file', '~/.ssh/id_rsa')
    ->set('deploy_path', '/var/www/html');

// Hooks

task('deploy:subdir', function () {
    $subdir = get('deploy_subdir');
    run("cd {{release_path}}/$subdir && cp -R . {{release_path}} && rm -rf {{release_path}}/$subdir");
});
before('deploy:shared', 'deploy:subdir');

// Hooks
task('build', function () {
    run('cd {{release_path}} && npm install && npm run build');
});

task('upload:env', function () {
    upload('.env.production', '{{deploy_path}}/shared/.env');
})->desc('Environment setup');

task('artisan:cache:clear', function () {
    run('{{release_path}}/artisan cache:clear');
});

task('artisan:route:clear', function () {
    run('{{release_path}}/artisan route:clear');
});

task('artisan:view:clear', function () {
    run('{{release_path}}/artisan view:clear');
});

task('artisan:config:clear', function () {
    run('{{release_path}}/artisan config:clear');
});

task('php-fpm:restart', function () {
    run('sudo systemctl restart php8.3-fpm');
});



after('deploy:shared', 'upload:env');



after('deploy:failed', 'deploy:unlock');
after('deploy:symlink', 'artisan:cache:clear');
after('deploy:symlink', 'artisan:route:clear');
after('deploy:symlink', 'artisan:view:clear');
after('deploy:symlink', 'artisan:config:clear');
after('deploy:symlink', 'php-fpm:restart');
after('deploy:symlink', 'build');


before('deploy:symlink', 'artisan:migrate');

