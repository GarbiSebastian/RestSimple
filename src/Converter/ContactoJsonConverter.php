<?php

namespace App\Converter;

/**
 * Description of ContactoJsonConverter
 *
 * @author sebastian
 */
class ContactoJsonConverter {
    public function contactToArray(\App\Entity\Contacto $contacto) {
        return [
            'id' => $contacto->getId(),
            'nombre' => $contacto->getNombre(),
            'apellido' => $contacto->getApellido(),
            'telefono' => $contacto->getTelefono(),
            'email' => $contacto->getEmail(),
            'createdAt' => $contacto->getCreatedAt()
        ];
    }
    
    public function jsonToContacto(string $json) {
        $contacto = new \App\Entity\Contacto();
        $contacto->setCreatedAt(new \DateTimeImmutable());
        $this->jsonUpdateContacto($contacto, $json);
        return $contacto;
    }
    
    public function jsonUpdateContacto(\App\Entity\Contacto $contacto,string $json) {
        $data = json_decode($json,true);
        $contacto->setNombre($data["nombre"])
                ->setApellido($data["apellido"])
                ->setTelefono($data["telefono"])
                ->setEmail($data["email"]);
        return $contacto;
    }
}