<?php
require 'recipe/laravel.php';

// Set configurations
set('repository', 'git@github.com:dorianneto/api-notes.git');
set('writable_dirs', ['bootstrap', 'storage']);
set('default_stage', 'production');
env('composer_options', 'install --verbose --prefer-dist --optimize-autoloader --no-progress --no-interaction');

// Configure servers
server('prod', '104.131.82.121')
    ->user('root')
    ->identityFile()
    ->stage('production')
    ->env('branch', 'master')
    ->env('deploy_path', '/var/www/html/dorianneto.com.br/hsa/production');

// Tasks
task('deploy:permissions', function () {
    cd('{{release_path}}');
    run('sudo chown -R www-data:www-data {{release_path}}');
    run('sudo chmod -R 775 bootstrap/');
    run('sudo chmod -R 775 storage/');
})->desc('Set bootstrap path permissions');

task('artisan:migrate', function () {
    $output = run('{{bin/php}} {{release_path}}/artisan migrate --force');
    writeln('<info>' . $output . '</info>');
})->desc('Execute artisan migrations');

task('artisan:migrate:reset', function () {
    $output = run('{{bin/php}} {{release_path}}/artisan migrate:reset --force');
    writeln('<info>' . $output . '</info>');
})->desc('Execute artisan migrations reset');

task('artisan:seed', function () {
    $output = run('{{bin/php}} {{release_path}}/artisan db:seed --force');
    writeln('<info>' . $output . '</info>');
})->desc('Execute artisan seeds');

task('deploy:configure', function () {
    env('timezone', 'America/Fortaleza');
})->desc('Execute deploy configuration');

task('env_file', function() {
    upload(__DIR__ . DIRECTORY_SEPARATOR . '.env.prod', '{{deploy_path}}/current/.env');
});

task('deploy', [
    'deploy:configure',
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:symlink',
    'deploy:writable',
    'deploy:permissions',
    'deploy:shared',
    'deploy:vendors',
    'cleanup',
    'env_file',
    'artisan:cache:clear',
    'artisan:migrate:reset',
    'artisan:migrate',
    'artisan:seed'
]);
