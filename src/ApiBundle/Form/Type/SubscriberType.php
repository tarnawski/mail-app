<?php

namespace ApiBundle\Form\Type;

use MailAppBundle\Entity\Subscriber;
use MailAppBundle\Entity\SubscriberGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscriberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', EmailType::class);
        $builder->add('group', EntityType::class, [
            'property_path' => 'subscriberGroup',
            'class' => SubscriberGroup::class,
            'choice_value' => 'groupKey'
        ]);
        $builder->add('attributes', CollectionType::class, array(
            'entry_type' => AttributeType::class,
            'allow_add' => true,
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Subscriber::class,
            'csrf_protection' => false
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getBlockPrefix()
    {
        return '';
    }
}
