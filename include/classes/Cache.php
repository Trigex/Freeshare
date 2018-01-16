<?php

class Cache
{
    protected static $_enabled = false;
    protected static $_cache;

    static function init($lifetime = 7200)
    {
        global $config;
        
        self::$_enabled = $config['cache_enable'];
        
        if (self::$_enabled)
        {
            $dir = VSHARE_DIR . '/cache/';
            require 'Zend/Cache.php';
            
            $frontendOptions = array(
                'lifetime' => $lifetime,
                'automatic_serialization' => true
            );
            $backendOptions = array(
                'cache_dir' => $dir,
                'file_name_prefix' => 'thecache',
                'hashed_directory_level' => 2
            );
            self::$_cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
        }
    }

    static function getInstance()
    {
        
        if (self::$_enabled == false)
        {
            return false;
        }
        return self::$_cache;
    }

    static function load($keyName)
    {
        if (self::$_enabled == false)
        {
            return false;
        }
        return self::$_cache->load($keyName);
    }

    static function save($keyName, $dataToStore)
    {
        if (self::$_enabled == false)
        {
            return true;
        }
        
        return self::$_cache->save($dataToStore, $keyName);
    }

    static function clean()
    {
        if (self::$_enabled == false)
        {
            return;
        }
        self::$_cache->clean();
    }
}
