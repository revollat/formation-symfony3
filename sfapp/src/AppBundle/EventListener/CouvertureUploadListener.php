<?php 
namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use AppBundle\Entity\Livre;
use AppBundle\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\File;

class CouvertureUploadListener
{
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    private function uploadFile($entity)
    {
        // upload only works for Product entities
        if (!$entity instanceof Livre) {
            return;
        }

        $file = $entity->getCouverture();

        // only upload new files
        if (!$file instanceof UploadedFile) {
            return;
        }

        $fileName = $this->uploader->upload($file);
        $entity->setCouverture($fileName);
    }
    
    // public function postLoad(LifecycleEventArgs $args)
    // {
    //     $entity = $args->getEntity();

    //     if (!$entity instanceof Livre) {
    //         return;
    //     }

    //     if ($fileName = $entity->getCouverture()) {
    //         $entity->setCouverture(new File($this->uploader->getTargetDir().'/'.$fileName));
    //     }
    // }
    
}