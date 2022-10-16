<?php

namespace App\Controller\Api;

class AbstractController
{
    protected function buildForm(string $type, $data = null, array
                                        $options = []):FormInterface
    {
        $options = array_merge($options, array('csrf_protection' =>
            false));
        return $this->container->get('form.factory')->createNamed('',$type, $data, $options);
    }
}