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
    protected $description = 'Development Tools【开发者工具】';

    protected $action = [
        'help' => 'show tools list information【工具清单帮助说明】',
        'update' => 'Update information for development【更新信息】',
        'run_npm' => 'npm run prod(or dev)【执行npm指令】',
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
        $choice = $this->choice('Please choose the number what you want to do', array_keys($this->action), 0);
        $max_step = isset($this->action_step[$choice]) ? $this->action_step[$choice] : -1;
        $this->start($max_step);
        call_user_func([$this, 'act_' . $choice]);
        $this->finish();
        return;
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


    public function act_help()
    {
        $this->info("Tool list description:");
        foreach ($this->action as $name => $description) {
            $this->warn('- ' . $name . ":");
            $this->info('    ' . $description);
        }
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


}
