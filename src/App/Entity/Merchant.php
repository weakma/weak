<?php

namespace App\Entity;

/**
 * Merchant
 */
class Merchant extends AbstractEntity
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime|null
     */
    private $openingTime;

    /**
     * @var \DateTime|null
     */
    private $closedTime;

    /**
     * @var json|null
     */
    private $week;

    /**
     * @var string|null
     */
    private $tel;

    /**
     * @var string|null
     */
    private $brand;

    /**
     * @var string|null
     */
    private $shopLogo;

    /**
     * @var int|null
     */
    private $province;

    /**
     * @var int|null
     */
    private $city;

    /**
     * @var int|null
     */
    private $district;

    /**
     * @var string|null
     */
    private $street;

    /**
     * @var float|null
     */
    private $longitude;

    /**
     * @var float|null
     */
    private $latitude;

    /**
     * @var int
     */
    private $version;

    /**
     * @var \DateTime
     */
    private $expireDate;

    /**
     * @var \DateTime
     */
    private $createdAt;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Merchant
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set openingTime.
     *
     * @param \DateTime|null $openingTime
     *
     * @return Merchant
     */
    public function setOpeningTime($openingTime = null)
    {
        $this->openingTime = $openingTime;

        return $this;
    }

    /**
     * Get openingTime.
     *
     * @return \DateTime|null
     */
    public function getOpeningTime()
    {
        return $this->openingTime;
    }

    /**
     * Set closedTime.
     *
     * @param \DateTime|null $closedTime
     *
     * @return Merchant
     */
    public function setClosedTime($closedTime = null)
    {
        $this->closedTime = $closedTime;

        return $this;
    }

    /**
     * Get closedTime.
     *
     * @return \DateTime|null
     */
    public function getClosedTime()
    {
        return $this->closedTime;
    }

    /**
     * Set week.
     *
     * @param json|null $week
     *
     * @return Merchant
     */
    public function setWeek($week = null)
    {
        $this->week = $week;

        return $this;
    }

    /**
     * Get week.
     *
     * @return json|null
     */
    public function getWeek()
    {
        return $this->week;
    }

    /**
     * Set tel.
     *
     * @param string|null $tel
     *
     * @return Merchant
     */
    public function setTel($tel = null)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel.
     *
     * @return string|null
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set brand.
     *
     * @param string|null $brand
     *
     * @return Merchant
     */
    public function setBrand($brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand.
     *
     * @return string|null
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set shopLogo.
     *
     * @param string|null $shopLogo
     *
     * @return Merchant
     */
    public function setShopLogo($shopLogo = null)
    {
        $this->shopLogo = $shopLogo;

        return $this;
    }

    /**
     * Get shopLogo.
     *
     * @return string|null
     */
    public function getShopLogo()
    {
        return $this->shopLogo;
    }

    /**
     * Set province.
     *
     * @param int|null $province
     *
     * @return Merchant
     */
    public function setProvince($province = null)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get province.
     *
     * @return int|null
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Set city.
     *
     * @param int|null $city
     *
     * @return Merchant
     */
    public function setCity($city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city.
     *
     * @return int|null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set district.
     *
     * @param int|null $district
     *
     * @return Merchant
     */
    public function setDistrict($district = null)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * Get district.
     *
     * @return int|null
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Set street.
     *
     * @param string|null $street
     *
     * @return Merchant
     */
    public function setStreet($street = null)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street.
     *
     * @return string|null
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set longitude.
     *
     * @param float|null $longitude
     *
     * @return Merchant
     */
    public function setLongitude($longitude = null)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude.
     *
     * @return float|null
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude.
     *
     * @param float|null $latitude
     *
     * @return Merchant
     */
    public function setLatitude($latitude = null)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude.
     *
     * @return float|null
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set version.
     *
     * @param int $version
     *
     * @return Merchant
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version.
     *
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set expireDate.
     *
     * @param \DateTime $expireDate
     *
     * @return Merchant
     */
    public function setExpireDate($expireDate)
    {
        $this->expireDate = $expireDate;

        return $this;
    }

    /**
     * Get expireDate.
     *
     * @return \DateTime
     */
    public function getExpireDate()
    {
        return $this->expireDate;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Merchant
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
