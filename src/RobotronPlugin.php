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
     * Offical package name
     */
    public const PACKAGE_NAME = 'ioanapoetzschke/my-composer-plugin';
    
     /**
     * directory name
     */
    public const DIR = 'ioanapoetzschke/my-composer-plugin';
    
    /**
     * path of composer.json files
     */
    public const PATH = 'C:/xampp_8.1.4-0_x64/htdocs/Webpages/';
    
    /**
     * composer.json file name that uses php version greater than 7.4
     */
    public const PHP_8_COMPOSER_JSON_FILE = 'php_8_1_composer.json';
    
     /**
     * composer.json file name that uses php version lower than 7.4
     */
    public const PHP_7_COMPOSER_JSON_FILE = 'php_7_2_composer.json';


    /**
     * Priority that plugin uses to register callbacks.
     */
    private const CALLBACK_PRIORITY = 50000;

    /**
     * @var Composer $composer
     */
    protected $composer;

    /**
     * @var Logger $logger
     */
    protected $logger;

    /**
     * {@inheritdoc}
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->logger = new Logger('robotron-plugin', $io);
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
        $this->logger->info(
            " test onInit"
        );
    }

    /**
     * Handle an event callback for an install, update or dump command by
     * checking for "merge-plugin" in the "extra" data and merging package
     * contents if found.
     *
     * @param ScriptEvent $event
     */
    public function onInstallUpdateOrDump(ScriptEvent $event)
    {
        $this->logger->info(
            " test onInstallUpdateOrDump"
        );
    }


    public function onPostPackageInstall(PackageEvent $event)
    {
        $op = $event->getOperation();
        if ($op instanceof InstallOperation) {
            $package = $op->getPackage()->getName();
            if ($package === self::PACKAGE_NAME) {
                $this->logger->info('robotron-plugin installed');
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
        $this->logger->log("\n".'<info> robotron-plugin Running composer update . Call robotronPluiginMethod</info>');
        $this->robotronPluginMethod();
    }
    
     /**
     * @param Event $event
     */
    public function robotronPluginMethod()
    {
        $file = null;
        
        if(PHP_VERSION_ID > 70400){
            $file = file_get_contents(self::PATH.self::PHP_8_COMPOSER_JSON_FILE);
            $this->logger->log('<info>Congratulation , you are using at least PHP Version 7.4 :) . PHP Version : '.PHP_VERSION_ID.'</info>');
        } else {
            $file = file_get_contents(self::PATH.self::PHP_7_COMPOSER_JSON_FILE);
            $this->logger->log('<info> you are using at an old version of PHP '.PHP_VERSION_ID.'</info>');
        }
        file_put_contents(self::PATH."/submodule/composer.json", $file);
        $this->logger->log('<info> composer.json file was added to submodule directory </info>');
    }
}

