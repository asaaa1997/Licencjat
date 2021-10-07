<?php
/**
 * Word type.
 */

namespace App\Form;

use App\Entity\Category;
use App\Entity\Language;
use App\Entity\Word;
use App\Form\DataTransformer\TranslationsDataTransformer;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

/**
 * Class WordType.
 */
class WordType extends AbstractType
{
    /**
     * Translations data transformer.
     *
     * @var TranslationsDataTransformer
     */
    private $translationsDataTransformer;

    /**
     * Security.
     *
     * @var Security
     */
    private $security;

    /**
     * WordType constructor.
     *
     * @param TranslationsDataTransformer $translationsDataTransformer
     * @param Security $security
     */
    public function __construct(TranslationsDataTransformer $translationsDataTransformer, Security $security)
    {
        $this->translationsDataTransformer = $translationsDataTransformer;
        $this->security = $security;
    }


    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder The form builder
     * @param array                                        $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $user = $this->security->getUser();
        $builder->add(
            'name',
            TextType::class,
            [
                'label' => 'label_name',
                'required' => true,
                'attr' => ['max_length' => 100],
            ]
        );
        $builder->add(
            'category',
            EntityType::class,
            [
                'class' => Category::class,
                'choice_label' => function ($category) {
                    return $category->getName();
                },
                'label' => 'label_category',
                'placeholder' => 'label_none',
                'required' => true,
                'query_builder' => function (EntityRepository $er) {
                    $user = $this->security->getUser();
                    $qb = $er->createQueryBuilder('category');
                    $qb->andWhere('category.author = :author')
                        ->setParameter('author', $user);
                    return $qb;
                },
            ],
        );

        $builder->add(
            'language',
            EntityType::class,
            [
                'class' => Language::class,
                'choice_label' => function ($language) {
                    return $language->getName();
                },
                'label' => 'label_language',
                'placeholder' => 'label_none',
                'required' => true,
            ]
        );
        $builder->add(
            'translations',
            TextType::class,
            [
                'label' => 'label_translation',
                'required' => true,
                'attr' => ['max_length' => 100],
            ]
        );
        $builder->get('translations')->addModelTransformer(
            $this->translationsDataTransformer
        );


    }

    /**
     * Configures the options for this type.
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Word::class]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'word';
    }
}