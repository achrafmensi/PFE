<?php

namespace App\Form;

use App\Entity\Detailstache;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Security\Core\Security;
use App\Entity\User;
use App\Entity\Tache;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class DetailstacheType extends AbstractType
{    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {           $user = $this->security->getUser();


        if ($user->hasRole("ROLE_CONSULTANT")){ 
            $builder->add('tache', EntityType::class, [
            'class' => Tache::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                ->where('u.consultant = ?1')
                ->setParameter(1,$user = $this->security->getUser());
                    
            },
        ]);}
        else $builder->add('tache');



        $builder
            
            ->add('description',TextareaType::class)
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'saisie' => 'Saisie',
                    'Valide client' => 'Valide Client',
                    'BAP' => 'BAP',
                ],
            ])           
            ->add('Frais')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Detailstache::class,
        ]);
    }
}
