<?php

namespace SalesAutoPilot\Controller\Status;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Norbert Káplár <kaplarn87@gmail.com>
 */
class StatusListController extends \SalesAutoPilot\Controller\Controller
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
        $this->data['statuses'] = $this->mapper->findAll();
        
        return $this->render($response, 'Status/List.html.twig');
    }
}
