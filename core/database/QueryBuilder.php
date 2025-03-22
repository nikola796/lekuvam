<?php

class QueryBuilder
{

    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getParents()
    {
        $stmt = $this->pdo->prepare('');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function getDirsTest($id)
    {
        $stmt = $this->pdo->prepare();

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectAll($table)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$table} WHERE active = 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectAllSpaces()
    {
        $stmt = $this->pdo->prepare('');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectFolders($table)
    {
        $stmt = $this->pdo->prepare('');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectDirectories($id)
    {
//        $sql = "SELECT * FROM {$table} WHERE {$column}  = {$id}";
//        return $sql;
        $stmt = $this->pdo->prepare("");
        $stmt->execute(array(0 => $id));
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectFiles($table, $id)
    {

        $stmt = $this->pdo->prepare("");
        $stmt->execute(array(0 => $id));
        return $stmt->fetchAll(PDO::FETCH_CLASS);

    }

    public function selectAllFiles($params)
    {

        $stmt = $this->pdo->prepare("");
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_CLASS);

    }

    public function insert($table, $params)
    {

        $sql = sprintf('INSERT INTO %s (%s) VALUES (%s)',

            $table,

            implode(', ', array_keys($params)),

            ':' . implode(', :', array_keys($params))

        );

        // return $params['name'];

        try {

            $stmt = $this->pdo->prepare($sql);
            //var_dump($statement->queryString);

            $stmt->execute($params);

            //return $stmt->rowCount();

        } catch (Exception $e) {

            die($e->getMessage());

        }
    }
}