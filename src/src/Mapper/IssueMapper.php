<?php

namespace SalesAutoPilot\Mapper;

/**
 * @author Norbert Káplár <kaplarn87@gmail.com>
 */
class IssueMapper extends Mapper
{
    /**
     * @return []
     */
    public function findAll() : array
    {
        $sql = 
            "SELECT " .
                "`issue`.*, " .
                "`user`.`name` `user`, " .
                "`status`.`name` `status` " .
            "FROM " .
                "`issue` " .
                "JOIN `user` " .
                    "ON `issue`.`userId` = `user`.`id` " .
                "JOIN `status` " .
                    "ON `issue`.`statusId` = `status`.`id`";
        
        $query = $this->pdo->prepare($sql);
        $query->execute();
        
        return $query->fetchAll();
    }
    
    /**
     * @param [] $data
     */
    public function create(array $data)
    {
        $sql =
            "INSERT INTO `issue` " .
                "(`userId`, `statusId`, `created`, `deadline`, `contact`, `title`, `description`) " .
            "VALUES " .
                "(:userId, :statusId, :created, :deadline, :contact, :title, :description)";
        
        $query = $this->pdo->prepare($sql);
        $query->bindParam('userId', $data['userId']);
        $query->bindParam('statusId', $data['statusId']);
        $query->bindParam('created', $data['created']);
        $query->bindParam('deadline', $data['deadline']);
        $query->bindParam('contact', $data['contact']);
        $query->bindParam('title', $data['title']);
        $query->bindParam('description', $data['description']);
        
        $query->execute();
    }
    
    /**
     * @param int $id
     * @param [] $data
     */
    public function update(int $id, array $data)
    {
        $sql =
            "UPDATE `issue` SET " .
                "`userId` = :userId, " .
                "`statusId` = :statusId, " .
                "`deadline` = :deadline, " .
                "`contact` = :contact, " .
                "`title` = :title, " .
                "`description` = :description " .
            "WHERE " .
                "`id` = :id";
        
        $query = $this->pdo->prepare($sql);
        $query->bindParam('userId', $data['userId'], \PDO::PARAM_INT);
        $query->bindParam('statusId', $data['statusId'], \PDO::PARAM_INT);
        $query->bindParam('deadline', $data['deadline'], \PDO::PARAM_INT);
        $query->bindParam('contact', $data['contact'], \PDO::PARAM_STR);
        $query->bindParam('title', $data['title'], \PDO::PARAM_STR);
        $query->bindParam('description', $data['description'], \PDO::PARAM_STR);
        $query->bindParam('id', $id);
        
        $query->execute();
    }
    
    /**
     * @param int $id
     * @param int $statusId
     */
    public function updateStatus(int $id, int $statusId)
    {
        $sql = 
            "UPDATE `issue` SET " .
                "`statusId` = :statusId " .
            "WHERE `id` = :id";
        
        $query = $this->pdo->prepare($sql);
        $query->bindParam('statusId', $statusId, \PDO::PARAM_INT);
        $query->bindParam('id', $id, \PDO::PARAM_INT);
        
        $query->execute();
    }
}
