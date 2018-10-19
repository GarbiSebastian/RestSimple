<?php

namespace App\Controller;

use App\Converter\ContactoJsonConverter;
use App\Entity\Contacto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;

class ContactoRestController extends AbstractController
{
    public static function getSubscribedServices() {
        $services = parent::getSubscribedServices();
//        $services["logger"] = \Symfony\Component\HttpKernel\Log\Logger::class;
        $services["kernel"] = KernelInterface::class;
        return $services;
    }

    public function indexAction()
    {
        $contactos = $this->getDoctrine()->getRepository(Contacto::class)->findAll();
        $converter = new ContactoJsonConverter();
        return $this->json(array_map(function(Contacto $ontacto) use ($converter){
                return $converter->contactoToArray($ontacto);
            }, $contactos));
    }
    
    public function newAction(Request $request) {
        $converter = new ContactoJsonConverter();
        $contacto = $converter->jsonToContacto($request->getContent());
        $em = $this->getDoctrine()->getManager();
        $em->persist($contacto);
        $em->flush();
        return $this->json($converter->contactoToArray($contacto));
    }
    
    public function showAction($contacto_id, Request $request) {
        $contacto = $this->getDoctrine()->getRepository(Contacto::class)->find($contacto_id);
        if($contacto){
            $converter = new ContactoJsonConverter();
            return $this->json($converter->contactoToArray($contacto));
        }else{
            return $this->json(["message"=>"Contacto inexistente"],500);
        }
    }
    
    public function editAction($contacto_id, Request $request) {
        $contacto = $this->getDoctrine()->getRepository(Contacto::class)->find($contacto_id);
        if($contacto){
            $converter = new ContactoJsonConverter();
            $converter->jsonUpdateContacto($contacto, $request->getContent());
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->json($converter->contactoToArray($contacto));
        }else{
            return $this->json(["message"=>"Contacto inexistente"],500);
        }
    }
    
    public function deleteAction($contacto_id, Request $request) {
        $contacto = $this->getDoctrine()->getRepository(Contacto::class)->find($contacto_id);
        if($contacto){
            $converter = new ContactoJsonConverter();
            $em = $this->getDoctrine()->getManager();
            $em->remove($contacto);
            $em->flush();
            return $this->json($converter->contactoToArray($contacto));
        }else{
            return $this->json(["message"=>"Contacto inexistente"],500);
        }
    }

}
