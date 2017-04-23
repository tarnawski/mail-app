<?php

namespace ApiBundle\Controller;

use ApiBundle\Form\Type\RegisterType;
use ApiBundle\Form\Type\SubscriberType;
use ApiBundle\Model\Register;
use MailAppBundle\Entity\Subscriber;
use MailAppBundle\Entity\User;
use MailAppBundle\Model\UserFactory;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class SubscriberController
 */
class SubscriberController extends BaseController
{

    /**
     * @ApiDoc(
     *  description="Return subscribers belong to user",
     * )
     * @return Response
     */
    public function indexAction()
    {
        /** @var User $user */
        $user = $this->getUser();
        $subscribers = $user->getSubscribers();

        return $this->success($subscribers, 'subscriber', Response::HTTP_OK, [
            'SUBSCRIBER_DETAILS',
            'ATTRIBUTE_DETAILS'
        ]);
    }

    /**
     * @ApiDoc(
     *  description="Create new subscribers",
     *  parameters={
     *      {"name"="name", "dataType"="string", "required"=true, "description"="Name of notification"},
     *      {"name"="description", "dataType"="string", "required"=true, "description"="Short description of notification"},
     *      {"name"="latitude", "dataType"="string", "required"=true, "description"="Position od notify issue"},
     *      {"name"="longitude", "dataType"="string", "required"=true, "description"="Position od notify issue"},
     *      {"name"="category", "dataType"="integer", "required"=true, "description"="Category ID"}
     *  })
     * )
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(SubscriberType::class);
        $submittedData = json_decode($request->getContent(), true);
        $form->submit($submittedData);

        if (!$form->isValid()) {
            return $this->error($this->getFormErrorsAsArray($form));
        }
        /** @var Subscriber $subscriber */
        $subscriber = $form->getData();
        $subscriber->setCreatedAt(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($subscriber);
        $em->flush();

        return $this->success($subscriber, 'subscriber', Response::HTTP_CREATED, [
            'SUBSCRIBER_DETAILS',
            'ATTRIBUTE_DETAILS'
        ]);
    }

    /**
     * @ApiDoc(
     *  description="Delete subscriber"
     *)
     * @param Subscriber $subscriber
     * @return Response
     */
    public function deleteAction(Subscriber $subscriber)
    {
        $this->denyAccessUnlessGranted('access', $subscriber);

        $em = $this->getDoctrine()->getManager();
        $em->remove($subscriber);
        $em->flush();

        return $this->success(array('status' => 'Removed', 'message' => 'Subscriber properly removed'), 'subscriber');
    }
}
