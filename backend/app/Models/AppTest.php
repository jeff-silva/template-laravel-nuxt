<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppTest extends Model
{
    use HasFactory;

    protected $table = 'app_test';

    public function schemaFields()
    {
        return [
            'id' => fn($table) => $table->id(),
            'slug' => fn($table, $field) => $table->string($field, 255)->nullable(),
            'name' => fn($table, $field) => $table->string($field, 255)->nullable(),
            'parent_id' => fn($table, $field) => $table->unsignedBigInteger($field),
            'parent_id2' => fn($table, $field) => $table->unsignedBigInteger($field),
            'description' => fn($table, $field) => $table->text($field)->nullable(),
            'created_at' => fn($table, $field) => $table->dateTime($field)->nullable(),
            'updated_at' => fn($table, $field) => $table->dateTime($field)->nullable(),
            'deleted_at' => fn($table, $field) => $table->dateTime($field)->nullable(),
        ];
    }

    public function schemaFks()
    {
        return [
            'parent_id' => fn($table, $field) => $table->foreign($field)->references('id')->on('app_test'),
            'parent_id2' => fn($table, $field) => $table->foreign($field)->references('id')->on('app_test'),
        ];
    }
}
