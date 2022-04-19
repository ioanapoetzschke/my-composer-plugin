<?php

namespace IoanaPoetzschke;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Plugin\PluginEvents;
use Composer\Plugin\PreFileDownloadEvent;

class RobotronPlugin implements PluginInterface, EventSubscriberInterface
{
    protected $composer;
    protected $io;

    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
    }

    public static function getSubscribedEvents()
    {
         return array(
                    PluginEvents::INIT => 'robotronPluginMethod'
                );
    }

     /**
     * @param Event $event
     */
    public function robotronPluginMethod(Event $event)
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
