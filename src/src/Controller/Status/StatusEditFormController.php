<?php

namespace SalesAutoPilot\Controller\Status;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use SalesAutoPilot\Mapper\StatusMapper;

/**
 * @author Norbert Káplár <kaplarn87@gmail.com>
 */
class StatusEditFormController extends \SalesAutoPilot\Controller\Controller
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
        $status = $this->mapper->findById($id);
        
        if (!$status) {
            return $response->withRedirect('/status/list');
        }
        
        $this->data['status'] = $status;
        
        return $this->render($response, 'Status/Edit.html.twig');
    }
}
