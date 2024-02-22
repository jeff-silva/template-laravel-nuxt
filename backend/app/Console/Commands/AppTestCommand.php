<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;

class AppTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $this->info('aaa');

        $test = \App\Models\AppTest::firstOrNew([ 'id' => 1 ]);
        $test->name = 'Test';
        $test->save();

        $cat1 = \App\Models\AppTestCategory::firstOrNew([ 'id' => 1 ]);
        $cat1->name = 'Category 1';
        $cat1->test_id = $test->id;
        $cat1->save();

        $cat2 = \App\Models\AppTestCategory::firstOrNew([ 'id' => 2 ]);
        $cat2->name = 'Category 1';
        $cat2->test_id = $test->id;
        $cat2->save();
    }
}
