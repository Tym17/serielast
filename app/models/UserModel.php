<?php

class UserModel extends SqliteHandle
{
    function __construct()
    {
        parent::__construct(DB_PATH);
    }

    function getUserNames()
    {
        // Prepairing and executing query
        $query = str_replace('\n', "", file_get_contents(ROOT . DS . 'db' . DS . 'users' . DS . 'userList.sql'));
        $result = $this->query($query);
        if (!$result)
            return array();

        $retArray = $this->arrayify($result);
        $result->finalize();
        return $retArray;
    }

    function addUser($name, $pass)
    {
        // Escaping
        $name = $this->es($name);
        $pass = $this->es($pass);

        // Prepairing and executing query
        $stm = str_replace('\n', "", file_get_contents(ROOT . DS . 'db' . DS . 'users' . DS . 'addUser.sql'));
        $stm = str_replace(":name", $name, $stm);
        $stm = str_replace(":pass", $pass, $stm);

        $ret = $this->query($stm);
        if (!$ret)
          return false;

        $ret->finalize();
        return $ret;
    }

    function getPassFromId($id)
    {
        // Escaping
        $id = $this->es($id);

        // Prepairing and executing query
        $query = str_replace('\n', "", file_get_contents(ROOT . DS . 'db' . DS . 'users' . DS . 'passFromId.sql'));
        $query = str_replace(":id", $id, $query);
        $result = $this->query($query);
        if (!$result)
            return "";
        $ret = $result->fetchArray(SQLITE3_ASSOC);
        $result->finalize();
        return $ret['pass'];
    }
}
