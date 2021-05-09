<?php

namespace App\Form;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Projet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Security\Core\Security;

class ProjetType extends AbstractType
{ 
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options){

        $user = $this->security->getUser();
       
        if ($user->hasRole("ROLE_DIRECTEUR")){
     $builder->add('chefdeprojet', EntityType::class, [
        'class' => User::class,
        'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('u')
            ->where('u.roles = ?1')
            ->setParameter(1,'a:1:{i:0;s:9:"ROLE_CHEF";}')
            ->orderBy('u.username', 'DESC');
                
        },
        'choice_label' => 'username',
    ]);
        }
        $builder
            ->add('nom')
            ->add('description', TextareaType::class)
            ->add('datedebut', DateType::class, [
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
            ])
            ->add('datefin', DateType::class, [
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
            ])
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'Saisie' => 'saisie',
                    'En cour' => 'encour',
                    'Cloture' => 'Cloture',
                    'Suspension' => 'Suspension',
                ],
            ])           
            ->add('budget')
            ->add('typedeprojet', ChoiceType::class, [
                'choices'  => [
                    'Développement' => 'developpement',
                    'Gestion' => 'gestion',
                ],
            ])           
            ->add('nature', ChoiceType::class, [
                'choices'  => [
                    'Sur Site' => 'sursite',
                    'Chez le client' => 'chezleclient',
                    'Les deux' => 'lesdeux',
                ],
            ])    
            ->add('avencement', HiddenType::class, [
                'data' => 0,
            ])
            ->add('client', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                    ->where('u.roles = ?1')
                    ->setParameter(1, ('a:1:{i:0;s:11:"ROLE_CLIENT";}'))
                    ->orderBy('u.username', 'DESC');
                        
                },
                'choice_label' => 'username',
                'required'          => false,
            ]) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
