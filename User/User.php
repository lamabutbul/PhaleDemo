<?php

namespace PhaleDemo\User;


class User {

    public function __set($key, $val) {
        switch ($key) {
            case 'id':
                $this->{$key} = intval($val);
                break;
            case 'deleted':
                $this->{$key} = boolval($val);
                break;
            default:
                $this->{$key} = $val;
        }
    }
}
