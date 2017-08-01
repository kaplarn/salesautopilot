<?php

namespace SalesAutoPilot\Controller;

use Slim\Views\Twig;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use SalesAutoPilot\Mapper\Mapper;

/**
 * @author Norbert Káplár <kaplarn87@gmail.com>
 */
abstract class Controller
{
    /**
     * @var Twig
     */
    protected $twig;
    
    /**
     * @var Mapper
     */
    protected $mapper;
    
    /**
     * @var []
     */
    protected $data = [];
    
    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    abstract public function action(RequestInterface $request, ResponseInterface $response) : ResponseInterface;
    
    /**
     * @param Twig $twig
     */
    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }
    
    /**
     * @param Mapper $mapper
     */
    public function setMapper(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }
    
    /**
     * @param ResponseInterface $response
     * @param string $template
     * @return ResponseInterface
     */
    protected function render(ResponseInterface $response, string $template = '') : ResponseInterface
    {
        return $this->twig->render($response, $template, $this->data);
    }
}