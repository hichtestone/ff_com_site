<?php

namespace App\Controller\Admin;

use App\Entity\Landing;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class LandingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Landing::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
			TextField::new('titlePage', 'Titre de la page'),
            TextEditorField::new('content', 'Contenu de la page')->setFormType(CKEditorType::class),
            //~ TextEditorField::new('keyword', 'Keywords google')->setFormType(TextareaType::class),
            //~ TextEditorField::new('description', 'Description google')->setFormType(TextareaType::class),
            TextareaField::new('keyword', 'Keywords google'),
            TextareaField::new('description', 'Description google'),
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
          ->setPageTitle('index', 'Liste des pages')
          ->setPageTitle('new', fn () => 'Ajouter une page')
		;
	}
}
