<?php

namespace App\Form\Type;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
            'submit' => 'Create book'
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('publication_year', IntegerType::class)
            ->add('isbn', TextType::class)
            ->add('pages_count', IntegerType::class)
            ->add('authors', EntityType::class, [
                'class' => Author::class,
                'multiple' => true,
                'expanded' => true
            ])
            ->add('save', SubmitType::class, ['label' => $options['submit']])
        ;
    }

}