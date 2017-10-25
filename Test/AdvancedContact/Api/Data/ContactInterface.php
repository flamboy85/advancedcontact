<?php

namespace Test\AdvancedContact\Api\Data;

/**
 * Interface ContactInterface
 * @package Test\AdvancedContact\Api\Data
 * @api
 */
interface ContactInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const CONTACT_ID =  'contact_id';
    const NAME =        'name';
    const EMAIL =       'email';
    const TELEPHONE =   'telephone';
    const COMMENT =     'comment';
    const STATUS =      'status';
    const CREATED_AT =  'created_at';
    const UPDATED_AT =  'updated_at';
    /**#@-*/

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Get email
     *
     * @return string|null
     */
    public function getEmail();

    /**
     * Get telephone
     *
     * @return string|null
     */
    public function getTelephone();

    /**
     * Get comment
     *
     * @return string|null
     */
    public function getComment();

    /**
     * Get status
     *
     * @return int|null
     */
    public function getStatus();

    /**
     * Get created at
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Get update at
     *
     * @return string|null
     */
    public function getUpdateAt();

    /**
     * Set ID
     *
     * @param int $id
     * @return ContactInterface
     */
    public function setId($id);

    /**
     * Set name
     *
     * @param string $name
     * @return ContactInterface
     */
    public function setName($name);

    /**
     * Set email
     *
     * @param string $email
     * @return ContactInterface
     */
    public function setEmail($email);

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return ContactInterface
     */
    public function setTelephone($telephone);

    /**
     * Set comment
     *
     * @param string $comment
     * @return ContactInterface
     */
    public function setComment($comment);

    /**
     * Set status
     *
     * @param int $status
     * @return ContactInterface
     */
    public function setStatus($status);

    /**
     * Set created at
     *
     * @param string $createdAt
     * @return ContactInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Set updated at
     *
     * @param string $updatedAt
     * @return ContactInterface
     */
    public function setUpdatedAt($updatedAt);
}
