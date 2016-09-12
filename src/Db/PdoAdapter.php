<?php
namespace JCI\Base\Db;


class PdoAdapter
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @param string $dsn
     * @param string $username
     * @param string $password
     * @param array $options
     */
    public function __construct($dsn, $username, $password, array $options = [])
    {
        // TODO: those options comes from the configuration and not here.
        // TODO: create specific MySql PDO class
        if (empty($options))
        {
            $options = [
                \PDO::MYSQL_ATTR_INIT_COMMAND   => "SET NAMES 'UTF8'",
                \PDO::ATTR_ERRMODE              => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE   => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES     => false,
            ];
        }
        $this->pdo = new \PDO($dsn, $username, $password, $options);
    }
    
    /**
     * @param string $statement
     * @return PDOStatement
     */
    public function prepare($statement)
    {
        return $this->pdo->prepare($statement);
    }
    
    /**
     * Query exec method that return last insert id
     *
     * @param string $sql
     * @param array $params
     * @return mixed
     */
    public function insert($sql, array $params = [])
    {
        $st = $this->prepare($sql);
        try {
            $st->execute($params);
        } catch (\PDOException $ex) {
            if (23000 == $ex->getCode()) {
                return false;
            } else {
                throw new \Exception($ex->getMessage(), 500);
            }
        }    
        return $this->pdo->lastInsertId();
    }
    
    // TODO: Implement this.
    public function bulkInsert($table, $params)
    {
        $paramsToInsert = [];
        $sqlToAttach="";
        $sql = "INSERT INTO `$table` VALUE ";
        $countColumns = count($params[0]);
        $values = "(";
        for($i = 0; $i<$countColumns-1; $i++) {
            $values .= "?,";
        }
        $values .= "?)";
        for ($i = 0; $i<count($params)-1; $i++) {
            $sql .= $values . ', ';
        }
        $sql .= $values;
        $st = $this->prepare($sql);
        $st->execute(call_user_func_array("array_merge", $params));
    }
    
    /**
     * Query exec method that true if the query was succesful or ignored
     * Used for tables with no auto inc primary
     *
     * @param string $sql
     * @param array $params
     * @return mixed
     */
    public function insertNoAI($sql, array $params = [])
    {
        $st = $this->prepare($sql);
        $st->execute($params);
        return true;
    }
    
    /**
     * Select query for multiple items
     *
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function selectAll($sql, array $params = [])
    {
        return $this->fetchAll($this->prepare($sql), $params);
    }
    
    /**
     * Select query for single item
     *
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function selectOne($sql, array $params = [], $class = null)
    {
        return $this->fetch($this->prepare($sql), $params, $class);
    }
    
    /**
     * @param string $sql
     * @param array $params
     * @return boolean
     */
    public function remove($sql, $params = [])
    {
        $st = $this->prepare($sql);
        try {
            $st->execute($params);
            return true;
        } catch (\PDOException $ex) {
            return false;
        }
    }
    
    /**
     * @param string $sql
     * @param array $params
     * @return boolean
     */
    public function update($sql, $params = [])
    {
        $st = $this->prepare($sql);
        try {
            $st->execute($params);
            return true;
        } catch (\PDOException $ex) {
            if (23000 == $ex->getCode()) {
                return false;
            }
        } 
    }
    
    public function lastError()
    {
        return $this->pdo->errorInfo();
    }
    
    /**
     * @param \PDOStatement $st
     * @param array $params
     * @return array
     */
    private function fetchAll(\PDOStatement $st, array $params)
    {
        $st->execute($params);
        return $st->fetchAll();
    }
    
    /**
     * @param \PDOStatement $st
     * @param array $params
     * @return array
     */
    private function fetch(\PDOStatement $st, array $params, $class = null)
    {
        if ($class) {
            $st->setFetchMode(\PDO::FETCH_CLASS, $class);
        }
        $st->execute($params);
        return $st->fetch();
    }
    
}