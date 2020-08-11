<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use App\Models\Redirect;
use Redirect as system_redirect;

class RedirectController extends Controller
{
    //
    public function index()
    {
        // todo: добавить поле с submit кнопкой, по сабмиту:
        //  принимать адрес
        //  показывать итоговую ссылку
        //  итоговую ссылку показывать в этой же вьюшке

        // добавлять временную переменную к адресу и генерить crc32 hash
        // сохранять hash в базу, выставлять счетчик == 5

        // таблица - id(autogen_sequence) - hash - counter - payload(link)
        $date = new DateTime();

        $strPayload = 'http://pornhub.com/'; // Не знаю почему, но именно этот сайт пришел первый в голову
        $str = $strPayload . $date->getTimestamp();

        $checksum = crc32($str);

        $redirect = new Redirect();
        $redirect->hash = $checksum;
        $redirect->payload = $strPayload;
        $redirect->save();

        return view('welcome');
    }

    public function redirect($hash) {
        // todo: понять что $hash - это действительно хеш а не рандомная строка

        // выбрать из базы записи с таким хешем, посмотреть счетчик, если счетчик == 0 - 404
        // если не 0 - уменьшить его на один и редиректнуть на payload

        $result = Redirect::where('hash', $hash)->first();

        if ($result->counter > 0) {
            --$result->counter;
            $result->save();
            return system_redirect::to($result->payload);
        } else {
            abort(404);
        }
    }

}
