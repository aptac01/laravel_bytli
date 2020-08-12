<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use App\Models\Redirect;

class RedirectController extends Controller
{
    /**
     * Принимаем длинную ссылку, если всё правильно - генерируем и отдаем короткую
     * если неправильно - показываем ошибку
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
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

        return view('redirectMaker', [
            'data' => $data,
            'checksum' => $checksum,
        ]);
    }

    public function clear(Request $request) {
        $request = new Request();
        return redirect('/');
    }

    /**
     * Если hash - валидный неистекший хэш, который сохранен в базе - редиректим на ссылку из базы
     * иначе - 404
     * @param $hash
     * @return mixed
     */
    public function redirect($hash) {

        $re = '/\d{7,}/m';

        if (preg_match_all($re, $hash, $matches, PREG_SET_ORDER, 0) == 0) {
            abort(404);
        }

        $result = Redirect::where('hash', $hash)->first();

        if (empty($result)) {
            abort(404);
        }

        if ($result->counter > 0) {
            --$result->counter;
            $result->save();
            return redirect($result->payload);
        } else {
            abort(404);
        }
    }

}
