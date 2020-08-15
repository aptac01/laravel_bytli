<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\RedirectActions;
use Illuminate\Http\Request;

class GetAllEndpointsTest extends TestCase
{
    /**
     * Корень должен быть доступен через get
     *
     * @return void
     */
    public function testRootGetTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Корень должен быть доступен через post без дополнительных параметров
     *
     * @return void
     */
    public function testRootPostTest()
    {
        $response = $this->post('/');

        $response->assertStatus(200);
    }

    /**
     * /clear должен быть доступен через post, там редирект
     *
     * @return void
     */
    public function testClearPostTest()
    {
        $response = $this->post('/clear');

        $response->assertStatus(302);
    }

    /**
     * /clear не должен быть доступен через get
     *
     * @return void
     */
    public function testClearGetTest()
    {
        $response = $this->get('/clear');

        $response->assertStatus(404);
    }

    /**
     * /{hash} c придуманным хешем не должен быть доступен через get
     *
     * @return void
     */
    public function testHashGetTest()
    {
        $response = $this->get('/1234');

        $response->assertStatus(404);
    }

    /**
     * /{hash} c придуманным хешем не должен быть доступен через post
     *
     * @return void
     */
    public function testHashPostTest()
    {
        $response = $this->post('/1234');

        $response->assertStatus(405);
    }

    /**
     * Пытаемся запросить / без параметров
     * ответ должен быть положительным, должно вернуться пустое поле checksum
     */
    public function testRequestIndexEmptyTest()
    {
        $request = new Request([]);
        $model = new RedirectActions();
        $data = $model->indexAction($request);

        $this->assertTrue(array_key_exists('checksum', $data) && ($data['checksum'] == null));
    }

    /**
     * "Вводим" валидную ссылку для сокращения (роут /), должно вернуться непустое поле checksum,
     * конструируем путь, который запрашиваем get'ом, ответ должен быть положительным
     */
    public function testRequestIndexTest()
    {
        $request = new Request([
            'link' => 'https://www.yandex.ru/search/?clid=2186621&text=dis%20bitch%20is%20empty&rdrnd=475313&lr=197&re'
                . 'dircnt=1597486879.1',
        ]);
        $model = new RedirectActions();
        $data = $model->indexAction($request);
        $condition1 = array_key_exists('checksum', $data) && ($data['checksum'] != null);
        $condition2 = false;
        if ($condition1) {
            $shortenedLink = (new Request)->fullUrl() . '/' . $data['checksum'];
            $response = $this->get($shortenedLink);
            $condition2 = $response->status() == 200;
        }

        $this->assertTrue($condition1 && $condition2);
    }
}
