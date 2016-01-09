<?php

interface IUserService {

    /**
     * @param int $id
     * @return User
     */
    public function find($id);

    /**
     * @return User[]
     */
    public function findAll();

}
