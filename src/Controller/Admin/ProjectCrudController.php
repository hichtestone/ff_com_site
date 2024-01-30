<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Entity\User;

use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ProjectCrudController extends AbstractCrudController
{
    public function __construct(ManagerRegistry $registry)
    {
		$this->em = $registry->getManager();
    }

    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureFields(string $pageName): iterable
    {
		$userRepository = $this->em->getRepository(User::class);
        return [
			TextField::new('project_name', 'Titre du projet'),
			AssociationField::new('project_manager', 'Chef du projet')->setCrudController(UserCrudController::class),
													//~ ->setQueryBuilder(
														//~ $userRepository->createQueryBuilder('u')
															//~ ->where('entity.some_property = :some_value')
															//~ ->setParameter('some_value', '...')
															//~ ->orderBy('entity.some_property', 'ASC')
													//~ ),
			TextField::new('client_name', 'Client'),
			TextField::new('project_url', 'URL'),
            TextEditorField::new('description', 'Description du projet')->setFormType(CKEditorType::class),
        ];
    }
    
    public function configureCrud(Crud $crud): Crud
	{
	  return $crud
		  ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
		  ->overrideTemplates([
                //~ 'crud/index' => 'admin/pages/index.html.twig',
                //~ 'crud/field/textarea' => 'admin/fields/dynamic_textarea.html.twig',
                //~ 'page/login' => 'admin/pages/login.html.twig',
            ])
          ->setPageTitle('index', 'Liste des Projets')
          ->setPageTitle('new', fn () => 'Ajouter un projet')
		;
	}
}
