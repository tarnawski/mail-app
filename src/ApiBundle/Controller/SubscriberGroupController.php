<?php

namespace ApiBundle\Controller;

use ApiBundle\Form\Type\SubscriberGroupType;
use MailAppBundle\Entity\SubscriberGroup;
use MailAppBundle\Entity\User;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class SubscriberGroupController
 */
class SubscriberGroupController extends BaseController
{

    /**
     * @ApiDoc(
     *  description="Return groups belong to user",
     * )
     * @return Response
     */
    public function indexAction()
    {
        /** @var User $user */
        $user = $this->getUser();
        $groups = $user->getSubscriberGroups();

        return $this->success($groups, 'subscriber_group', Response::HTTP_OK, [
            'SUBSCRIBER_GROUP_DETAILS'
        ]);
    }

    /**
     * @ApiDoc(
     *  description="Create new group",
     *  parameters={
     *      {"name"="name", "dataType"="string", "required"=true, "description"="Name of group"},
     *  })
     * )
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(SubscriberGroupType::class);
        $submittedData = json_decode($request->getContent(), true);
        $form->submit($submittedData);

        if (!$form->isValid()) {
            return $this->error($this->getFormErrorsAsArray($form));
        }
        /** @var SubscriberGroup $group */
        $group = $form->getData();
        $group->setUser($this->getUser());
        $group->setGroupKey(Uuid::uuid4()->toString());
        $em = $this->getDoctrine()->getManager();
        $em->persist($group);
        $em->flush();

        return $this->success($group, 'subscriber_group', Response::HTTP_CREATED, [
            'SUBSCRIBER_GROUP_DETAILS'
        ]);
    }

    /**
     * @ApiDoc(
     *  description="Delete group"
     *)
     * @param SubscriberGroup $subscriberGroup
     * @return Response
     */
    public function deleteAction(SubscriberGroup $subscriberGroup)
    {
        $this->denyAccessUnlessGranted('access', $subscriberGroup);

        $em = $this->getDoctrine()->getManager();
        $em->remove($subscriberGroup);
        $em->flush();

        return $this->success(array('status' => 'Removed', 'message' => 'Group properly removed'), 'subscriber_group');
    }
}
