<?php

/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 * 
 * @package    Zend_Cache
 * @copyright  Copyright (c) 2006 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
 

/** 
 * @package    Zend_Cache
 * @copyright  Copyright (c) 2006 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
abstract class Zend_Cache 
{
    
    /**
     * Available frontends
     * 
     * @var array $availableFrontends array of frontend name (string)
     */
    static public $availableFrontends = array('Core', 'Output', 'Class', 'File', 'Function', 'Page');
    
    /**
     * Available backends
     * 
     * @var array $availableBackends array of backends name (string)
     */
    static public $availableBackends = array('File', 'Sqlite', 'Memcached', 'APC');
    
    /**
     * Consts for clean() method
     */
    const CLEANING_MODE_ALL              = 'all';
    const CLEANING_MODE_OLD	             = 'old';
    const CLEANING_MODE_MATCHING_TAG	 = 'matchingTag';
    const CLEANING_MODE_NOT_MATCHING_TAG = 'notMatchingTag';
     
    /**
     * Factory
     * 
     * @param string $frontend frontend name
     * @param string $backend backend name
     * @param array $frontendOptions associative array of options for the corresponding frontend constructor
     * @param array $backendOptions associative array of options for the corresponding backend constructor
     */
    static public function factory($frontend, $backend, $frontendOptions = array(), $backendOptions = array())
    {
        
        // because lowercase will fail
        $frontend = @ucfirst($frontend);
        $backend = @ucfirst($backend);
        
        if (!in_array($frontend, Zend_Cache::$availableFrontends)) {
            Zend_Cache::throwException("Incorrect frontend ($frontend)");
        }
        if (!in_array($backend, Zend_Cache::$availableBackends)) {
            Zend_Cache::throwException("Incorrect backend ($backend)");
        }
        
        // For perfs reasons, with frontend == 'Core', we can interact with the Core itself
        $frontendClass = 'Zend_Cache_' . ($frontend != 'Core' ? 'Frontend_' : '') . $frontend;
        
        $backendClass = 'Zend_Cache_Backend_' . $backend;
        
        // For perfs reasons, we do not use the Zend::loadClass() method
        // (security controls are explicit)
        require_once(str_replace('_', DIRECTORY_SEPARATOR, $frontendClass) . '.php');
        require_once(str_replace('_', DIRECTORY_SEPARATOR, $backendClass) . '.php');
        
        $frontendObject = new $frontendClass($frontendOptions);
        $backendObject = new $backendClass($backendOptions);
        $frontendObject->setBackend($backendObject);
        return $frontendObject;
        
    }     
    
    /**
     * Throw an exception
     * 
     * Note : for perf reasons, the "load" of Zend/Cache/Exception is dynamic
     */
    static public function throwException($msg)
    {
        // For perfs reasons, we use this dynamic inclusion
        require_once('Zend/Cache/Exception.php');
        throw new Zend_Cache_Exception($msg);
    }
    
}
