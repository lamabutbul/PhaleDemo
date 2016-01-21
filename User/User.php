<?php

namespace PhaleDemo\User;


class User {

    public function __set($key, $val) {
        switch ($key) {
            case 'id':
            case 'deleted':
                $this->{$key} = intval($val);
                break;
            default:
                $this->{$key} = $val;
        }
    }
}
