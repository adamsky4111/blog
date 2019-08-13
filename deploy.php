<?php
namespace Deployer;

require 'vendor/deployer/deployer/recipe/symfony4.php';
task('pwd', function () {
    $result = run('pwd');
    writeln("Current dir: $result");
});

// Project name
set('application', 'my_project');

// Project repository
set('repository', 'https://github.com/adamsky4111/blog.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', []);


// Hosts

host('production')
    ->hostname('adam@127.0.0.1')
    ->set('deploy_path', '~/{{application}}');
    
// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'database:migrate');

