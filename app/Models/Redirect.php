<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Redirect
 *
 * Модель для таблицы, в которой хранятся ссылки с временными короткими роутами
 *
 * @package App
 */
class Redirect extends Model
{
    protected $table = 'redirect';
    protected $primaryKey = 'id';

    protected $attributes = [
        'counter' => 5,
    ];
}
