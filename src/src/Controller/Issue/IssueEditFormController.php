<?php

namespace SalesAutoPilot\Controller\Issue;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use SalesAutoPilot\Mapper\IssueMapper;

/**
 * @author Norbert Káplár <kaplarn87@gmail.com>
 */
class IssueEditFormController extends IssueController
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
        $route = $request->getAttribute('route');
        $id = (int)$route->getArgument('id');
        $issue = $this->mapper->findById($id);
        
        if (!$issue) {
            return $response->withRedirect('/issue/list');
        }
        
        $this->data['users'] = $this->getUsers();
        $this->data['statuses'] = $this->getStatuses();
        $this->data['issue'] = $issue;
        
        return $this->render($response, 'Issue/Edit.html.twig');
    }
}
