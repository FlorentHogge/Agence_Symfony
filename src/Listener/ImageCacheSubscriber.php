<?php

namespace App\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageCacheSubscriber implements EventSubscriber{

    /**
     * @var CacheManager
     */
    private $cache;

    /**
     * @var UploaderHelper
     */
    private $helper;

    public function __construct(CacheManager $cache, UploaderHelper $helper){
        $this->cache = $cache;
        $this->helper = $helper;
    }

    public function getSubscribedEvents(){
        return [
            'preRemove',
            'preUpdate'
        ];
    }

    public function preRemove(LifecycleEventArgs $args){
        $entity = $args->getEntity();

        if(!$entity instanceof Property){
            return;
        }
        $this->cache->remove($this->helper->asset($entity), 'imageFile');
    }

    public function preUpdate(PreUpdateEventArgs $args){

        $entity = $args->getEntity();

        if(!$entity instanceof Property){
            return;
        }

        if($entity->getImageFile() instanceof UploadedFile){
            $this->cache->remove($this->helper->asset($entity), 'imageFile');
        }
    }
}

?>