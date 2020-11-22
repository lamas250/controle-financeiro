<?php

namespace DB;

use \PDO;

// não pode instanciar, somente os filhos que estenderem ele.
abstract class Entity
{
    private $conn;
    protected $table;

    /**
     * @var PDO
     */
    public function __construct(\PDO $conn)
    {
        $this->conn = $conn;
    }

    public function findAll($fields = '*')
    {
        $sql = 'SELECT ' . $fields . ' FROM ' . $this->table;

		$get = $this->conn->query($sql);

		return $get->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id, $fields = '*')
    {
        return current($this->where(['id'=>$id],'',$fields));
    }

    public function where(array $conditions, $operator = ' AND ', $fields = '*')
    {
        $sql = 'SELECT ' . $fields . ' FROM ' . $this->table . ' WHERE ';

        $binds = array_keys($conditions);

        $where = null;
        foreach($binds as $v){
            if(is_null($where)){
                $where .= $v . ' = :' . $v;
            }else{
                $where .= $operator . $v . ' = :' . $v;
            }
        }
        // le operadores de atribuição
        $sql .= $where;

        $get = $this->bind($sql, $conditions);
        $get->execute();

        return $get->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $binds = array_keys($data);

        // INSERT INTO products(name, price, amount, description, slug,created_at, updated_at) VALUES(:name, :price, :amount, :description, :slug,NOW(),NOW())
        $sql = 'INSERT INTO ' . $this->table . '(' . implode(', ', $binds) . ',created_at, updated_at)' . 
            ' VALUES(:'  . implode(', :',$binds) . ',NOW(),NOW())';

        
        $insert = $this->bind($sql, $data);
        $insert->execute();
    }

    public function update($data)
    {
        if(!array_key_exists('id',$data)){
            throw new \Exception('É preciso informar um id valido para update.');
        }
        $sql = 'UPDATE ' . $this->table . ' SET ';

        $set = null;
        $binds = array_keys($data);

        foreach($binds as $v){
            if($v != 'id'){
                $set .= is_null($set) ? $v . ' = :' . $v :  ', ' . $v . ' = :' . $v;
            }
        }
        $sql .= $set . ', updated_at = NOW() WHERE id = :id';

        $update = $this->bind($sql, $data);

        return $update->execute();
    }

    public function delete(int $id)
    {
        $sql = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        $delete = $this->bind($sql, ['id' => $id]);

        return $delete->execute();
    }

    private function bind($sql, $data)
    {
        $bind = $this->conn->prepare($sql);

        foreach($data as $k => $v){
            gettype($v) == 'int' ? $bind->bindValue(':' . $k,$v,\PDO::PARAM_INT) : $bind->bindValue(':' . $k,$v,\PDO::PARAM_STR);
        }

        return $bind;
    }
}