<?php

namespace ApiBundle\Controller;

use MailAppBundle\Entity\Subscriber;
use MailAppBundle\Entity\User;
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
        /** @var SubscriberRepository $subscribeRepository */
        $subscribeRepository = $this->getRepository(Subscriber::class);

        return JsonResponse::create([
           'subscribe' => $subscribeRepository->getActiveSubscriberCountByUser($user),
           'unsubscribe' => $subscribeRepository->getUnActiveSubscriberCountByUser($user)
        ]);
    }
}
