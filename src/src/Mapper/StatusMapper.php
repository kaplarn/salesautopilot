<?php

namespace SalesAutoPilot\Mapper;

/**
 * @author Norbert Káplár <kaplarn87@gmail.com>
 */
class StatusMapper extends Mapper
{
    /**
     * @param string $name
     */
    public function create(string $name)
    {
        $sql = "INSERT INTO `status` (`name`) VALUES (:name)";
       
        $query = $this->pdo->prepare($sql);
        $query->bindParam('name', $name, \PDO::PARAM_STR);
        $query->execute();
    }
    
    /**
     * @param int $id
     * @param string $name
     */
    public function editName(int $id, string $name)
    {
        $sql = "UPDATE `status` SET `name` = :name WHERE `id` = :id";
        
        $query = $this->pdo->prepare($sql);
        $query->bindParam('id', $id, \PDO::PARAM_INT);
        $query->bindParam('name', $name, \PDO::PARAM_STR);
        $query->execute();
    }
}
