<?php

namespace App\Contracts;

/**
 *
 */
interface OtpInterface
{
    /**
     * @param string $identifier
     * @return object
     */
    public function generate(string $identifier): object;

    /**
     * @param string $identifier
     * @param string $token
     * @return object
     */
    public function validate(string $identifier, string $token): object;


    /**
     * @return bool
     */
    public function deleteOldOtps(): bool;
}
