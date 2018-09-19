<?php
/**
 * Database class that extends PDO
 */
class ASDatabase extends PDO
{
    public function __construct($DB_TYPE, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS)
    {
        try {
            parent::__construct($DB_TYPE.':host='.$DB_HOST.';dbname='.$DB_NAME, $DB_USER, $DB_PASS);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
    
    /**
     * select
     * @param string $sql An SQL string
     * @param array $array Paramters to bind
     * @param constant $fetchMode A PDO Fetch mode
     * @return mixed
     */
    public function select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    {
        $sth = $this->prepare($sql);
        foreach ($array as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        
        $sth->execute();
        return $sth->fetchAll($fetchMode);
    }
    
    /**
     * insert
     * @param string $table A name of table to insert into
     * @param string $data An associative array
     */
    public function insert($table, $data)
    {
        ksort($data);
        
        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));
        
        $sth = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");
        
        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        
        $sth->execute();
    }
    
    /**
     * update
     * @param string $table A name of table to insert into
     * @param string $data An associative array where keys have the same name as database columns
     * @param string $where the WHERE query part
     * @param string $whereBindArray Paramters to bind to where part of query
     */
    public function update($table, $data, $where, $whereBindArray = array())
    {
        ksort($data);
        
        $fieldDetails = NULL;
        
        foreach($data as $key=> $value) {
            $fieldDetails .= "`$key`=:$key,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');
        
        $sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");
        
        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        
        foreach ($whereBindArray as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        
        
        $sth->execute();
    }
    
    /**
     * delete
     * 
     * IF YOU USE PREPARED STATEMENTS, DON'T FORGET TO UPDATE $bind ARRAY!
     * 
     * @param string $table
     * @param string $where
     * @param integer $limit
     * @return integer Affected Rows
     */
    public function delete($table, $where, $bind = array(), $limit = 1)
    {
        $sth = $this->prepare("DELETE FROM $table WHERE $where LIMIT $limit");
        
        foreach ($bind as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        
        $sth->execute();
    }
}