<?php

return [
    'input' => 'Please enter:name',
    'choice' => 'Please choose :name',
    'file_not_found' => 'Could not find file :name !',
    'choices' => [
        'production' => 'production environment',
        'local' => 'local develop environment',
    ],
    'title' => '【Setup】',
    'tools_name' => 'Blog Setup Guide',
    'version' => 'Version',
    'update_time' => 'Last Update',
    'choice_tips' => 'the number what you want to do,or press Enter to exit',
    'menu' => [
        'exit' => 'Exit guide',
        'install' => 'Install and initialize',
        'change_env' => 'Switch the development environment/production environment',
    ],
    'already_installed' => 'You had already installed!(if you want to ReInstall,please delete .env file and drop database)',
    'finished' => 'Setup finished!',
    'ask' => [
        'app_url' => 'blog site url(domain or ip,default:http://localhost)',
        'app_env' => 'blog environment:',
        'db_info' => '===Complement Database info===',
        'db_driver' => 'Database driver:',
        'db_host' => 'Database Host:',
        'db_port' => 'Database Port:',
        'db_name' => 'Database Name:',
        'db_username' => 'Database UserName:',
        'db_pwd' => 'Database User Password:',
        'admin_info' => '===Complement Admin User info===',
        'username' => 'Admin Username:',
        'password' => 'Admin Password:',
        'password_confirmation' => 'Please Confirm Password:',
        'email' => 'Admin Email:',
    ],
    'db_wrong' => 'Could not connect to database! Please check the database info.',
    'admin_info_failed' => 'Could not add Admin User!Please check the following errors:',
    'create_table' => 'creating table,it will take a while...',
    'create_admin_role' => 'create admin and configure permissions...',
    'create_default_seed' => 'create default data...',
    'complete' => 'Initialize Setup Complete!',
];