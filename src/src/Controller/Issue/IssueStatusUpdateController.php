<?php

namespace SalesAutoPilot\Controller\Issue;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use SalesAutoPilot\Mapper\IssueMapper;

/**
 * @author Norbert Káplár <kaplarn87@gmail.com>
 */
class IssueStatusUpdateController extends IssueController
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
        $statusId = (int)$route->getArgument('statusId');

        $statuses = $this->getStatuses();
        if (isset($statuses[$statusId])) {
            $this->mapper->updateStatus($id, $statusId);
        }
        
        return $response;
    }
}
