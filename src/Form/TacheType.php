<?php

namespace App\Form;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\Tache;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Security\Core\Security;



class TacheType extends AbstractType
{    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->security->getUser();
       
        if ($user->hasRole("ROLE_CHEF")){
     $builder->add('consultant', EntityType::class, [
        'class' => User::class,
        'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('u')
            ->where('u.roles = ?1')
            ->setParameter(1,'a:1:{i:0;s:15:"ROLE_CONSULTANT";}')
            ->orderBy('u.username', 'DESC');
                
        },
        'choice_label' => 'username',
    
    ]);}


        $builder
            ->add('projet')            
            ->add('nom')
            ->add('datedebut', DateType::class, [
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
            ])
            ->add('datefinprevue', DateType::class, [
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
            ])
            ->add('datefinreel', DateType::class, [
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
                'required' => false,            ])
            ->add('nature', ChoiceType::class, [
                'choices'  => [
                    'Sur Site' => 'sursite',
                    'Chez le client' => 'chezleclient',
                    'Les deux' => 'lesdeux',
                ],
            ])
            ->add('description',TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tache::class,
        ]);
    }
}