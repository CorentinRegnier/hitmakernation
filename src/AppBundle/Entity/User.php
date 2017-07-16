<?php

/*
 * This file is part of the ValepImmo Project.
 *
 * (c) Corentin Régnier <corentin.regnier59@gmail.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\TimeStampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class User
 *
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    use TimeStampTrait;

    const USER_ROLE_SUPER_ADMIN = "ROLE_SUPER_ADMIN";
    const USER_ROLE_USER        = "ROLE_USER";

    const USER_CIVILITY_MAN   = "man";
    const USER_CIVILITY_WOMAN = "woman";

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $civility;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $lastName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     */
    protected $birthdayDate;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $address;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $city;
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $country;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $phone;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $generalCondition = false;

    /**
     * @Gedmo\Slug(fields={"firstName","lastName"}, separator="-", updatable=true, unique=true)
     *
     * @ORM\Column(length=255, unique=true)
     */
    protected $slug;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->birthdayDate = new \DateTime();
        $this->roles        = [self::USER_ROLE_USER];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCivility()
    {
        return $this->civility;
    }

    /**
     * @param string $civility
     *
     * @return $this
     */
    public function setCivility($civility)
    {
        $this->civility = $civility;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     *
     * @return $this
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return $this
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return mixed
     */
    public function getBirthdayDate()
    {
        return $this->birthdayDate;
    }

    /**
     * @param mixed $birthdayDate
     *
     * @return User
     */
    public function setBirthdayDate($birthdayDate)
    {
        $this->birthdayDate = $birthdayDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     *
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     *
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     *
     * @return User
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     *
     * @return User
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGeneralCondition()
    {
        return $this->generalCondition;
    }

    /**
     * @param mixed $generalCondition
     *
     * @return $this
     */
    public function setGeneralCondition($generalCondition)
    {
        $this->generalCondition = $generalCondition;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->lastName.' '.$this->firstName;
    }

    /**
     * @return bool
     */
    public function isLower()
    {
        $todayDate = new \DateTime();
        if ($this->birthdayDate > $todayDate) {
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public static function getAvailableCivilities()
    {
        return [
            'app.civility.man'   => self::USER_CIVILITY_MAN,
            'app.civility.woman' => self::USER_CIVILITY_WOMAN,
        ];
    }

    /**
     * @return array
     */
    public static function getAvailableRoles()
    {
        return [
            'admin.role.ROLE_SUPER_ADMIN' => self::USER_ROLE_SUPER_ADMIN,
            'admin.role.ROLE_USER'        => self::USER_ROLE_USER,
        ];
    }
}
