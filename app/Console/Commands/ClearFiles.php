<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\File;

class ClearFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:clearFiles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '清理文件';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(File $file)
    {
        parent::__construct();
        $this->file = $file;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('开始清理文件');
        $this->file->clear();
        $this->info('完成清理文件');
    }
}
