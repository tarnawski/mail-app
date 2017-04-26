<?php

namespace ApiBundle\Controller;

use MailAppBundle\Entity\Subscriber;
use MailAppBundle\Entity\SubscriberGroup;
use MailAppBundle\Entity\User;
use MailAppBundle\Repository\SubscriberGroupRepository;
use MailAppBundle\Repository\SubscriberRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class StatusController
 */
class StatusController extends BaseController
{
    /**
     * @ApiDoc(
     *  description="Return information subscribers",
     * )
     * @return Response
     */
    public function indexAction()
    {
        /** @var User $user */
        $user = $this->getUser();
        /** @var SubscriberRepository $subscriberRepository */
        $subscriberRepository = $this->getRepository(Subscriber::class);
        /** @var SubscriberGroupRepository $subscribeGroupRepository */
        $subscribeGroupRepository = $this->getRepository(SubscriberGroup::class);
        return JsonResponse::create([
           'group' => $subscribeGroupRepository->getGroupCountByUser($user),
           'subscribe' => $subscriberRepository->getActiveSubscriberCountByUser($user),
           'unsubscribe' => $subscriberRepository->getUnActiveSubscriberCountByUser($user)
        ]);
    }
}
