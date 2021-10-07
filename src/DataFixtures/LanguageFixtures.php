<?php
/**
 * Language fixtures.
 */

namespace App\DataFixtures;


use App\Entity\Language;
use Doctrine\Persistence\ObjectManager;

/**
 * Class LanguageFixtures.
 */
class LanguageFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param ObjectManager $manager Object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(
            1,
            'włoski',
            function () {
                $language = new Language();
                $language->setName('włoski');

                return $language;
            }
        );

        $this->createMany(
            1,
            'angielski',
            function () {
                $language = new Language();
                $language->setName('angielski');

                return $language;
            }
        );

        $this->createMany(
            1,
            'węgierski',
            function () {
                $language = new Language();
                $language->setName('węgierski');

                return $language;
            }
        );

        $manager->flush();
    }
}
