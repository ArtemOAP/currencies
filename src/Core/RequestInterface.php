<?php
/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 04.12.2018
 * Time: 17:12
 */

namespace App\Api\Core;


interface RequestInterface
{
    const METHOD_HEAD = 'HEAD';
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_PATCH = 'PATCH';
    const METHOD_DELETE = 'DELETE';
    const METHOD_PURGE = 'PURGE';
    const METHOD_OPTIONS = 'OPTIONS';
    const METHOD_TRACE = 'TRACE';
    const METHOD_CONNECT = 'CONNECT';


    public function getBody();
    public function getMethod();
    public function setParams($param): void;
    public function setPost($post): void;
    public function getPost(string $key): ?string;
    public function getParam(string $key): ?string;
    public function getAction() :string ;
    public function isPublic(): bool;
    public function getNodesPath() :array;
}