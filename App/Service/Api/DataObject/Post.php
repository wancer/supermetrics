<?php

namespace Supermetrics\App\Service\Api\DataObject;

use Supermetrics\App\Service\Api\Exception\ApiException;

/**
 * Class Post
 */
class Post implements \JsonSerializable
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $fromName;
    /**
     * @var string
     */
    private $fromId;
    /**
     * @var string
     */
    private $message;
    /**
     * @var string
     */
    private $type;
    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * Post constructor.
     *
     * @param array $rawPost
     *
     * @throws ApiException
     */
    public function __construct(array $rawPost)
    {
        $this->id = $rawPost['id'];
        $this->fromName = $rawPost['from_name'];
        $this->fromId = $rawPost['from_id'];
        $this->message = $rawPost['message'];
        $this->type = $rawPost['type'];
        try
        {
            $this->createdTime = new \DateTime($rawPost['created_time']);
        }
        catch (\Exception $e)
        {
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFromName(): string
    {
        return $this->fromName;
    }

    /**
     * @return string
     */
    public function getFromId(): string
    {
        return $this->fromId;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedTime(): \DateTime
    {
        return $this->createdTime;
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}