<?php

namespace SalesAutoPilot\Controller\Issue;

use SalesAutoPilot\Mapper\UserMapper;
use SalesAutoPilot\Mapper\StatusMapper;

/**
 * @author Norbert Káplár <kaplarn87@gmail.com>
 */
abstract class IssueController extends \SalesAutoPilot\Controller\Controller
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
     * @return []
     */
    protected function getUsers() : array
    {
        $result = [];
        foreach ($this->userMapper->findAll() as $user) {
            $result[$user['id']] = $user['name'];
        }
        
        return $result;
    }
    
    /**
     * @return []
     */
    protected function getStatuses() : array
    {
        $result = [];
        foreach ($this->statusMapper->findAll() as $status) {
            $result[$status['id']] = $status['name'];
        }
        
        return $result;
    }
}
