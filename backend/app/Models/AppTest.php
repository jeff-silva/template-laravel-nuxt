<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppTest extends Model
{
    use HasFactory, ModelTrait;

    protected $table = 'app_test';
    protected $fillable = ['slug', 'name', 'parent_id', 'parent_id2', 'description'];

    public function schemaFields()
    {
        return [
            'id' => fn($table) => $table->id(),
            'slug' => fn($table, $field) => $table->string($field, 255)->nullable(),
            'name' => fn($table, $field) => $table->string($field, 255)->nullable(),
            'parent_id' => fn($table, $field) => $table->unsignedBigInteger($field)->nullable(),
            'parent_id2' => fn($table, $field) => $table->unsignedBigInteger($field)->nullable(),
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
