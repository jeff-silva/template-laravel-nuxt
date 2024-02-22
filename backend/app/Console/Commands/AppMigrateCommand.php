<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;

class AppMigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $models = array_map(function($file) {
            $file = str_replace('.php', '', $file);
            $file = str_replace(base_path('/app'), 'App', $file);
            $file = str_replace('/', '\\', $file);
            return app($file);
        }, File::glob(app_path('Models/*.php')));

        // Delete all foreign keys
        $fks = DB::select("SELECT * FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA=database()
            AND TABLE_NAME IS NOT NULL
            AND COLUMN_NAME IS NOT NULL
            AND REFERENCED_TABLE_NAME IS NOT NULL
            AND REFERENCED_COLUMN_NAME IS NOT NULL
        ;");

        // Delete all foreign keys
        foreach($fks as $fk) {
            Schema::table($fk->TABLE_NAME, function($table) use($fk) {
                $table->dropForeign($fk->CONSTRAINT_NAME);
            });
        }

        foreach ($models as $model) {
            if (!method_exists($model, 'schemaFields')) continue;

            if (Schema::hasTable($model->getTable())) {
                Schema::table($model->getTable(), function(Blueprint $table) use($model) {
                    $field_after = null;
                    foreach($model->schemaFields() as $field_name => $field_call) {
                        $field_exists = Schema::hasColumn($table->getTable(), $field_name);

                        if (!in_array($field_name, ['id'])) {
                            $c = call_user_func($field_call, $table, $field_name);

                            if ($field_after) {
                                $c->after($field_after);
                            }

                            if ($field_exists) {
                                $c->change();
                            }
                        }

                        if ($field_exists) {
                            $field_after = $field_name;
                        }
                    }

                    if (method_exists($model, 'schemaFks')) {
                        foreach($model->schemaFks() as $name => $call) {
                            call_user_func($call, $table, $name);
                        }
                    }
                });
            } else {
                Schema::create($model->getTable(), function(Blueprint $table) use($model) {
                    foreach($model->schemaFields() as $field_name => $field_call) {
                        call_user_func($field_call, $table, $field_name);
                    }
                });

                Schema::table($model->getTable(), function(Blueprint $table) use($model) {
                    if (method_exists($model, 'schemaFks')) {
                        foreach($model->schemaFks() as $name => $call) {
                            call_user_func($call, $table, $name);
                        }
                    }
                });
            }
        }

        foreach ($models as $model) {
            if (method_exists($model, 'schemaSeed')) {
                $model->schemaSeed();
            }
        }
    }
}
