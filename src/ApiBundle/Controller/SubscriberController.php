<?php

namespace ApiBundle\Controller;

use ApiBundle\Form\Type\SubscriberType;
use MailAppBundle\Entity\Subscriber;
use MailAppBundle\Entity\User;
use MailAppBundle\Repository\SubscriberRepository;
use NotificationDomain\Command\NotifyViaEmailCommand;
use NotificationDomain\ServiceBus\CommandBus;
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
        /** @var SubscriberRepository $subscribeRepository */
        $subscribeRepository = $this->getRepository(Subscriber::class);
        $subscribers = $subscribeRepository->getSubscriberByUser($user);

        return $this->success($subscribers, 'subscriber', Response::HTTP_OK, [
            'SUBSCRIBER_DETAILS',
            'SUBSCRIBER_GROUP_BASIC',
            'ATTRIBUTE_DETAILS'
        ]);
    }

    /**
     * @ApiDoc(
     *  description="Create new subscriber",
     *  parameters={
     *      {"name"="email", "dataType"="string", "required"=true, "description"="Subscriber email address"},
     *      {"name"="group", "dataType"="string", "required"=true, "description"="Group key"},
     *      {"name"="attributes", "dataType"="string", "required"=false, "description"="Unlimited additional attributes consisting of name and value pairs."}
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
        $subscriber->setActive(true);
        $subscriber->setCreatedAt(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($subscriber);
        $em->flush();

        $notificationViaEmailCommand = new NotifyViaEmailCommand(
       'Good news',
    'New subscriber in Your group',
            $subscriber->getSubscriberGroup()->getUser()->getEmail()
        );

        /** @var CommandBus $commandBus */
        $commandBus = $this->get('notification.command_bus');
        $commandBus->handle($notificationViaEmailCommand);

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
