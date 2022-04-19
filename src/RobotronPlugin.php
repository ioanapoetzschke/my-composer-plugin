<?php

namespace My\Composer;

use Composer\Composer;
use Composer\DependencyResolver\Operation\InstallOperation;
use Composer\EventDispatcher\Event as BaseEvent;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\Factory;
use Composer\Installer;
use Composer\Installer\PackageEvent;
use Composer\Installer\PackageEvents;
use Composer\IO\IOInterface;
use Composer\Package\RootPackageInterface;
use Composer\Plugin\PluginEvents;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event as ScriptEvent;
use Composer\Script\ScriptEvents;

class RobotronPlugin implements PluginInterface, EventSubscriberInterface
{
    /**
     * Priority that plugin uses to register callbacks.
     */
    private const CALLBACK_PRIORITY = 6000;

    /**
     * Offical package name
     */
    public const PACKAGE_NAME = 'ioanapoetzschke/my-composer-plugin';


    /**
     * @var Composer $composer
     */
    protected $composer;

    /**
     * @var IOInterface $io
     */
    protected $io;


    /**
     * {@inheritdoc}
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }

    /**
     * {@inheritdoc}
     */
    public function deactivate(Composer $composer, IOInterface $io)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function uninstall(Composer $composer, IOInterface $io)
    {
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            PluginEvents::INIT =>
                array('onInit', self::CALLBACK_PRIORITY),
            PackageEvents::POST_PACKAGE_INSTALL =>
                array('onPostPackageInstall', self::CALLBACK_PRIORITY),
            ScriptEvents::POST_INSTALL_CMD =>
                array('onPostInstallOrUpdate', self::CALLBACK_PRIORITY),
            ScriptEvents::POST_UPDATE_CMD =>
                array('onPostInstallOrUpdate', self::CALLBACK_PRIORITY),
            ScriptEvents::PRE_AUTOLOAD_DUMP =>
                array('onInstallUpdateOrDump', self::CALLBACK_PRIORITY),
            ScriptEvents::PRE_INSTALL_CMD =>
                array('onInstallUpdateOrDump', self::CALLBACK_PRIORITY),
            ScriptEvents::PRE_UPDATE_CMD =>
                array('onInstallUpdateOrDump', self::CALLBACK_PRIORITY),
        );
    }

    /**
     * Handle an event callback for initialization.
     *
     * @param \Composer\EventDispatcher\Event $event
     */
    public function onInit(BaseEvent $event)
    {
        $file = new JsonFile("C:/xampp_8.1.4-0_x64/htdocs/Webpages/php7.2_composer.json");
        $json = $file->read();
        file_put_contents("C:/xampp_8.1.4-0_x64/htdocs/Webpages/submodule/data.json", $json);
        $this->io->write('<info>Congratulation , you are using at least PHP Version 7.4 :)</info>');
    }

    /**
     * Handle an event callback for an install, update or dump command
     *
     * @param ScriptEvent $event
     */
    public function onInstallUpdateOrDump(ScriptEvent $event)
    {
        $file = new JsonFile("C:/xampp_8.1.4-0_x64/htdocs/Webpages/php7.2_composer.json");
        $json = $file->read();
        file_put_contents("C:/xampp_8.1.4-0_x64/htdocs/Webpages/submodule/data.json", $json);
        $this->io->write('<info>Congratulation , you are using at least PHP Version 7.4 :)</info>');
    }

    /**
     * Handle an event callback following installation of a new package by
     * checking to see if the package that was installed was our plugin.
     *
     * @param PackageEvent $event
     */
    public function onPostPackageInstall(PackageEvent $event)
    {
        $op = $event->getOperation();
        if ($op instanceof InstallOperation) {
            $package = $op->getPackage()->getName();
            if ($package === self::PACKAGE_NAME) {
                $this->io->write('<info> onPostPackageInstall </info>');
            }
        }
    }

    /**
     * Handle an event callback following an install or update command. If our
     * plugin was installed during the run then trigger an update command to
     * process any merge-patterns in the current config.
     *
     * @param ScriptEvent $event
     */
    public function onPostInstallOrUpdate(ScriptEvent $event)
    {
        $this->io->write('<info> onPostInstallOrUpdate </info>');
    }
}

