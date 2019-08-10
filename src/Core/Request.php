<?php

namespace App\Api\Core;


class Request implements RequestInterface
{
    protected static $count = 0;

    protected $id;
    /** @var array */
    protected $nodesPath;
    protected $params;
    protected $postData;
    protected $method;
    protected $body;
    protected $action;
    protected $is_public;

    public function __construct($patch, $method, $action, bool $is_public = false, $param = null, $body = null)
    {
        self::$count++;
        $this->is_public = $is_public;
        $this->action    = $action;
        $this->method    = $method;
        $this->nodesPath = self::patchToArray($patch);


        $this->param     = $param;
        $this->body      = $body;
        $this->id        = self::$count;
    }

    public static function patchToArray(string $patch) : array {
        if(($indexParams = strpos($patch,'?'))!=false ){
            $patch = substr($patch,0,$indexParams);
        };
        $nodes = array_filter(explode('/', $patch), function ($el) {
            return !empty($el);
        });
        return $nodes;
    }

    /**
     * @return bool
     */
    public function isPublic(): bool
    {
        return $this->is_public;
    }

    /**
     * @param bool $is_public
     */
    public function setIsPublic(bool $is_public): void
    {
        $this->is_public = $is_public;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return array
     */
    public function getNodesPath(): array
    {
        return $this->nodesPath;
    }

    /**
     * @param array $nodesPath
     */
    public function setNodesPath(array $nodesPath): void
    {
        $this->nodesPath = $nodesPath;
    }


    /**
     * @param string $key
     * @return null|string
     */
    public function getParam(string $key):?string
    {
        return isset($this->params[$key])?$this->params[$key]:null;
    }

    /**
     * @param null $param
     */
    public function setParams($param): void
    {
        $this->params = $param;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method): void
    {
        $this->method = $method;
    }

    /**
     * @return null
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param null $body
     */
    public function setBody($body): void
    {
        $this->body = $body;
    }



    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action): void
    {
        $this->action = $action;
    }

    public function setPost($post): void
    {
        $this->postData = $post;

    }

    public function getPost(string $key): ?string
    {
        return isset($this->postData['key'])?$this->postData['key']:null;

    }


}