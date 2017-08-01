<?php

namespace SalesAutoPilot\Controller\Issue;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use SalesAutoPilot\Mapper\IssueMapper;

/**
 * @author Norbert Káplár <kaplarn87@gmail.com>
 */
class IssueCreateController extends IssueController
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
        $data = $request->getParsedBody();        
        $this->data = array_merge($this->data, $data);
        
        if (!isset($data['title']) || !$data['title']) {
            $this->data['titleError'] = 'Title is empty!';
            return $this->render($response, 'Issue/Create.html.twig');
        }
        
        if (!isset($data['contact']) || !$data['contact']) {
            $this->data['contactError'] = 'Contact is empty!';
            return $this->render($response, 'Issue/Create.html.twig');
        }
        
        if (!isset($data['userId']) || !$data['userId']) {
            $this->data['userIdError'] = 'Select a user!';
            return $this->render($response, 'Issue/Create.html.twig');
        }
        
        $users = $this->getUsers();
        if (!isset($users[$data['userId']])) {
            $this->data['userIdError'] = 'User doesn\'t exists!';
            return $this->render($response, 'Issue/Create.html.twig');
        }
        
        if (!isset($data['statusId']) || !$data['statusId']) {
            $this->data['statusIdError'] = 'Select a status!';
            return $this->render($response, 'Issue/Create.html.twig');
        }
        
        $statuses = $this->getStatuses();
        if (!isset($statuses[$data['statusId']])) {
            $this->data['statusIdError'] = 'Status doesn\'t exists!';
            return $this->render($response, 'Issue/Create.html.twig');
        }

        if (!isset($data['deadline'])) {
            $this->data['deadlineError'] = 'Deadline is empty!';
            return $this->render($response, 'Issue/Create.html.twig');
        }
        
        $deadline = strtotime($data['deadline']);
        if (!$deadline) {
            $this->data['deadlineError'] = 'Deadline is bad datetime!';
            return $this->render($response, 'Issue/Create.html.twig');
        }
        
        $data['deadline'] = $deadline;
        $data['created'] = time();
        $this->mapper->create($data);
        
        return $response->withRedirect('/issue/list');
    }
}
