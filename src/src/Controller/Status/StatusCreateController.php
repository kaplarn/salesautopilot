<?php

namespace SalesAutoPilot\Controller\Status;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use SalesAutoPilot\Mapper\StatusMapper;

/**
 * @author Norbert Káplár <kaplarn87@gmail.com>
 */
class StatusCreateController extends \SalesAutoPilot\Controller\Controller
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
        $data = $request->getParsedBody();
        
        if (!isset($data['name']) || !$data['name']) {
            $this->data['error'] = 'Name is empty!';
            return $this->render($response, 'Status/Create.html.twig');
        }
        
        $this->mapper->create($data['name']);
        
        return $response->withRedirect('/status/list');
    }
}
