<?php

namespace Supermetrics\App\Service;

use Supermetrics\App\Service\Api\DataObject\Post;
use Supermetrics\App\Service\Api\DataObject\Posts;

/**
 * Class StatisticsCalculator
 *
 * Warning: stateful class.
 */
class StatisticsCalculator
{
    private $longestPostPerMonth = [];
    private $totalPostsPerWeek = [];

    private $charLenPerPostPerMonth = [];
    private $postsPerUserPerMonth = [];

    private $avgNumPostsPerUserPerMonth = [];
    private $avgCharLenPerPostPerMonth = [];

    private $averagesCalculated = false;

    /**
     * @param Posts $posts
     */
    public function processPosts(Posts $posts): void
    {
        foreach ($posts as $post)
        {
            // Could be same months in different years. Adding year for separation.
            $yearMonth = $post->getCreatedTime()->format('Y-m');
            // It's not so simple with year. ISO-8601 week-numbering year to properly calculate last week of the year.
            $week = $post->getCreatedTime()->format('o-W');
            // Using multibyte string function to properly calculate any characters.
            $postLength = mb_strlen($post->getMessage());

            $this->calculateLongestPostPerMonth($yearMonth, $postLength, $post);
            $this->calculateTotalPostsPerWeek($week);

            $this->addToCharLenPerMonth($yearMonth, $postLength);
            $this->addToPostsPerUserPerMonth($yearMonth, $post);
        }

        $this->averagesCalculated = false;
    }

    /**
     * @param string $week
     */
    protected function calculateTotalPostsPerWeek(string $week): void
    {
        $reference =& $this->totalPostsPerWeek[$week];

        if (!isset($reference))
        {
            $reference = 1;
        }
        else
        {
            $reference++;
        }
    }

    /**
     * @param string $month
     * @param int $postLength
     * @param Post $post
     */
    protected function calculateLongestPostPerMonth(string $month, int $postLength, Post $post): void
    {
        $reference =& $this->longestPostPerMonth[$month];

        if (!isset($reference))
        {
            $reference = [
                'length' => $postLength,
                'post' => $post,
            ];
        }
        elseif ($postLength > $reference['length'])
        {
            $reference['length'] = $postLength;
            $reference['post'] = $post;
        }
    }

    /**
     * @param string $month
     * @param int $postLength
     */
    protected function addToCharLenPerMonth(string $month, int $postLength): void
    {
        $reference =& $this->charLenPerPostPerMonth[$month];

        if (!isset($reference))
        {
            $reference['totalLength'] = $postLength;
            $reference['postsCount'] = 1;
        }
        else
        {
            $reference['totalLength'] += $postLength;
            $reference['postsCount']++;
        }
    }

    /**
     * @param string $month
     * @param Post $post
     */
    protected function addToPostsPerUserPerMonth(string $month, Post $post): void
    {
        $reference =& $this->postsPerUserPerMonth[$month];

        if (!isset($reference))
        {
            $reference['postsCount'] = 1;
            $reference['usersCount'] = 1;
        }
        else
        {
            $reference['postsCount']++;
        }

        if (!isset($reference['users'][$post->getFromId()]))
        {
            $reference['users'][$post->getFromId()] = true;
            $reference['usersCount']++;
        }
    }

    /**
     * It's not possible to calculate averages during iterations, so finishing calculating after.
     */
    public function calculateAverages(): void
    {
        foreach ($this->postsPerUserPerMonth as $month => $postsPerUser)
        {
            $this->avgNumPostsPerUserPerMonth[$month] = $postsPerUser['postsCount'] / $postsPerUser['usersCount'];
        }
        foreach ($this->charLenPerPostPerMonth as $month => $charLenPerPost)
        {
            $this->avgCharLenPerPostPerMonth[$month] = $charLenPerPost['totalLength'] / $charLenPerPost['postsCount'];
        }

        $this->averagesCalculated = true;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        if (!$this->averagesCalculated)
        {
            throw new StatisticsCalculatorException('Please run calculateAverages before calling this method.');
        }

        return [
            'AverageCharacterLengthPerPostPerMonth' => $this->avgCharLenPerPostPerMonth,
            'LongestPostPerMonth' => $this->longestPostPerMonth,
            'TotalPostsPerWeek' => $this->totalPostsPerWeek,
            'AverageNumberPostsPerUserPerMonth' => $this->avgNumPostsPerUserPerMonth,
        ];
    }
}