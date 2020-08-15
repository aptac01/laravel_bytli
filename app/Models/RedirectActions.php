<?php

namespace App\Models;

use DateTime;
use Illuminate\Http\Request;

/**
 * Class RedirectActions
 * Модель для операций с данными для action'ов
 *
 * @package App\Models
 */
class RedirectActions
{
    // сигнал о том, что нужно вернуть 404 ошибку пользователю
    public const ABORT404 = 'abort404';
    /**
     * Принимаем длинную ссылку, если всё правильно - генерируем и отдаем короткую
     * если неправильно - показываем ошибку
     *
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        if ($request->has('link')) {
            $data = $request->validate([
                'link' => 'required|url|max:1745',
            ]);

            $str = $data['link'] . (new DateTime())->getTimestamp();

            $checksum = crc32($str);

            $redirect = new Redirect();
            $redirect->hash = $checksum;
            $redirect->payload = $data['link'];
            $redirect->save();
        } else {
            $data = null;
            $checksum = null;
        }

        return [
            'data' => $data,
            'checksum' => $checksum,
        ];
    }

    /**
     * Если hash - валидный неистекший хэш, который сохранен в базе - возвращаем ссылку из базы
     * иначе - 404
     *
     * @param $hash
     * @return mixed
     */
    public function redirectAction($hash)
    {
        $re = '/\d{7,}/m';

        if (preg_match_all($re, $hash, $matches, PREG_SET_ORDER, 0) == 0) {
            return self::ABORT404;
        }

        $result = Redirect::where('hash', $hash)->first();

        if (empty($result)) {
            return self::ABORT404;
        }

        if ($result->counter > 0) {
            --$result->counter;
            $result->save();
            return $result->payload;
        } else {
            return self::ABORT404;
        }
    }
}
