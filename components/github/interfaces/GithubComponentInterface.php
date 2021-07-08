<?php

namespace app\components\github\interfaces;

/**
 * Interface GithubComponentInterface
 * @package app\components\github\interfaces
 */
interface GithubComponentInterface
{
    /**
     * @var string default api name
     */
    const DEFAULT_API_NAME = 'user';

    /**
     * @var string repo fetch filter criteria "created_at_
     */
    const CRITERIA_UPDATED_AT = 'updated_at';

    /**
     * @var string not found exception
     */
    const ERROR_NOT_FOUND = 'Not Found';
}