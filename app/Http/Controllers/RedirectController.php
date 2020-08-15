<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\RedirectActions;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class RedirectController extends Controller
{
    /**
     * Показ формы для ввода длинной ссылки и показ сгенерированной укороченной ссылки (или ошибок валидации)
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $model = new RedirectActions();
        $data = $model->indexAction($request);

        return view('redirectMaker', $data);
    }

    public function clear() {
        return redirect('/');
    }

    /**
     * Если ссылка не истекла - редиректим на неё, иначе (если истекла или не существует) - 404
     * @param $hash
     * @return Application|RedirectResponse|Redirector|void
     */
    public function redirect($hash) {

        $model = new RedirectActions();
        $data = $model->redirectAction($hash);

        if ($data === RedirectActions::ABORT404) {
            return abort(404);
        } else {
            return redirect($data);
        }
    }

}
