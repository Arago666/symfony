<?php

namespace App\Form;

use App\Entity\Aggregate\MovieSession;
use App\Entity\Client;
use App\Entity\Movie;
use App\Entity\ValueObject\NameClient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieSessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Название фильма',
                'class' => Movie::class
            ))
            ->add('quantityTickets', TextType::class, array(
                'label' => 'Количество билетов'
            ))
            ->add('startTime', TextType::class, array(
                'label' => 'Дата и время начала сеанса',
                'choice_label' => 'title'
            ))
            ->add('firstName', TextareaType::class, array(
                'label' => 'Ваше имя',
                'class' => NameClient::class,
                'attr' => [
                    'placeholder' => 'Введите Ваше имя'
                ]
            ))
            ->add('phone', TextareaType::class, array(
                'label' => 'Ваш телефон',
                'class' => Client::class,
                'attr' => [
                    'placeholder' => 'Введите Ваш телефон'
                ]
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Забронировать',
                'attr' => [
                    'class' => 'btn btn-success float-left mr-3'
                ]
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MovieSession::class,
        ]);
    }
}
