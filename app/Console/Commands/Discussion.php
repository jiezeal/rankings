<?php

namespace App\Console\Commands;

use App\Redis\MasterCache;
use Illuminate\Console\Command;

class Discussion extends Command
{
    protected $signature = 'command:Discussion';
    protected $skey = STRING_DISCUSSION_INFO_;
    protected $masterCache;

    public function __construct(MasterCache $masterCache)
    {
        parent::__construct();
        $this->masterCache = $masterCache;
    }

    public function handle()
    {
        \Log::info('test');
    }
}