<?php

namespace App\Entity;

use Ramsey\Uuid\Uuid;

/**
 * Token
 */
class Token extends AbstractEntity
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $token;

    /**
     * @var \DateTime
     */
    private $expiredAt;

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
     * Set username.
     *
     * @param int $userId
     *
     * @return Token
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username.
     *
     * @return int
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set token.
     *
     * @param string $token
     *
     * @return Token
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set expiredAt.
     *
     * @param \DateTime $expiredAt
     *
     * @return Token
     */
    public function setExpiredAt($expiredAt)
    {
        $this->expiredAt = $expiredAt;

        return $this;
    }

    /**
     * Get expiredAt.
     *
     * @return \DateTime
     */
    public function getExpiredAt()
    {
        return $this->expiredAt;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Token
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

    public function tokenHandle()
    {
        $this->token = Uuid::uuid5(Uuid::NAMESPACE_OID,'api.token')->getHex();
    }

    public function expiredAtHandle()
    {
        $date = new \DateTime();
        $this->expiredAt = $date->modify('+30 days');
    }
}
