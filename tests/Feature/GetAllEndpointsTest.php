<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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

    // todo: написать тест который запрашивает форму, заполняет её, отправляет, получает свежую ссылку и тестит её
}
