<?php

namespace MailAppBundle\Service\csv;

use MailAppBundle\Entity\Subscriber;

class SubscriberCsvGenerator
{
    private $header = [
        'EMAIL',
        'GROUP',
        'ACTIVE',
        'CREATE DATE'
    ];

    /**
     * @param $subscribers
     * @param bool $withHeader
     * @return array
     */
    public function generateCsv($subscribers, $withHeader = true)
    {
        $csv = new CsvFile();

        $csv->setHeader($this->header);

        /** @var Subscriber $subscriber */
        foreach ($subscribers as $subscriber) {
            $csv->addRow([
                $subscriber->getEmail(),
                $subscriber->getSubscriberGroup()->getName(),
                $subscriber->isActive() ? 'TRUE' : 'FALSE',
                $subscriber->getCreatedAt()->format('d-m-Y')
            ]);
        }

        return $csv->getContent($withHeader);
    }
}
