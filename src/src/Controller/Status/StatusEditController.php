<?php

namespace SalesAutoPilot\Controller\Status;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use SalesAutoPilot\Mapper\StatusMapper;

/**
 * @author Norbert Káplár <kaplarn87@gmail.com>
 */
class StatusEditController extends \SalesAutoPilot\Controller\Controller
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
        
        if (!$id || !$status) {
            return $response->withRedirect('/status/list');
        }
        
        $data = $request->getParsedBody();
        if (!isset($data['name']) || !$data['name']) {
            $this->data['status'] = $status;
            $this->data['error'] = 'Name is empty!';
            return $this->render($response, 'Status/Edit.html.twig');
        }
       
        $this->mapper->editName($id, $data['name']);
        
        return $response->withRedirect('/status/list');
    }
}
