<?php
namespace App\Controller;

use App\Entity\Cat;
use App\Repository\CatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListsCatsController extends AbstractController
{
    public function __construct(
        #[Autowire('%cat_pictures_directory%')] private readonly string $catPicturesDirectory
    ) {}

    #[Route('/cats', name: 'app_list_cats')]
    #[Template('page/list_cats.html.twig')]
    public function listCats(CatRepository $catRepository): array
    {
        return [
            'cats' => $catRepository->findAll(),
        ];
    }

    #[Route('/cat/{id}/delete', name: 'app_cat_delete', methods: ['POST'])]
    public function deleteCat(
        Cat $cat,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        if ($this->isCsrfTokenValid('delete_cat_'.$cat->getId(), $request->request->get('_token'))) {
            if ($cat->getPictureFilename()) {
                $file = $this->catPicturesDirectory.'/'.$cat->getPictureFilename();
                if (file_exists($file)) {
                    unlink($file);
                }
            }

            $em->remove($cat);
            $em->flush();

            $this->addFlash('success', 'Cat deleted.');
        }

        return $this->redirectToRoute('app_list_cats');
    }
}
