<?php

namespace PhaleDemo\User;


interface IUserService {

    /**
     * @param int $id
     * @return User
     */
    public function find($id);

    /**
     * @return User[]
     * @throws UserNotFoundException
     */
    public function findAll();

}
