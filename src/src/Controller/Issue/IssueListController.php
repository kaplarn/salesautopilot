<?php

namespace SalesAutoPilot\Controller\Issue;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use SalesAutoPilot\Mapper\IssueMapper;

/**
 * @author Norbert Káplár <kaplarn87@gmail.com>
 */
class IssueListController extends \SalesAutoPilot\Controller\Controller
{
    /**
     * @var IssueMapper
     */
    protected $mapper;
    
    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function action(RequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $this->data['issues'] = $this->mapper->findAll();
        
        return $this->render($response, 'Issue/List.html.twig');
    }
}
