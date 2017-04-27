<?php

namespace ApiBundle\Controller;

use ApiBundle\Form\Type\SubscriberGroupType;
use MailAppBundle\Entity\SubscriberGroup;
use MailAppBundle\Entity\User;
use MailAppBundle\Service\csv\SubscriberCsvGenerator;
use MailAppBundle\Service\eml\SubscriberEmlGenerator;
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
     * @param SubscriberGroup $subscriberGroup
     * @return \ApiBundle\HttpFoundation\CsvResponse
     */
    public function exportCsvAction(SubscriberGroup $subscriberGroup)
    {
        $this->denyAccessUnlessGranted('access', $subscriberGroup);

        /** @var SubscriberCsvGenerator $subscriberCsvGenerator */
        $subscriberCsvGenerator = $this->get('mail_app.subscribrt_csv_generator');
        $subscriberCsv = $subscriberCsvGenerator->generateCsv($subscriberGroup->getSubscribers(), true);

        return $this->csv($subscriberCsv);
    }

    /**
     * @param SubscriberGroup $subscriberGroup
     * @return \ApiBundle\HttpFoundation\EmlResponse
     */
    public function exportEmlAction(SubscriberGroup $subscriberGroup)
    {
        $this->denyAccessUnlessGranted('access', $subscriberGroup);

        /** @var SubscriberEmlGenerator $subscriberEmlGenerator */
        $subscriberEmlGenerator = $this->get('mail_app.subscribrt_eml_generator');
        $subscriberEml = $subscriberEmlGenerator->generateEml($subscriberGroup->getSubscribers());

        return $this->eml($subscriberEml);
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
        $group->setCreatedAt(new \DateTime());
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
