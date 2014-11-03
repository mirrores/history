<?php

class Candy_ACL
{
    protected static $_acl;
    public  $_resource = array();
    public $_role = array();

    public static function instance()
    {
        if( ! self::$_acl){
            self::$_acl = new Candy_ACL();
        }
        return self::$_acl;
    }

    public function addResource($name, $uri)
    {
        if( ! isset($this->_resource[$name])){
            $this->_resource[$name] = array();
        }

        if(is_string($uri) && ! in_array($uri, $this->_resource[$name])){
            $this->_resource[$name][] = $uri;
        }

        if(is_array($uri)){
            $this->_resource[$name] += $uri;
            $this->_resource[$name] = array_unique($this->_resource[$name]);
        }
    }

    public function addRole($name, $resourceName)
    {
        if( ! isset($this->_role[$name])){
            $this->_role[$name] = array();
        }

        if( ! in_array($resourceName, $this->_role[$name])){
            $this->_role[$name][] = $resourceName;
        }
    }

    /**
     * 
     * @param <type> $role
     * @param <type> $resource
     * @return <type> 
     */
    public function isAllowed($role, $resource)
    {
        $exist_res = false;
        $allow = false;

        foreach($this->_resource as $name => $res){
            if(in_array($resource, $res)){
                $exist_res = true;
                $allow = in_array($name, $this->_role[$role]);
            }
        }
        if($exist_res == false) $allow = true;

        return $allow;
    }
}