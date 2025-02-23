<?php

use function Sabre\HTTP\decodePath;
use Sabre\DAV\Exception\BadRequest;

/**
 * Class ilWebDAVRequestHandler
 *
 * This class handles the WebDAV requests on webdav.php. It sets up the sabreDAV server with its necessary plugins.
 *
 * @author Raphael Heer <raphael.heer@hslu.ch>
 * $Id$
 */
class ilWebDAVRequestHandler
{
    private static $instance;

    public static function getInstance()
    {
        return self::$instance ? self::$instance : self::$instance = new ilWebDAVRequestHandler();
    }

    /**
     * For the case there might be more to handle as just running the server. So we won't make any breaking changes
     *
     * @throws \Sabre\DAV\Exception
     */
    public function handleRequest()
    {
        $this->runWebDAVServer();
    }

    /**
     * Creates and runs SabreDAV Server
     *
     * @throws \Sabre\DAV\Exception
     */
    protected function runWebDAVServer()
    {
        $server = new Sabre\DAV\Server($this->getRootDir());
        $this->setPlugins($server);
        $server->start();
    }


    /**
     * Set server plugins
     */
    protected function setPlugins($server)
    {
        global $DIC;

        // Set authentication plugin
        $webdav_auth = new ilWebDAVAuthentication();
        $cal = new Sabre\DAV\Auth\Backend\BasicCallBack(array($webdav_auth, 'authenticate'));
        $plugin = new Sabre\DAV\Auth\Plugin($cal);
        $server->addPlugin($plugin);

        // Set Lock Plugin
        $db_manager = new ilWebDAVDBManager($DIC->database());
        $lock_backend = new ilWebDAVLockBackend($db_manager);
        $lock_plugin = new Sabre\DAV\Locks\Plugin($lock_backend);
        $server->addPlugin($lock_plugin);

        /* Set Browser Plugin
         * This plugin is used to redirect GET-Requests from browsers on collections to the mount instruction page */
        $browser_plugin = new ilWebDAVSabreBrowserPlugin($DIC->ctrl());
        $server->addPlugin($browser_plugin);
    }

    /**
     * Return the first object to mount on WebDAV
     *
     * @return ilMountPointDAV
     */
    protected function getRootDir()
    {
        global $DIC;

        $repo_helper = new ilWebDAVRepositoryHelper($DIC->access(), $DIC->repositoryTree());
        $dav_helper = new ilWebDAVObjDAVHelper($repo_helper);
        return new ilMountPointDAV($repo_helper, $dav_helper);
    }
}
