<?php
namespace ApiBundle\Form\Type;

use ApiBundle\Model\Register;
use MailAppBundle\Entity\Subscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscriberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('attributes', CollectionType::class, array(
            'entry_type' => AttributeType::class
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
