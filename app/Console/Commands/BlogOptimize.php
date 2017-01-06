<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BlogOptimize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:optimize 
                            {--C|clear : only clear cache【可选参数:仅清除缓存】}
                            {--O|optimize : only optimize【可选参数:仅优化框架】}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize the blog and refresh laravel cache.【清理和优化博客框架文件缓存】';

    protected $optimize_shells = [
        'php artisan config:cache',
        'php artisan route:cache',
        'php artisan optimize',
    ];
    protected $clear_shells = [
        'php artisan config:clear',
        'php artisan route:clear',
        'php artisan view:clear',
        'php artisan clear-compiled',
    ];

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
        $is_clear = $this->option('clear');
        $is_optimize = $this->option('optimize');
        if ($is_clear) {
            $this->execShellFromArray($this->clear_shells);
            $this->info("Clear Successful!");
        } elseif ($is_optimize) {
            $this->execShellFromArray($this->optimize_shells);
            $this->info("Optimize Successful!");
        } else {
            $this->execShellFromArray(array_merge($this->clear_shells, $this->optimize_shells));
            $this->info("All Successful!");
        }
    }

    public function execShellFromArray($command_arr)
    {
        $this->output->progressStart(count($command_arr));
        foreach ($command_arr as $eachShell) {
            $this->execShell($eachShell);
            $this->output->progressAdvance();
        }
        $this->output->progressFinish();
    }

    public function execShell($command)
    {
        $this->line('---');
        $this->info($command);
        $output = shell_exec($command);
        $this->line($output);
        $this->line('---');
    }
}
