<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Contacto;

class ContactoRestController extends AbstractController
{
    public static function getSubscribedServices() {
        $services = parent::getSubscribedServices();
//        $services["logger"] = \Symfony\Component\HttpKernel\Log\Logger::class;
        $services["kernel"] = \Symfony\Component\HttpKernel\KernelInterface::class;
        return $services;
    }

    public function indexAction()
    {
        $contactos = $this->getDoctrine()->getRepository(Contacto::class)->findAll();
        $converter = new \App\Converter\ContactoJsonConverter();
        return $this->json(array_map(function(Contacto $ontacto) use ($converter){
                return $converter->contactoToArray($ontacto);
            }, $contactos));
    }
    
    public function newAction(\Symfony\Component\HttpFoundation\Request $request) {
        $converter = new \App\Converter\ContactoJsonConverter();
        $contacto = $converter->jsonToContacto($request->getContent());
        $em = $this->getDoctrine()->getManager();
        $em->persist($contacto);
        $em->flush();
        return $this->json($converter->contactoToArray($contacto));
    }
    
    public function editAction($contacto_id, \Symfony\Component\HttpFoundation\Request $request) {
        $contacto = $this->getDoctrine()->getRepository(Contacto::class)->find($contacto_id);
        if($contacto){
            $converter = new \App\Converter\ContactoJsonConverter();
            $converter->jsonUpdateContacto($contacto, $request->getContent());
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->json($converter->contactoToArray($contacto));
        }else{
            return $this->json(["message"=>"Contacto inexistente"],500);
        }
    }
    
    public function deleteAction($contacto_id, \Symfony\Component\HttpFoundation\Request $request) {
        $contacto = $this->getDoctrine()->getRepository(Contacto::class)->find($contacto_id);
        if($contacto){
            $converter = new \App\Converter\ContactoJsonConverter();
            $em = $this->getDoctrine()->getManager();
            $em->remove($contacto);
            $em->flush();
            return $this->json($converter->contactoToArray($contacto));
        }else{
            return $this->json(["message"=>"Contacto inexistente"],500);
        }
    }

}
