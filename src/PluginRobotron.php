<?php

namespace Robotron;


use Composer\Composer;
use Composer\EventDispatcher\Event;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginEvents;
use Composer\Plugin\PluginInterface;
use Symfony\Component\Console\Helper\Table;

class PluginRobotron implements PluginInterface, EventSubscriberInterface
{
    /**
     * @var Composer
     */
    protected $composer;

    /**
     * @var IOInterface
     */
    protected $io;

    /**
     * @param Composer $composer
     * @param IOInterface $io
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            PluginEvents::INIT => 'pluginRobotronMethod'
        );
    }

    /**
     * @param Event $event
     */
    public function pluginRobotronMethod(Event $event)
    {
        if(PHP_VERSION_ID > 70400){
            $this->io->write(PHP_EOL.'<options=bold>========= Robotron plugin =========</>');
            $this->io->write('<info>Congratulation , you are using at least PHP Version 7.4 :)</info>');
            $this->io->write('<options=bold>===============================</>'.PHP_EOL);
        } else {
            $this->io->write(PHP_EOL.'<options=bold>========= Robotron plugin =========</>');
            $this->io->write('<info> You have the upgrade your PHP Version !!! </info>');
            $this->io->write('<options=bold>===============================</>'.PHP_EOL);
        }

    }
}
