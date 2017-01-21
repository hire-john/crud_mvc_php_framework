<?php

class authentication {

    public function authenticate() {
        
    }

    /**
     *
     * @param $auth_hash : unique md5 hash of username stored in user table for persistant use for site access. 
     * If this is present in session user has logged in.
     *       	 
     *       	
     */
    public function logout($auth_hash) {
        if (isset($_SESSION ['auth_hash'])) {
            unset($_SESSION ['auth_has']);
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * @param string $scope - either "public" or "private" store in routes db table and used with access control - NOT METHOD SCOPE.
     * @param int $id - db id of the attempted route       	
     */
    public function authorized($scope, $id) {
        if ($scope == "public") {
            return true;
        } else {
            if (isset($_SESSION ['auth_hash'])) {
                return $this->checkPermissions($id);
            } else {
                return false;
            }
        }
    }

    /**
     * 
     * @param  string $permissions  - common separated route ID's the user has access to
     * @param  int $id - db id of the attempted route 
     */
    private function checkPermissions($permissions, $id) {
        $match = false;
        $permissions = explode(",", $permissions);
        foreach ($permissions as $key => $value) {
            if ($value == $id) {
                $match = true;
            }
        }
        return $match;
    }

}