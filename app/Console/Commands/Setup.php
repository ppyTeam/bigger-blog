<?php

namespace App\Console\Commands;

use Caffeinated\Shinobi\Models\Role;
use Illuminate\Console\Command;
use Hash;
use App;
use Validator;

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
        'switch' => 'setup.menu.change_env',
    ];

    protected $action_step = [
        'install' => 6,
        'switch' => 1,
    ];

    /**
     * @var \Symfony\Component\Console\Helper\ProgressBar
     */
    protected $bar = null;

    protected $app_url = null;
    protected $app_env = null;
    protected $config_arr = [];

    /**
     * Create a new command instance.
     *
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
        $this->choice_language()
            ->welcome()
            ->ask_choice();
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
        return $this;
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
        return $this;
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
        return $this;
    }

    protected function act_exit()
    {
        exit;
    }

    protected function act_switch()
    {
        //
    }

    protected function act_install()
    {
        if (file_exists($this->laravel->environmentFilePath())) {
            $this->error(PHP_EOL . trans('setup.already_installed') . PHP_EOL);
            $this->finish_progress();
            exit;
        }
        $this->ask_app_info()
            ->ask_db_config()
            ->create_config_file()
            ->do_migration()
            ->ask_admin_info()
            ->do_db_seed()
            ->optimize();
        if ($this->bar !== null) {
            $this->bar->finish();
            echo PHP_EOL;
        }
        $this->info(trans('setup.complete'));
        exit;
    }

    /**
     * Record App info
     * @return $this
     */
    protected function ask_app_info()
    {
        $this->app_url = $this->ask(trans('setup.input', ['name' => trans('setup.ask.app_url')]), 'http://localhost');
        $this->app_env = $this->choice(trans('setup.choice', ['name' => trans('setup.ask.app_env')]), ['production' => trans('setup.choices.production'), 'local' => trans('setup.choices.local')], 'production');
        return $this;
    }

    /**
     * Record Database info
     * @return $this
     */
    protected function ask_db_config()
    {
        $this->progress(1, true);
        while (true) {
            $this->info(trans('setup.ask.db_info'));
            $config_arr = [];
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
            $this->config_arr = $config_arr;
            if ($this->test_connection($this->config_arr) === true) break;
            $this->warn(trans('setup.db_wrong'));
        }
        return $this;
    }

    /**
     * Create ENV config file
     * @return $this
     */
    protected function create_config_file()
    {
        $this->config_arr['APP_URL'] = $this->app_url;
        $this->config_arr['APP_ENV'] = $this->app_env;
        $this->create_env_file($this->config_arr);
        $this->execShell('php artisan config:cache');
        return $this;
    }

    /**
     * Create migration table
     * @return $this
     */
    protected function do_migration()
    {
        $this->progress(1, true);
        $this->execShell('php artisan migrate:install');
        $this->info(trans('setup.create_table'));
        $this->execShell('php artisan migrate --force');
        return $this;
    }

    /**
     * Record Admin info
     * @return $this
     */
    protected function ask_admin_info()
    {
        $this->progress(1, true);
        while (true) {
            $this->info(trans('setup.ask.admin_info'));
            $user['username'] = $this->ask(trans('setup.input', ['name' => trans('setup.ask.username')]), 'admin');
            $user['password'] = $this->secret(trans('setup.input', ['name' => trans('setup.ask.password')]));
            $user['password_confirmation'] = $this->secret(trans('setup.ask.password_confirmation'));
            $user['email'] = $this->ask(trans('setup.input', ['name' => trans('setup.ask.email')]), '');
            //validate
            $validator = Validator::make($user, [
                'username' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:3|confirmed',
                'password_confirmation' => 'required|min:3'
            ]);
            if (!$validator->fails()) {
                break;
            }
            $this->warn(trans('setup.admin_info_failed'));
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
        }
        $admin = app(App\User::class);
        $admin->name = $user['username'];
        $admin->email = $user['email'];
        $admin->password = Hash::make($user['password']);
        $admin->save();
        $this->config_RBAC($admin);
        return $this;
    }

    /**
     * Configure R.B.A.C
     * @param App\User $admin
     * @return $this
     */
    protected function config_RBAC(App\User $admin)
    {
        $this->progress(1, false);
        $this->info(trans('setup.create_admin_role'));
        $this->execShell('php artisan db:seed --class=SetupRBAC');
        $owner = Role::where(['name' => 'owner'])->first();
        $admin->assignRole($owner->id);
        return $this;
    }

    /**
     * Initialize some default data
     * @return $this
     */
    protected function do_db_seed()
    {
        $this->progress(1, false);
        $this->info(trans('setup.create_default_seed'));
        $this->execShell('php artisan db:seed --class=SetupSeeder');
        return $this;
    }

    protected function optimize()
    {
        $this->execShell('php artisan route:cache');
        $this->execShell('php artisan optimize');
        return $this;
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
        foreach ($config_arr as $key => $val) {
            $this->setEnv($key, $val);
        }
        $this->execShell('php artisan key:generate');
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
        $connect_arr = [];
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
            $capsule->addConnection($connect_arr);
            $conn = $capsule->getConnection();
            $conn->getPdo()->getAttribute(\PDO::ATTR_SERVER_INFO);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return false;
        }
        return true;
    }

}
