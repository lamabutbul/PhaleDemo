<?php

namespace PhaleDemo;

use \Pdo;
use \PDOStatement;


class Database {

    /**
     * @var PDO
     */
    private $db;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $database;

    /**
     * @var int
     */
    private $port = 3306;

    /**
     * @var string
     */
    private $charset;

    /**
     * Database constructor.
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $database
     * @param int $port
     * @param string $charset
     */
    public function __construct($host, $username, $password, $database, $port, $charset) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->port = $port;
        $this->charset = $charset;
        $this->db = new PDO(sprintf('mysql:host=%s;port=%s;dbname=%s;charset=UTF8', $this->host, $this->port, $this->database), $this->username, $this->password, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @param string $sql
     * @return array
     */
    public function query($sql) {
        return $this->db->query($sql)->fetchAll();
    }

    /**
     * @param string $sql
     * @return PDOStatement
     */
    public function prepare($sql) {
        return $this->db->prepare($sql);
    }

    /**
     * @param array $fields
     * @return SelectQuery
     */
    public function select(array $fields) {
        return new SelectQuery($this, $fields);
    }

}


class SelectQuery {

    /**
     * @var Database
     */
    private $db;

    private $fields;
    private $table;
    private $conditions;
    private $limit;

    /**
     * @var PDOStatement
     */
    private $query;
    private $args;

    /**
     * SelectQuery constructor.
     * @param Database $db
     * @param $fields
     */
    public function __construct(Database $db, $fields) {
        $this->db = $db;
        $this->fields = $fields;
    }

    public function from($table) {
        $this->table = $table;
        return $this;
    }

    public function where($conditions) {
        $this->conditions = $conditions;
        return $this;
    }

    public function limit($limit) {
        $this->limit = $limit;
        return $this;
    }

    public function prepare() {
        $sql = ['SELECT'];

        $fields = [];
        foreach ($this->fields as $key => $field) {
            if (is_int($key)) {
                $fields[] = $this->escapeName($field);
            }
            else {
                $fields[] = $this->escapeName($key) . ' AS ' . $this->escapeName($field);
            }
        }

        $sql[] = implode(', ', $fields);
        $sql[] = 'FROM';
        $sql[] = $this->escapeName($this->table);

        $args = [];

        if ($this->conditions) {
            $sql[] = 'WHERE';
            foreach ($this->conditions as $condition) {
                if (is_string($condition)) {
                    $sql[] = $condition;
                }
                elseif (is_array($condition)) {
                    $argName = ':' . $condition[0];

                    $sql[] = '(';
                    $sql[] = $this->escapeName($condition[0]);
                    $sql[] = $condition[1];
                    $sql[] = $argName;
                    $sql[] = ')';

                    $args[$argName] = $condition[2];
                }
            }
        }

        if ($this->limit) {
            $sql[] = 'LIMIT';
            $sql[] = $this->limit;
        }

        $this->query = $this->db->prepare(implode(' ', $sql) . ';');
        $this->args = $args;

        return $this;
    }

    public function exec() {
        if (!$this->query) {
            $this->prepare();
        }
        $this->query->execute($this->args);
        return $this;
    }

    public function first($class = null) {
        return $this->query->fetchObject($class);
    }

    public function fetchAll($class = null) {
        return $this->query->fetchAll(PDO::FETCH_CLASS, $class);
    }

    public function getQuery() {
        return $this->query;
    }

    private function escapeName($name) {
        if ($name === '*') {
            return $name;
        }
        return '`' . $name . '`';
    }
}


//class Field {
//    public function __construct($required=false) {
//
//    }
//}
//
//
//class StringField {
//
//}
//
//
//class Schema {
//
//    public $table;
//
//    public $id;
//    public $lastName;
//    public $firstName;
//
//    public function __construct() {
//        $this->id = new Field();
//        $this->lastName = new StringField($required=true);
//        $this->firstName = new StringField($required=true);
//    }
//
//}
//
//
//class Record {
//
//    /**
//     * @var DB
//     */
//    static public $db;
//
//    /**
//     * @var Schema[]
//     */
//    static private $schema;
//
//    static public function schema($class, $schema = null) {
//        if ($schema) {
//            self::$schema[$class] = $schema;
//        }
//        else {
//            return self::$schema[$class];
//        }
//    }
//
//    static protected function find($class, $id) {
//        $row = self::$db->select(['*'])->from(self::schema($class)->table)->where([['id', '=', $id], 'AND', ['deleted', '=', 0]])->limit(1)->exec()->first();
//        return self::toRecord($row);
//    }
//
//    static private function findAll($class, array $params = null) {
//        return self::$db->select(['*'])->from(self::schema($class)->table)->where([['deleted', '=', 0]])->limit(10)->exec()->fetchAll();
//    }
//
//    static private function toRecord($row) {
//        return $row;
//    }
//
//    private $attributes = [];
//
//    public function __get($name) {
//        if (isset($this->attributes[$name])) {
//            return $this->attributes[$name];
//        }
//        throw new Exception('Invalid attribute.');
//    }
//
//    public function __set($name, $value) {
//        if (isset($this->attributes[$name])) {
//            $this->attributes[$name] = $value;
//        }
//        else {
//            throw new Exception('Invalid attribute');
//        }
//    }
//}

//$db = new DB('localhost', 'clinic71_mohs', 'mad2Le37', 'clinic71_mohs');
//$db->connect();
//Record::$db = $db;

//$query = $db->select(['*'])->from('tblPatients')->where([['id', '=', 1000], 'AND', ['deleted', '=', 0]])->limit(1)->prepare();
//var_dump($query->getQuery());
//var_dump($query->exec()->first());
//var_dump($query->exec()->fetchAll());
