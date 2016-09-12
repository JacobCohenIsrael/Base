<?php
namespace JCI\Base\Db;

use JCI\Base\Config\ArrayConfig;

class PdoConnection
{
    /**
     * @var \PDO
     */
    protected $pdo;
    
    /**
     * @var ArrayConfig
     */
    protected $statements;
    
    /**
     * TODO: add explanation....
     * @param \PDO $pdo
     */
    public function __construct($pdo = null)
    {
        if ($pdo) {
            $this->pdo = $pdo;
        }
        $this->statements = new ArrayConfig();
    }
    
    /**
     * @deprecated
     * @param string $statement
     * @return \PDOStatement
     */
    public function prepare($statement)
    {
        if (!$this->statements->has($statement)) {
            $this->statements->set($statement, $this->pdo->prepare($statement));
        }
        return $this->statements->get($statement);
    }
    
    
    /**
     * @param array $conf
     * @return PdoAdapter
     */
    static public function factory(array $conf)
    {
        $options = (isset($conf['options'])) ? $conf['options'] : [];
        return new PdoAdapter($conf['dsn'], $conf['username'], $conf['password'], $options);
    }
    
    // QUERY METHODS
    
    /**
     * @param string $sql
     * @return number
     */
    public function exec($sql)
    {
        return $this->pdo->exec($sql);
    }
    
    /**
     * Query exec method that return last insert id
     *
     * @param string $sql
     * @param array $params
     * @return nubmer
     */
    public function insert($sql, array $params = [])
    {
        $st = $this->getStatement($sql);
        $st->execute($params);
        return $this->pdo->lastInsertId();
    }
    
    /**
     * Query exec method
     *
     * @param string $sql
     * @param array $params
     * @return nubmer
     */
    public function query($sql, array $params = [])
    {
        $st = $this->getStatement($sql);
        return $st->execute($params);
    }
    
    // SELECT METHODS
    
    /**
     * Select query for one item
     *
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function selectOne($sql, array $params = [])
    {
        return $this->fetchOne($this->getStatement($sql), $params);
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
        return $this->fetchAll($this->getStatement($sql), $params);
    }
    
    /**
     * Select query for one item map into an object
     *
     * @param string $sql
     * @param object $obj
     * @param array $params
     * @return object
     */
    public function selectOneInto($sql, $obj, array $params = [])
    {
        $st = $this->getStatement($sql);
        $st->setFetchMode(\PDO::FETCH_INTO, $obj);
        return $this->fetchOne($st, $params);
    }
    
    /**
     * Select query for mutiple items map into an object
     *
     * @param string $sql
     * @param object $obj
     * @param array $params
     * @return array
     */
    public function selectAllInto($sql, $obj, array $params = [])
    {
        $st = $this->getStatement($sql);
        $st->setFetchMode(\PDO::FETCH_INTO, $obj);
        return $this->fetchAll($st, $params);
    }
    
    /**
     * Select query for one item map into an object by class name
     *
     * @param string $sql
     * @param string $class
     * @param array $params
     * @return object
     */
    public function selectOneMap($sql, $class, array $params = [])
    {
        $st = $this->getStatement($sql);
        $st->setFetchMode(\PDO::FETCH_CLASS, $class);
        return $this->fetchOne($st, $params);
    }
    
    /**
     * Select query for multiple items map into an object by class name
     *
     * @param string $sql
     * @param string $class
     * @param array $params
     * @return object
     */
    public function selectAllMap($sql, $class, array $params = [])
    {
        $st = $this->getStatement($sql);
        $st->setFetchMode(\PDO::FETCH_CLASS, $class);
        return $this->fetchAll($st, $params);
    }
    
    /**
     * @param string $sql
     * @return \PDOStatement
     */
    private function getStatement($sql)
    {
        return $this->pdo->prepare($sql);
    }
    
    /**
     * @param \PDOStatement $st
     * @param array $params
     * @return mixed
     */
    private function fetchOne(\PDOStatement $st, array $params)
    {
        $st->execute($params);
        return $st->fetch();
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
}