<?php

namespace AliensDev;

class Route
{
    /**
     * the Route method
     * @var string
     */

    private $method;
    /**
     * the Route URI
     * @var $url string
     */
    private $url;

    /**
     * the route callable
     * @var $callable callable|array
     */
    private $callable;

    /**
     * the matched Route
     * @var $matchUri string
     */
    private $matchUri;

    /**
     * the route params if exists
     * @var $params array
     */
    private $params = [];

    /**
     * Route constructor.
     * @param string $method
     * @param string $url
     * @param $callable
     */
    public function __construct(string $method, string $url, $callable)
    {
        $this->method = $method;
        $this->url = $url;
        $this->callable = $callable;
    }

    public function setMatchUri($uri)
    {
        $this->matchUri = $uri;
    }

    public function getMatchUri()
    {
        return $this->matchUri;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return callable
     */
    public function getCallable()
    {
        return $this->callable;
    }

    /**
     * @param $callable
     */
    public function setCallable($callable): void
    {
        $this->callable = $callable;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array $params
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }
}