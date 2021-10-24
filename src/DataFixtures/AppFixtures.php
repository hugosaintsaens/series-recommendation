<?php

/**
 * Jeu de données
 * 
 * Cette fixtures contient un jeu de données cohérent pour pouvoir développer
 * 
 * @copyright 2021 BLHL
 */

namespace App\DataFixtures;

use App\Entity\Words;
use App\Entity\Users;
use App\Entity\Series;
use App\Entity\Contains;
use App\Entity\Likes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        /** USERS */
        $users = new Users();
        $users->setName('test')
            ->setPassword($this->passwordEncoder->encodePassword($users, 'password'));
        $manager->persist($users);

        $manager->flush();

        /** SERIES */
        $thesopranos = new Series();
        $thesopranos->setName('The Sopranos');
        $manager->persist($thesopranos);

        $xfiles = new Series();
        $xfiles->setName('X-Files');
        $manager->persist($xfiles);

        $v = new Series();
        $v->setName('V');
        $manager->persist($v);

        $prisonbreak = new Series();
        $prisonbreak->setName('Prison Break');
        $manager->persist($prisonbreak);

        $smallville = new Series();
        $smallville->setName('Smallville');
        $manager->persist($smallville);

        $sonsofanarchy = new Series();
        $sonsofanarchy->setName('Sons of Anarchy');
        $manager->persist($sonsofanarchy);

        $southpark = new Series();
        $southpark->setName('South Park');
        $manager->persist($southpark);

        $doctorwho = new Series();
        $doctorwho->setName('Doctor Who');
        $manager->persist($doctorwho);

        $futurama = new Series();
        $futurama->setName('Futurama');
        $manager->persist($futurama);

        $battlestargalactica = new Series();
        $battlestargalactica->setName('Battlestar Galactica');
        $manager->persist($battlestargalactica);

        $blade = new Series();
        $blade->setName('Blade');
        $manager->persist($blade);

        $bionicwoman = new Series();
        $bionicwoman->setName('Bionic Woman');
        $manager->persist($bionicwoman);

        $dexter = new Series();
        $dexter->setName('Dexter');
        $manager->persist($dexter);

        $manager->flush();

        /** WORDS */
        $peur = new Words();
        $peur->setLibelle('peur');
        $manager->persist($peur);

        $police = new Words();
        $police->setLibelle('police');
        $manager->persist($police);

        $mafia = new Words();
        $mafia->setLibelle('mafia');
        $manager->persist($mafia);

        $meurtre = new Words();
        $meurtre->setLibelle('meurtre');
        $manager->persist($meurtre);

        $docteur = new Words();
        $docteur->setLibelle('docteur');
        $manager->persist($docteur);

        $horreur = new Words();
        $horreur->setLibelle('horreur');
        $manager->persist($horreur);

        $surnaturel = new Words();
        $surnaturel->setLibelle('surnaturel');
        $manager->persist($surnaturel);

        $extraterrestre = new Words();
        $extraterrestre->setLibelle('extraterrestre');
        $manager->persist($extraterrestre);

        $combat = new Words();
        $combat->setLibelle('combat');
        $manager->persist($combat);

        $manager->flush();

        /** CONTAINS */

        /** THE SOPRANOS */
        $thesopranos_peur = new Contains();
        $thesopranos_peur->setSeries($thesopranos)
            ->setWords($peur)
            ->setAppearance(10.0);
        $manager->persist($thesopranos_peur);

        $thesopranos_police = new Contains();
        $thesopranos_police->setSeries($thesopranos)
            ->setWords($police)
            ->setAppearance(50.0);
        $manager->persist($thesopranos_police);

        $thesopranos_docteur = new Contains();
        $thesopranos_docteur->setSeries($thesopranos)
            ->setWords($docteur)
            ->setAppearance(5.0);
        $manager->persist($thesopranos_docteur);

        $thesopranos_combat = new Contains();
        $thesopranos_combat->setSeries($thesopranos)
            ->setWords($combat)
            ->setAppearance(15.0);
        $manager->persist($thesopranos_combat);

        /** X-FILES */
        $xfiles_peur = new Contains();
        $xfiles_peur->setSeries($xfiles)
            ->setWords($peur)
            ->setAppearance(20.0);
        $manager->persist($xfiles_peur);

        $xfiles_police = new Contains();
        $xfiles_police->setSeries($xfiles)
            ->setWords($police)
            ->setAppearance(18.0);
        $manager->persist($xfiles_police);

        $xfiles_meurtre = new Contains();
        $xfiles_meurtre->setSeries($xfiles)
            ->setWords($meurtre)
            ->setAppearance(15.0);
        $manager->persist($xfiles_meurtre);

        $xfiles_horreur = new Contains();
        $xfiles_horreur->setSeries($xfiles)
            ->setWords($horreur)
            ->setAppearance(25.0);
        $manager->persist($xfiles_horreur);

        $xfiles_surnaturel = new Contains();
        $xfiles_surnaturel->setSeries($xfiles)
            ->setWords($surnaturel)
            ->setAppearance(75.0);
        $manager->persist($xfiles_surnaturel);

        $xfiles_extraterrestre = new Contains();
        $xfiles_extraterrestre->setSeries($xfiles)
            ->setWords($extraterrestre)
            ->setAppearance(99.0);
        $manager->persist($xfiles_extraterrestre);

        $xfiles_combat = new Contains();
        $xfiles_combat->setSeries($xfiles)
            ->setWords($combat)
            ->setAppearance(5.0);
        $manager->persist($xfiles_combat);

        /** V */
        $v_peur = new Contains();
        $v_peur->setSeries($v)
            ->setWords($peur)
            ->setAppearance(10.0);
        $manager->persist($v_peur);

        $v_police = new Contains();
        $v_police->setSeries($v)
            ->setWords($police)
            ->setAppearance(50.0);
        $manager->persist($v_police);

        $v_mafia = new Contains();
        $v_mafia->setSeries($v)
            ->setWords($mafia)
            ->setAppearance(15.0);
        $manager->persist($v_mafia);

        $v_meurtre = new Contains();
        $v_meurtre->setSeries($v)
            ->setWords($meurtre)
            ->setAppearance(40.0);
        $manager->persist($v_meurtre);

        $v_horreur = new Contains();
        $v_horreur->setSeries($v)
            ->setWords($horreur)
            ->setAppearance(20.0);
        $manager->persist($v_horreur);

        $v_combat = new Contains();
        $v_combat->setSeries($v)
            ->setWords($combat)
            ->setAppearance(20.0);
        $manager->persist($v_combat);

        /** PRISON BREAK */
        $prisonbreak_peur = new Contains();
        $prisonbreak_peur->setSeries($prisonbreak)
            ->setWords($peur)
            ->setAppearance(10.0);
        $manager->persist($prisonbreak_peur);

        $prisonbreak_police = new Contains();
        $prisonbreak_police->setSeries($prisonbreak)
            ->setWords($police)
            ->setAppearance(15.0);
        $manager->persist($prisonbreak_police);

        $prisonbreak_mafia = new Contains();
        $prisonbreak_mafia->setSeries($prisonbreak)
            ->setWords($mafia)
            ->setAppearance(8.0);
        $manager->persist($prisonbreak_mafia);

        $prisonbreak_meurtre = new Contains();
        $prisonbreak_meurtre->setSeries($prisonbreak)
            ->setWords($meurtre)
            ->setAppearance(20.0);
        $manager->persist($prisonbreak_meurtre);

        $prisonbreak_docteur = new Contains();
        $prisonbreak_docteur->setSeries($prisonbreak)
            ->setWords($docteur)
            ->setAppearance(5.0);
        $manager->persist($prisonbreak_docteur);

        $prisonbreak_combat = new Contains();
        $prisonbreak_combat->setSeries($prisonbreak)
            ->setWords($combat)
            ->setAppearance(50.0);
        $manager->persist($prisonbreak_combat);

        /** SMALLVILLE */
        $smallville_police = new Contains();
        $smallville_police->setSeries($smallville)
            ->setWords($police)
            ->setAppearance(15.0);
        $manager->persist($smallville_police);

        $smallville_meurtre = new Contains();
        $smallville_meurtre->setSeries($smallville)
            ->setWords($meurtre)
            ->setAppearance(38.0);
        $manager->persist($smallville_meurtre);

        $smallville_surnaturel = new Contains();
        $smallville_surnaturel->setSeries($smallville)
            ->setWords($surnaturel)
            ->setAppearance(40.0);
        $manager->persist($smallville_surnaturel);

        $smallville_extraterrestre = new Contains();
        $smallville_extraterrestre->setSeries($smallville)
            ->setWords($extraterrestre)
            ->setAppearance(75.0);
        $manager->persist($smallville_extraterrestre);

        $smallville_combat = new Contains();
        $smallville_combat->setSeries($smallville)
            ->setWords($combat)
            ->setAppearance(30.0);
        $manager->persist($smallville_combat);

        $manager->flush();

        /** LIKES */

        $users_thesopranos = new Likes();
        $users_thesopranos->setFavorite(1)
            ->setSeriesId($thesopranos)
            ->setUsersId($users);
        $manager->persist($users_thesopranos);

        $users_xfiles = new Likes();
        $users_xfiles->setFavorite(1)
            ->setSeriesId($xfiles)
            ->setUsersId($users);
        $manager->persist($users_xfiles);

        $users_v = new Likes();
        $users_v->setFavorite(0)
            ->setSeriesId($v)
            ->setUsersId($users);
        $manager->persist($users_v);

        $users_prisonbreak = new Likes();
        $users_prisonbreak->setFavorite(0)
            ->setSeriesId($prisonbreak)
            ->setUsersId($users);
        $manager->persist($users_prisonbreak);

        $users_smallville = new Likes();
        $users_smallville->setFavorite(0)
            ->setSeriesId($smallville)
            ->setUsersId($users);
        $manager->persist($users_smallville);

        $users_sonsofanarchy = new Likes();
        $users_sonsofanarchy->setFavorite(0)
            ->setSeriesId($sonsofanarchy)
            ->setUsersId($users);
        $manager->persist($users_sonsofanarchy);

        $users_southpark = new Likes();
        $users_southpark->setFavorite(0)
            ->setSeriesId($southpark)
            ->setUsersId($users);
        $manager->persist($users_southpark);

        $users_doctorwho = new Likes();
        $users_doctorwho->setFavorite(1)
            ->setSeriesId($doctorwho)
            ->setUsersId($users);
        $manager->persist($users_doctorwho);

        $users_futurama = new Likes();
        $users_futurama->setFavorite(0)
            ->setSeriesId($futurama)
            ->setUsersId($users);
        $manager->persist($users_futurama);

        $users_battlestargalactica = new Likes();
        $users_battlestargalactica->setFavorite(0)
            ->setSeriesId($battlestargalactica)
            ->setUsersId($users);
        $manager->persist($users_battlestargalactica);

        $users_blade = new Likes();
        $users_blade->setFavorite(0)
            ->setSeriesId($blade)
            ->setUsersId($users);
        $manager->persist($users_blade);

        $users_bionicwoman = new Likes();
        $users_bionicwoman->setFavorite(0)
            ->setSeriesId($bionicwoman)
            ->setUsersId($users);
        $manager->persist($users_bionicwoman);

        $users_dexter = new Likes();
        $users_dexter->setFavorite(0)
            ->setSeriesId($dexter)
            ->setUsersId($users);
        $manager->persist($users_dexter);

        $manager->flush();
    }
}
