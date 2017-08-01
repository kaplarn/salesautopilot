<?php

namespace SalesAutoPilot\Mapper;

/**
 * @author Norbert Káplár <kaplarn87@gmail.com>
 */
abstract class Mapper
{
    /**
     * @var \PDO
     */
    protected $pdo;
    
    /**
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    /**
     * @return []
     */
    public function findAll() : array
    {
        $sql = "SELECT * FROM `" . $this->getTableName() . "`";
        $query = $this->pdo->prepare($sql);
        $query->execute();
        
        return $query->fetchAll();
    }
    
    /**
     * @param int $id
     * @return []
     */
    public function findById(int $id) : array
    {
        $sql = 
            "SELECT * " .
            "FROM `" . $this->getTableName() . "` " .
            "WHERE `id` = :id";
        
        $query = $this->pdo->prepare($sql);
        $query->bindParam('id', $id, \PDO::PARAM_INT);
        $query->execute();
        
        $result = $query->fetch();
                
        return is_array($result) ? $result : [];
    }
    
    /**
     * @param int $id
     */
    public function removeById(int $id)
    {
        $sql = 
            "DELETE " .
            "FROM `" . $this->getTableName() . "` " .
            "WHERE `id` = :id";
        
        $query = $this->pdo->prepare($sql);
        $query->bindParam('id', $id, \PDO::PARAM_INT);
        $query->execute();
    }
    
    /**
     * @return string
     */
    protected function getTableName() : string
    {
        $parts = explode('\\', get_called_class());
        return preg_replace('#Mapper$#', '', lcfirst(end($parts)));
    }
}
