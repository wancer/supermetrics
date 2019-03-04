<?php

namespace Supermetrics\App\Service\Api\DataObject;

/**
 * Class Posts
 */
class Posts implements \Iterator, \JsonSerializable
{
    private $posts = [];
    private $page;

    /**
     * Posts constructor.
     *
     * @param array $posts
     * @param int $page
     *
     * @throws \Supermetrics\App\Service\Api\Exception\ApiException
     */
    public function __construct(array $posts, int $page)
    {
        $this->page = $page;

        foreach ($posts as $post)
        {
            $this->posts[] = new Post($post);
        }
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return Post
     */
    public function current()
    {
        return current($this->posts);
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        next($this->posts);
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return key($this->posts);
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return current($this->posts);
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        reset($this->posts);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'page' => $this->page,
            'posts' => $this->posts,
        ];
    }
}