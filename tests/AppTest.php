<?php
namespace App\Api\Tests;

use App\Api\Core\Request;
use App\Api\Core\RequestInterface;
use App\Api\Core\Router;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    public function testRequest()
    {
        $req = new Request('patch/1/2/3/this',RequestInterface::METHOD_GET,'test');
        $this->assertTrue($req->isPublic() == false);
        $this->assertTrue($req->getId() === 1);
        $this->assertEquals($req->getNodesPath(),['patch','1','2','3','this']);
        $this->assertTrue($req->getMethod() == "GET");
        $this->assertTrue($req->getAction() == "test");
        $req = new Request('patch',RequestInterface::METHOD_GET,1,'test');
        $this->assertEquals($req->getNodesPath(),['patch']);
        $this->assertTrue($req->getId() === 2);

    }

    public function testRoute()
    {
        $route =Router::getInstance();
        $route->addAllowableRequest(new Request('patch/1/2/3/this',RequestInterface::METHOD_GET,'test'));
        $route->addAllowableRequest(new Request('patch/1/2/3/this2',RequestInterface::METHOD_GET,'test2'));
        $route->addAllowableRequest(new Request('patch',RequestInterface::METHOD_GET,'test3'));
        $route->addAllowableRequest(new Request('patch/1/2/{idsdsd}',RequestInterface::METHOD_GET,'test4'));
        $route->addAllowableRequest(new Request('patch/1/2/{id1}/{id2}',RequestInterface::METHOD_GET,'test4'));
        $this->assertTrue($route->countAllowableRequest() === 5);
        $request = $route->search(['patch','1','2','10']);
        $this->assertEquals($request->getNodesPath(),array (
            'patch' => 'patch',
            1 => '1',
            2 => '2',
            'idsdsd' => '10',
        ));

        $request = $route->search(['patch','1','2','10','20']);
        $this->assertEquals($request->getNodesPath(),array (
            'patch' => 'patch',
            1 => '1',
            2 => '2',
            'id1' => '10',
            'id2' => '20',
        ));


    }


}