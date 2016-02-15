<?php

namespace Alpixel\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

abstract class User extends BaseUser
{
    /**
     * @var string
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @var string
     *
     * @ORM\Column(name="activated", type="boolean")
     */
    protected $activated;

    public function __construct()
    {
        parent::__construct();
        $this->pushID               = array();
        $this->confirmationToken    = sha1(uniqid(uniqid(mt_rand()), true));
        $this->created              = new \DateTime();
        $this->activated            = false;
        $this->enabled              = true;
    }

    public function getWSSEToken()
    {
        $nonce = hash_hmac('sha512', uniqid(null, true), uniqid(), true);
        $created = new \DateTime('now');
        $created = $created->format(\DateTime::ISO8601);
        $digest = sha1($nonce.$created.$this->getPassword(), true);

        return sprintf(
            'UsernameToken Username="%s", PasswordDigest="%s", Nonce="%s", Created="%s"',
            $this->getUsername(),
            $digest,
            $nonce,
            $created
        );
    }

    public function __toString()
    {
        return $this->firstname.' '.$this->lastname;
    }

    public function getParent()
    {
        return 'FOSUserBundle';
    }

    /**
     * Gets the value of id.
     *
     * @return integer
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     * Sets the value of id.
     *
     * @param integer $id the id
     *
     * @return self
     */
    protected function setID($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of newPassword.
     *
     * @return string
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * Sets the value of newPassword.
     *
     * @param string $newPassword the new password
     *
     * @return self
     */
    public function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    /**
     * Gets the value of uniqid.
     *
     * @return string
     */
    public function getUniqid()
    {
        return $this->uniqid;
    }

    /**
     * Sets the value of uniqid.
     *
     * @param string $uniqid the uniqid
     *
     * @return self
     */
    public function setUniqid($uniqid)
    {
        $this->uniqid = $uniqid;

        return $this;
    }

    /**
     * Gets the value of created.
     *
     * @return string
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Sets the value of created.
     *
     * @param string $created the subscription date
     *
     * @return self
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    public function isActivated()
    {
        return $this->activated;
    }

    public function setActivated($activated)
    {
        $this->activated = $activated;
    }
}
