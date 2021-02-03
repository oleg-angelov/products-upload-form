<?php

declare(strict_types=1);

include 'Router.php';

use PHPUnit\Framework\TestCase;

final class RouterTest extends TestCase {

    public function testRouterProcessing() {

        $router = new Router;

        $router->addRoute('testRoute', 'testValue');

        $this->assertTrue($router->getRoute('testRoute') === 'testValue');
    }
}
