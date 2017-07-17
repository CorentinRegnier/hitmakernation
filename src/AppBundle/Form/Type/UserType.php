<?php

/*
 * This file is part of the ValepImmo Project.
 *
 * (c) Corentin Régnier <corentin.regnier59@gmail.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class UserType
 */
class UserType extends AbstractType
{
    private $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $isAdmin = $this->authorizationChecker->isGranted(User::ROLE_SUPER_ADMIN);
        $builder
            ->add('civility', ChoiceType::class, [
                'label'      => false,
                'multiple'   => false,
                'expanded'   => true,
                'label_attr' => [
                    'class' => 'radio-inline',
                ],
                'choices'    => User::getAvailableCivilities(),
            ])
            ->add('lastName', TextType::class, [
                'label' => 'app.form.registration.last_name',
            ])
            ->add('firstName', TextType::class, [
                'label' => 'app.form.registration.first_name',
            ])
            ->add('birthdayDate', BirthdayType::class, [
                'label'    => 'app.form.registration.birthday',
                'widget'   => 'single_text',
                'format'   => 'dd/MM/yyyy',
                'attr'     => ['class' => 'js-datepicker'],
                'required' => false,
            ])
            ->add('address', TextType::class, [
                'label'    => 'app.form.registration.address',
                'required' => false,
            ])
            ->add('zipCode', TextType::class, [
                'label'    => 'app.form.registration.zip_code',
                'required' => false,
            ])
            ->add('city', TextType::class, [
                'label'    => 'app.form.registration.city',
                'required' => false,
            ])
            ->add('country', TextType::class, [
                'label'    => 'app.form.registration.country',
                'required' => false,
            ])
            ->add('phone', TextType::class, [
                'label'    => 'app.form.registration.phone',
                'required' => false,
            ])
            ->add('roles', ChoiceType::class, [
                'label'    => 'admin.form.user.role.label',
                'multiple' => true,
                'choices'  => true === $isAdmin ? User::getAvailableAdminRoles() : User::getAvailableRoles(),
                'required' => true,
            ]);

        if (true === $options['isCreation']) {
            $builder->add('generalCondition', CheckboxType::class, [
                'label' => 'app.form.registration.general_condition',
            ]);
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\User',
            'isCreation' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_user_type';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
