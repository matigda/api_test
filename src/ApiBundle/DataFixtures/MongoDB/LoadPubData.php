<?php

namespace ApiBundle\DataFixtures\MongoDB;

use ApiBundle\Document\Localization;
use ApiBundle\Document\Pub;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPubData implements FixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $pubs = [];

        $pubs[] = $this->createNewPub('Washington DC', -77.0145665, 38.8993487);
        $pubs[] = $this->createNewPub('White House', -77.0388266, 38.9024593);
        $pubs[] = $this->createNewPub('Library of Congress', -77.0047189, 38.888684);
        $pubs[] = $this->createNewPub('Patuxent Research Refuge', -76.8216182, 39.0391718);
        $pubs[] = $this->createNewPub('The Pentagon', -77.056267, 38.871857);
        $pubs[] = $this->createNewPub('Massachusetts Institute of Technology', -71.09416, 42.360091);

        $pubs[] = $this->createNewPub('Zimne nóżki', 18.648489, 54.351742);
        $pubs[] = $this->createNewPub('Absynt', 18.648497, 54.351950);
        $pubs[] = $this->createNewPub('Green', 18.59289, 54.38978);
        $pubs[] = $this->createNewPub('Parlament', 18.64976, 54.35109);

        foreach ($pubs as $pub) {
            $manager->persist($pub);
        }

        $manager->flush();
    }

    /**
     * @param string $name
     * @param float  $longitude
     * @param float  $latitude
     *
     * @return Pub
     */
    private function createNewPub($name, $longitude, $latitude)
    {
        $pub = new Pub();
        $pub->setName($name);
        $localization = new Localization([$longitude, $latitude]);
        $pub->setLocalization($localization);

        return $pub;
    }
}
