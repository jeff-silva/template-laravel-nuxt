<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppTestCategory extends Model
{
    use HasFactory, ModelTrait;

    protected $table = 'app_test_category';
    protected $fillable = ['slug', 'name', 'test_id'];

    public function schemaFields()
    {
        return [
            'id' => fn($table) => $table->id(),
            'slug' => fn($table, $field) => $table->string($field, 255)->nullable(),
            'name' => fn($table, $field) => $table->string($field, 255)->nullable(),
            'test_id' => fn($table, $field) => $table->unsignedBigInteger($field)->nullable(),
            'created_at' => fn($table, $field) => $table->dateTime($field)->nullable(),
            'updated_at' => fn($table, $field) => $table->dateTime($field)->nullable(),
            'deleted_at' => fn($table, $field) => $table->dateTime($field)->nullable(),
        ];
    }

    public function schemaFks()
    {
        return [
            'test_id' => fn($table, $field) => $table->foreign($field)->references('id')->on('app_test'),
        ];
    }
}
