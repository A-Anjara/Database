<?php 
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController{
    #[Route('/',name:'access')]
    function acces(Request $request,SessionInterface $session){
        if($request->isMethod("POST")){
            $password = $request->request->get('password');
            if($password == 'BSPAYV2!'){
                
                $session->set('access',true);
                return $this->redirectToRoute('app_database');
            }
        }
        return $this->render('access/index.html.twig');
    }

    #[Route('/logout',name:'logout')]
    function logout(SessionInterface $session){
        $session->clear();
        return $this->redirectToRoute('access');

    }
}

?>