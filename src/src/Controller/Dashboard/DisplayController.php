<?php

namespace SalesAutoPilot\Controller\Dashboard;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use SalesAutoPilot\Mapper\UserMapper;
use SalesAutoPilot\Mapper\StatusMapper;
use SalesAutoPilot\Mapper\IssueMapper;

/**
 * @author Norbert Káplár <kaplarn87@gmail.com>
 */
class DisplayController extends \SalesAutoPilot\Controller\Controller
{
    /**
     * @var UserMapper
     */
    protected $userMapper;
    
    /**
     * @var StatusMapper
     */
    protected $statusMapper;
    
    /**
     * @var IssueMapper
     */
    protected $issueMapper;
    
    /**
     * @param UserMapper $userMapper
     */
    public function setUserMapper(UserMapper $userMapper)
    {
        $this->userMapper = $userMapper;
    }
    
    /**
     * @param StatusMapper $statusMapper
     */
    public function setStatusMapper(StatusMapper $statusMapper)
    {
        $this->statusMapper = $statusMapper;
    }
    
    /**
     * @param IssueMapper $issueMapper
     */
    public function setIssueMapper(IssueMapper $issueMapper)
    {
        $this->issueMapper = $issueMapper;
    }
    
    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function action(RequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $this->data['users'] = $this->userMapper->findAll();
        $this->data['statuses'] = $this->statusMapper->findAll();
        $this->data['issues'] = $this->issueMapper->findAll();
        
        return $this->render($response, 'Dashboard/Display.html.twig');
    }
}
