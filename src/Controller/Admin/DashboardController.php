<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Landing;
use App\Entity\Contact;
use App\Entity\Project;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //~ return parent::index();
		$routeBuilder = $this->container->get(AdminUrlGenerator::class);
		$url = $routeBuilder->setController(UserCrudController::class)->generateUrl();
		return $this->redirect($url);
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            // ...

            // the first argument is the "template name", which is the same as the
            // Twig path but without the `@EasyAdmin/` prefix
            //~ ->overrideTemplate('label/null', 'admin/labels/my_null_label.html.twig')

            ->overrideTemplates([
                //~ 'crud/index' => 'admin/pages/index.html.twig',
                //~ 'crud/field/textarea' => 'admin/fields/dynamic_textarea.html.twig',
                //~ 'page/login' => 'admin/pages/login.html.twig',
            ])
        ;
    }
    
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Ff Com Site');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Pages', 'fas fa-newspaper', Landing::class);
        yield MenuItem::linkToCrud('Projets', 'fas fa-folder-open', Project::class);
        yield MenuItem::linkToCrud('Contact', 'fas fa-envelope', Contact::class);
    }
}
