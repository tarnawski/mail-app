<?php

namespace ApiBundle\Controller;

use ApiBundle\HttpFoundation\CsvResponse;
use ApiBundle\HttpFoundation\EmlResponse;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializationContext;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApiController
 * @package ApiBundle\Controller
 */
abstract class BaseController extends FOSRestController
{
    protected function getFormErrorsAsArray(Form $form)
    {
        $errors = array();
        foreach ($form->getErrors() as $key => $error) {
            $errors[$key] = $error->getMessage();
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $key = $child->getName();
                $errors[$key] = $this->getFormErrorsAsArray($child);
            }
        }

        return $errors;
    }

    /**
     * @param array $data The response data
     * @param int $status The status code to use for the Response
     * @param array $headers Array of extra headers to add
     * @param array $options Options to pass to CSV file
     *
     * @return CsvResponse
     */
    public function csv(array $data = [], $status = 200, $headers = [], array $options = [])
    {
        return new CsvResponse($data, $status, $headers, $options);
    }

    /**
     * @param $email
     *
     * @return EmlResponse
     */
    public function eml($email)
    {
        return new EmlResponse($email);
    }

    /**
     * @param array $data
     * @param int $code
     * @return mixed
     */
    protected function error($data = array(), $code = Response::HTTP_BAD_REQUEST)
    {
        $view = $this->view()
            ->setStatusCode($code)
            ->setData($data);

        return $this->handleView($view);
    }

    /**
     * @param $data
     * @param $templateVar
     * @param int $code
     * @param array $serializationGroups
     * @return Response
     */
    protected function success($data, $templateVar, $code = Response::HTTP_OK, array $serializationGroups = array('Default'))
    {
        $view = $this->view()
            ->setTemplateVar($templateVar)
            ->setStatusCode($code)
            ->setData($data)
            ->setSerializationContext(SerializationContext::create()->setGroups($serializationGroups));

        return $this->handleView($view);
    }

    /**
     * @param array $data
     * @return mixed
     */
    protected function message($data = array())
    {
        $view = $this->view()
            ->setData($data);

        return $this->handleView($view);
    }
    
    /**
     * @param $entityClass
     * @return mixed
     */
    public function getRepository($entityClass)
    {
        return $this->getDoctrine()->getManager()->getRepository($entityClass);
    }
}
