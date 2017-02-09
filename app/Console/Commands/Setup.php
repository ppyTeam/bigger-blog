<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '【初始化安装博客】Setup the blog';

    protected $action = [
        'exit' => 'setup.menu.exit',
        'install' => 'setup.menu.install',
        'update' => 'setup.menu.update',
    ];

    protected $action_step = [
        'install' => 5,
        'update' => 1,
    ];

    /**
     * @var \Symfony\Component\Console\Helper\ProgressBar
     */
    protected $bar = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->choice_language();
        $this->welcome();
        $this->ask_choice();
        return;
    }

    /**
     * choice setup guide language
     */
    public function choice_language()
    {
        $choice = $this->choice('Please select the Language:', ['中文', 'English'], 0);
        switch ($choice) {
            case '中文':
                $language = 'zh_cn';
                break;
            case 'English':
                $language = 'en';
                break;
            default:
                $language = 'zh_cn';
                break;
        }
        \App::setLocale($language);
        $this->execShell('clear');
    }

    /**
     * show welcome guide
     */
    public function welcome()
    {
        $content = [
            [trans('setup.version'), '1.0'],
            [trans('setup.update_time'), '20170208'],
        ];
        $this->table([trans('setup.title'), trans('setup.tools_name')], $content);
        foreach ($this->action as $name => $description) {
            $this->warn('- ' . $name . ":");
            $this->info('    ' . trans($description));
        }
    }

    /**
     * ask choice
     */
    public function ask_choice()
    {
        $choice = $this->choice(trans('setup.choice', ['name' => trans('setup.choice_tips')]), array_keys($this->action), 0);
        $max_step = isset($this->action_step[$choice]) ? $this->action_step[$choice] : -1;
        $this->start_progress($max_step);
        call_user_func([$this, 'act_' . $choice]);
        $this->finish_progress();
    }

    private function act_exit()
    {
        exit;
    }

    private function act_update()
    {
        //
    }

    private function act_install()
    {
        if (file_exists($this->laravel->environmentFilePath())) {
            $this->error(PHP_EOL . trans('setup.already_installed') . PHP_EOL);
            $this->finish_progress();
            exit;
        }
        //App info
        $app_url = $this->ask(trans('setup.input', ['name' => trans('setup.ask.app_url')]), 'http://localhost');
        $this->progress(1, true);
        //Database
        while (true) {
            $config_arr = $this->ask_db_config();
            if ($this->test_connection($config_arr) === true) break;
            $this->warn(trans('setup.db_wrong'));
        }
        $this->progress(1, true);
        //Migration

        //Admin info

        $config_arr['APP_URL'] = $app_url;
        $this->create_env_file($config_arr);
        $this->info(trans('setup.complete'));
    }


    private function ask_db_config()
    {
        $this->info(trans('setup.ask.db_info'));
        $config_arr['DB_CONNECTION'] = $this->choice(trans('setup.choice', ['name' => trans('setup.ask.db_driver')]), ['mysql', 'pgsql', 'sqlite', 'sqlsrv'], 0);
        if ($config_arr['DB_CONNECTION'] == 'sqlite') {
            $config_arr['DB_DATABASE'] = $this->ask(trans('setup.input', ['name' => trans('setup.ask.db_name')]), database_path('database.sqlite'));
        } else {
            $config_arr['DB_HOST'] = $this->ask(trans('setup.input', ['name' => trans('setup.ask.db_host')]), 'localhost');
            $config_arr['DB_PORT'] = $this->ask(trans('setup.input', ['name' => trans('setup.ask.db_port')]), '3306');
            $config_arr['DB_DATABASE'] = $this->ask(trans('setup.input', ['name' => trans('setup.ask.db_name')]), '');
            $config_arr['DB_USERNAME'] = $this->ask(trans('setup.input', ['name' => trans('setup.ask.db_username')]), '');
            $config_arr['DB_PASSWORD'] = $this->ask(trans('setup.input', ['name' => trans('setup.ask.db_pwd')]), '');
        }
        return $config_arr;
    }

    private function start_progress($max_step = 0)
    {
        if ($max_step != -1) {
            $this->bar = $this->output->createProgressBar(intval($max_step));
            $this->bar->setFormat('verbose');
            $this->bar->start();
            echo PHP_EOL;
        }
    }

    private function progress($step = 1, $clear = false)
    {
        if ($clear) {
            $this->line(shell_exec('clear'));
        }
        if ($this->bar !== null) {
            $this->bar->advance($step);
            echo PHP_EOL;
        }
    }

    private function finish_progress()
    {
        if ($this->bar !== null) {
            $this->bar->finish();
            echo PHP_EOL;
        }
        $this->info(trans('setup.finished'));
    }

    private function execShell($command)
    {
        $this->line('---');
        $this->info($command);
        $output = shell_exec($command);
        $this->line($output);
        $this->line('---');
    }

    private function create_env_file($config_arr)
    {
        $this->execShell('cp .env.example .env');
        $this->execShell('php artisan key:generate');
        foreach ($config_arr as $key => $val) {
            $this->setEnv($key, $val);
        }
    }

    private function setEnv($key, $value)
    {
        file_put_contents($this->laravel->environmentFilePath(), preg_replace(
            '/^' . $key . '=.*$/m',
            $key . '=' . $value,
            file_get_contents($this->laravel->environmentFilePath())
        ));

    }

    private function test_connection($config_arr)
    {
        $capsule = app(\Illuminate\Database\Capsule\Manager::class);
        switch ($config_arr['DB_CONNECTION']) {
            case 'sqlite':
                $connect_arr = [
                    'driver' => 'sqlite',
                    'database' => $config_arr['DB_DATABASE'],
                    'prefix' => '',
                ];
                break;
            case 'mysql':
                $connect_arr = [
                    'charset' => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    'prefix' => '',
                    'strict' => true,
                    'engine' => null,
                ];
                break;
            case 'pgsql':
                $connect_arr = [
                    'charset' => 'utf8',
                    'prefix' => '',
                    'schema' => 'public',
                    'sslmode' => 'prefer',
                ];
                break;
            case 'sqlsrv':
                $connect_arr = [
                    'charset' => 'utf8',
                    'prefix' => '',
                ];
                break;
        }
        if ($config_arr['DB_CONNECTION'] != 'sqlite') {
            $connect_arr['driver'] = $config_arr['DB_CONNECTION'];
            $connect_arr['host'] = $config_arr['DB_HOST'];
            $connect_arr['port'] = $config_arr['DB_PORT'];
            $connect_arr['database'] = $config_arr['DB_DATABASE'];
            $connect_arr['username'] = $config_arr['DB_USERNAME'];
            $connect_arr['password'] = $config_arr['DB_PASSWORD'];
        }
        try {
            $capsule->addConnection($connect_arr, 'test_connection');
            $conn = $capsule->getConnection('test_connection');
            $conn->getPdo()->getAttribute(\PDO::ATTR_SERVER_INFO);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return false;
        }
        return true;
    }

}
