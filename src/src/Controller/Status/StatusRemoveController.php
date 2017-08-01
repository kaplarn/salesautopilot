<?php

namespace SalesAutoPilot\Controller\Status;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use SalesAutoPilot\Mapper\StatusMapper;

/**
 * @author Norbert Káplár <kaplarn87@gmail.com>
 */
class StatusRemoveController extends \SalesAutoPilot\Controller\Controller
{
    /**
     * @var StatusMapper
     */
    protected $mapper;
    
    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function action(RequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $route = $request->getAttribute('route');
        $id = (int)$route->getArgument('id');
        
        $this->mapper->removeById($id);
       
        return $response->withRedirect('/status/list');
    }
}
