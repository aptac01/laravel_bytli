<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RedirectController extends Controller
{
    //
    public function index()
    {
        // todo: добавить поле с submit кнопкой, по сабмиту:
        //  принимать адрес, добавлять временную переменную к нему и генерить crc32 hash
        //  сохранять hash в базу, выставлять счетчик == 5
        //  показывать итоговую ссылку
        //  итоговую ссылку показывать в этой же вьюшке

        // таблица - id(autogen_sequence) - hash - counter - payload(link)
        return view('welcome');
    }

    public function redirect($hash) {
        // todo: понять что $hash - это действительно хеш а не рандомная строка
        //  выбрать из базы записи с таким хешем, посмотреть счетчик, если счетчик == 0 - 404
        //  если не 0 - уменьшить его на один и редиректнуть на payload

        return Redirect::to('http://www.google.ru/search?&q=' . $hash);
    }

}
