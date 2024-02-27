<?php

namespace App\Console\Commands;

// use ElephantIO\Client;
// use ElephantIO\Engine\SocketIO\Version1X;
use SocketIO\Emitter;
use App\Events\TestEvent;
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
        // $this->whatsappTest();
        $this->websocketTest();
    }

    public function websocketTest()
    {
        $this->info('websocketTest');
        // event(new TestEvent('Hello'));

        // $client = Client::create('http://localhost:8443', ['client' => Client::CLIENT_4X]);
        // $client->connect();
        // $client->emit('message', [ 'test' => true ]);
        // $client->disconnect();

        $emitter = new Emitter([ 'host' => 'localhost', 'port' => '8443' ]); // Using the Redis extension provided client
        $emitter->broadcast->emit('message', 'dxxxxxx');
    }

    public function whatsappTest()
    {
        $facebook_appid = '705141625145813';
        $facebook_secret = '002174f1dd24d367fe01d9d7bfcbe33e';
        $api_endpoint = "https://graph.facebook.com/v18.0/5531995271426/messages";
        $this->info('whatsappTest');
    }

    public function crudTest()
    {
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
