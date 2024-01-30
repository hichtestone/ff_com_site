<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Groups;
use Intervention\Image\ImageManagerStatic as Image;
use Intervention\Image\Constraint;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FileRepository")
 * @ORM\HasLifecycleCallbacks
 */
class File
{
    /**
     * Const size thumbnail
     */
    const THUMB_ARTICLE = ['970x649', '730x370', '133x127'];
    const THUMB_LANDING = ['945x263', '567x200'];

    /**
     * Const type folder
     */
    const TYPE_ARTICLE = 'articles';
    const TYPE_LANDING = 'landing';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     *
     * @Groups({"list", "detail"})
     */
    private $name;

    /**
     * @Assert\File(
     *     maxSize = "2M",
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png"},
     *     mimeTypesMessage = "Le fichier choisi ne correspond pas à un fichier valide",
     *     notFoundMessage = "Le fichier n'a pas été trouvé sur le disque",
     *     uploadErrorMessage = "Erreur dans l'upload du fichier"
     * )
     */
    private $file;

    /**
     * @var string
     * @ORM\Column(name="type", type="string", length=100)
     */
    private $type;

    private $tempFilename;

    /**
     * @var string
     */
    private $rootDir;

    /**
     * @param string $size
     *
     * @return string
     * @version 2.0
     * @copyright ©2MConseil 2020.
     * @author Geoffrey Bidi
     */
    public function getDisplay(string $size = 'original'):string
    {
        // Init root
        $path = $this->getUploadDir();

        // Get name and extension
        $nameAndExtension = explode('.', $this->getName());

        // Switch size
        switch($size){
            // Article
            case 'article':
                return $path . '970x649/' . $nameAndExtension[0] . '-970x649.' . $nameAndExtension[1];
                break;

            case 'article-list':
                return $path . '730x370/' . $nameAndExtension[0] . '-730x370.' . $nameAndExtension[1];
                break;

            case 'article-home':
                return $path . '133x127/' . $nameAndExtension[0] . '-133x127.' . $nameAndExtension[1];
                break;

            // Landing
            case 'landing-medium':
                return $path . '600x205/' . $nameAndExtension[0] . '-600x205.' . $nameAndExtension[1];
                break;

            // Default
            case 'original':
                return $path . '/' . $nameAndExtension[0] . '.' . $nameAndExtension[1];
                break;
        }
    }

    /**
     * Get file.
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;

        if (null !== $this->path)
        {
            $this->tempFilename = $this->name;
            $this->path         = null;
            $this->name         = null;
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null === $this->file)
            return;

        $name = sha1(uniqid(mt_rand(), true));
        $this->name = $name.'.'.$this->getFile()->guessExtension();
        $this->path = $this->getUploadRootDir();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        $folder = $this->getUploadDir();

        if (null === $this->file)
            return;

        if (null !== $this->tempFilename)
        {
            // Get old file
            $oldFile = $folder . $this->tempFilename;

            // Get name and extension
            $nameAndExtension = explode('.', $this->tempFilename);

            if (file_exists($oldFile))
            {
                // Delete
                @unlink($oldFile);

                // Delete in original folder
                @unlink($folder . 'original/' . $this->tempFilename);

                // Delete articles thumbs
                if ($this->getType() === 'articles')
                    foreach (self::THUMB_ARTICLE as $thumb)
                        @unlink($folder . $thumb . '/' . $nameAndExtension[0] . '-' . $thumb . '.' . $nameAndExtension[1]);

                // Delete landings thumbs
                if ($this->getType() === 'landing')
                    foreach (self::THUMB_LANDING as $thumb)
                        @unlink($folder . $thumb . '/' . $nameAndExtension[0] . '-' . $thumb . '.' . $nameAndExtension[1]);
            }
        }

        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->name
        );
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        $this->tempFilename = $this->getUploadRootDir().'/'.$this->name;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (file_exists($this->tempFilename))
            unlink($this->tempFilename);
    }

    public function getUploadDir()
    {
        return 'files/'.$this->getType().'/';
    }

    protected function getUploadRootDir(): string
    {
        return $this->rootDir.'/public/'.$this->getUploadDir();
    }

    public function setRootDir($rootDir): File
    {
        $this->rootDir = $rootDir;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return $this
     */
    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return File
     */
    public function setType(string $type): File
    {
        $this->type = $type;

        return $this;
    }
    
    /**
     * @param string filename
     */
     public function getFileDimensions()
     {
		$file = __DIR__ . '/../../public/' . $this->getUploadDir().$this->name;
		if( file_exists($file) )
		{
			Image::configure(['driver' => 'gd']);
			return ['width' => Image::make($file)->width(), 'height' => Image::make($file)->height()];
		}
		return false;
	 }

}
