<?php
/*
 * This file is part of the Yer package.
 * 
 * (c) Erhan Abay <erhanabay@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yer\Validator;

/**
 * Validator interface
 * 
 * @author Erhan Abay <erhanabay@gmail.com>
 */
interface ValidatorInterface
{
    /**
     * Validates value
     *
     * @param mixed $value Value to check against
     * 
     * @return boolean true   If validates
     *                 false  If cannot validate
     */
    public function validate($value);
}