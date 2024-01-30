<?php

namespace App\Controller\Admin;

use App\Entity\User;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class UserCrudController extends AbstractCrudController
{

	private $params;
	
	public function __construct(ParameterBagInterface $params)
	{
		$this->params = $params;
	}
 	
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
			TextField::new('firstname', 'Prénom'),
			TextField::new('lastname', 'Nom'),
			TextField::new('email', 'Email'),
			$pageName == 'index' ? ImageField::new('resume', 'CV')->setBasePath($this->params->get('uploads_cv'))->setTemplatePath('bundles/EasyAdminBundle/crud/field/cv_file.html.twig') : TextareaField::new('cvFile', 'CV')->setFormType(VichFileType::class)
			->setFormTypeOptions(['attr' => [
										'accept' => 'application/pdf'
									]
								]),
			//~ TextField::new('resume')->setTemplatePath('bundles/EasyAdminBundle/crud/field/cv_file.html.twig')->setBasePath($this->params->get('uploads_cv'))->onlyOnIndex(),
			$pageName == 'index' ? ImageField::new('profile_image', 'Photo')->setBasePath($this->params->get('uploads_image_profile')) : ImageField::new('imageFile', 'Photo')->setFormType(VichImageType::class),
            TextareaField::new('description', 'Cursus'),
        ];
    }

	public function configureCrud(Crud $crud): Crud
	{
		return $crud
				->setPageTitle('index', 'Liste des utilisateurs');
	}
    
    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
