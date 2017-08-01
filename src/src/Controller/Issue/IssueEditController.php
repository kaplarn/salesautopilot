<?php

namespace SalesAutoPilot\Controller\Issue;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use SalesAutoPilot\Mapper\IssueMapper;

/**
 * @author Norbert Káplár <kaplarn87@gmail.com>
 */
class IssueEditController extends IssueController
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
        if (!$id || !$issue) {
            return $response->withRedirect('/status/list');
        }
        
        $data = $request->getParsedBody();
        foreach ($data as $key => $value) {
            if (!array_key_exists($key, $issue)) {
                continue;
            }
            
            $issue[$key] = $value;
        }
       
        $this->data['issue'] = $issue;
        $this->data['users'] = $this->getUsers();
        $this->data['statuses'] = $this->getStatuses();
        
        if (!isset($issue['title']) || !$issue['title']) {
            $this->data['titleError'] = 'Title is empty!';
            return $this->render($response, 'Issue/Edit.html.twig');
        }
        
        if (!isset($issue['contact']) || !$issue['contact']) {
            $this->data['contactError'] = 'Contact is empty!';
            return $this->render($response, 'Issue/Edit.html.twig');
        }
        
        if (!isset($issue['userId']) || !$issue['userId']) {
            $this->data['userIdError'] = 'Select a user!';
            return $this->render($response, 'Issue/Edit.html.twig');
        }
        
        $users = $this->getUsers();
        if (!isset($users[$issue['userId']])) {
            $this->data['userIdError'] = 'User doesn\'t exists!';
            return $this->render($response, 'Issue/Edit.html.twig');
        }
        
        if (!isset($issue['statusId']) || !$issue['statusId']) {
            $this->data['statusIdError'] = 'Select a status!';
            return $this->render($response, 'Issue/Edit.html.twig');
        }
        
        $statuses = $this->getStatuses();
        if (!isset($statuses[$issue['statusId']])) {
            $this->data['statusIdError'] = 'Status doesn\'t exists!';
            return $this->render($response, 'Issue/Edit.html.twig');
        }

        if (!isset($issue['deadline'])) {
            $this->data['deadlineError'] = 'Deadline is empty!';
            return $this->render($response, 'Issue/Edit.html.twig');
        }
        
        $deadline = strtotime($issue['deadline']);
        if (!$deadline) {
            $this->data['deadlineError'] = 'Deadline is bad datetime!';
            return $this->render($response, 'Issue/Edit.html.twig');
        }
        
        $issue['deadline'] = $deadline;
       
        $this->mapper->update($id, $issue);
        
        return $response->withRedirect('/issue/list');
    }
}
