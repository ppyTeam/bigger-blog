<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Dev extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '【开发者工具】Development Tools';

    protected $action = [
        'exit' => '【退出工具】Exit the dev tools',
        'update' => '【更新信息】Update information for development',
        'run_npm' => '【执行npm指令】npm run prod(or dev)',
        'seed' => '【数据生成器】database seed',
    ];
    protected $action_step = [
        'update' => 5,
        'dev' => 1,
    ];

    /**
     * @var \Symfony\Component\Console\Helper\ProgressBar
     */
    protected $bar = null;

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
        $this->show_help();
        $options = $this->make_options($this->action);
        $choice = $this->choice('Please choose the number what you want to do,or press Enter to exit', $options, array_keys($options)[0]);
        $choice = $this->get_option_key($choice, $options);
        $max_step = isset($this->action_step[$choice]) ? $this->action_step[$choice] : -1;
        $this->start($max_step);
        call_user_func([$this, 'act_' . $choice]);
        $this->finish();
        return;
    }

    public function show_help()
    {
        $this->info("\e[H\e[J");
        $this->table(['【开发者工具】Development Tools'], []);
        foreach ($this->action as $name => $description) {
            $this->warn('- ' . $name . ":");
            $this->info('    ' . $description);
        }
    }

    private function start($max_step = 0)
    {
        if ($max_step != -1) {
            $this->bar = $this->output->createProgressBar(intval($max_step));
            $this->bar->setFormat('verbose');
            $this->bar->start();
            echo PHP_EOL;
        }
    }

    private function progress($step = 1)
    {
        if ($this->bar !== null) {
            $this->bar->advance($step);
            echo PHP_EOL;
        }
    }

    private function finish()
    {
        if ($this->bar !== null) {
            $this->bar->finish();
            echo PHP_EOL;
        }
        $this->info("Action complete!");
    }

    private function execShell($command)
    {
        $this->line('---');
        $this->info($command);
        $output = shell_exec($command);
        $this->line($output);
        $this->line('---');
    }

    public function act_exit()
    {
        exit;
    }

    public function act_update()
    {
        if ($this->confirm('install composer module? [Y|n]', true)) {
            $this->execShell('composer install');
        }
        $this->progress();
        if ($this->confirm('update npm module? [Y|n]', true)) {
            $no_bin_links = $this->confirm('use no-bin-links?(Might helpful in virtual environment) [Y|n]', true) ? ' --no-bin-links ' : ' ';
            $this->execShell("sudo npm up -g webpack --registry=https://registry.npm.taobao.org/");
            $this->execShell("SASS_BINARY_SITE=http://npm.taobao.org/mirrors/node-sass npm up node-sass" . $no_bin_links . "--registry=https://registry.npm.taobao.org/");
            $this->execShell("for package in $(npm outdated --parseable --depth=0 --registry=https://registry.npm.taobao.org/ | cut -d: -f2) \n do \n npm i  " . '"$package"' . $no_bin_links . " --registry=https://registry.npm.taobao.org/ \n done");
        }
        $this->progress();
        if ($this->confirm('run npm? [Y|n]', true)) {
            $this->execShell("npm run prod");
        }
        $this->progress();
        if ($this->confirm('update database? [Y|n]', true)) {
            $this->execShell("composer db-up");
        }
        $this->progress();
        if ($this->confirm('update idea helper? [y|N]', false)) {
            $this->execShell("composer ide");
        }
    }

    public function act_run_npm()
    {
        if ($this->confirm('run npm prod? [Y|n]', true)) {
            $this->execShell('npm run prod');
        } else {
            $this->execShell('npm run dev');
        }
    }

    public function act_seed()
    {
        $askArr = [
            0 => "【以下全部】\t All the seeders",
            1 => "【生成10篇文章】\t Create 10 posts",
            2 => "【生成3个分类】\t Create 3 categories",
            3 => "【生成5个标签】\t Create 5 tags",
            4 => "【设置分类标签】\t Add some tags and categories to latest 10 posts",
            5 => "【生成2个导航栏】\t Create 2 nav",
        ];
        $actionArr = [
            0 => 'DatabaseSeeder',
            1 => 'PostSeeder',
            2 => 'CategorySeeder',
            3 => 'TagSeeder',
            4 => 'PostTagCategorySeeder',
            5 => 'NavSeeder',
        ];
        $choice = $this->choice('【请选择想要执行的随机数据生成器】Which seeder would you run?', $askArr, 0);
        $this->call('db:seed', ['--class' => $actionArr[array_search($choice, $askArr)]]);
        $this->info('【数据生成完毕!】Seed success！');
        return $this;
    }


    private function make_options($choice_arr)
    {
        $return_arr = [];
        array_walk($choice_arr, function ($value, $key) use (&$return_arr) {
            $return_arr[strtolower($key[0])] = $key . ": \t" . trans($value);
        });
        return $return_arr;
    }

    private function get_option_key($choice, $option_arr)
    {
        return explode(': ', $option_arr[$choice])[0];
    }

}
