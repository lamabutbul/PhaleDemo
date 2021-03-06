<?php

namespace PhaleDemo\User;

use \PhaleDemo\Database;


class UserService implements IUserService {

    /**
     * @var Database
     */
    private $db;

    /**
     * UserService constructor.
     * @param Database $db
     */
    public function __construct(Database $db) {
        $this->db = $db;
    }

    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function find($id) {
        // TODO: Implement find() method.
        $user = $this->db->select(['*'])->from('user')->where([['id', '=', $id], 'AND', ['deleted', '=', 0]])->exec()->first('\PhaleDemo\User\User');
        if (!$user) {
            throw new UserNotFoundException();
        }
        return $user;
    }

    /**
     * @return User[]
     */
    public function findAll() {
        // TODO: Implement findAll() method.
        return $this->db->select(['*'])->from('user')->where([['deleted', '=', 0]])->exec()->fetchAll('\PhaleDemo\User\User');
    }

}
