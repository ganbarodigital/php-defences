<?php

/**
 * Copyright (c) 2015-present Ganbaro Digital Ltd
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  Libraries
 * @package   Defensive/Requirements
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2015-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://code.ganbarodigital.com/php-defensive
 */

namespace GanbaroDigital\Defensive\Requirements;

use GanbaroDigital\Defensive\Exceptions\E4xx_BadRequirements;
use GanbaroDigital\Defensive\Exceptions\E4xx_BadRequirementData;
use GanbaroDigital\Defensive\Exceptions\E4xx_UnsupportedType;

class RequireAllOf
{
    /**
     * throws exceptions if any of our requirements are not met
     *
     * @param  array $requirements
     *         the list of requirements to call
     * @param  array $data
     *         the parameters to pass to each requirement in turn
     * @param  string $exception
     *         the class to use when throwing an exception
     * @return void
     */
    public static function check($requirements, $data, $exception = E4xx_UnsupportedType::class)
    {
        // we do not use Reflections RequireTraversable here because then
        // Reflections cannot depend upon this library
        if (!is_array($requirements)) {
            throw new E4xx_BadRequirements(__METHOD__);
        }
        if (!is_array($data)) {
            throw new E4xx_BadRequirementData(__METHOD__);
        }

        // now that we know our inputs are safe ...
        self::checkRequirements($requirements, $data, $exception);
    }

    /**
     * throws exceptions if any of our requirements are not met
     *
     * @param  array $requirements
     *         the list of requirements to call
     * @param  array $data
     *         the parameters to pass to each requirement in turn
     * @param  string $exception
     *         the class to use when throwing an exception
     * @return void
     */
    private static function checkRequirements($requirements, $data, $exception)
    {
        // are any of our requirements met?
        foreach ($requirements as $requirement) {
            // make sure it is an object first
            if (!is_callable($requirement)) {
                throw new E4xx_BadRequirements(__METHOD__);
            }

            // ask the requirement if it has been met
            if (!call_user_func_array($requirement, $data)) {
                // if we get here, our requirements are not met :(
                throw new $exception($data[0]);
            }
        }
    }

    /**
     * throws exceptions if any of our requirements are not met
     *
     * @param  array $requirements
     *         the list of requirements to call
     * @param  array $data
     *         the parameters to pass to each requirement in turn
     * @param  string $exception
     *         the class to use when throwing an exception
     * @return void
     */
    public function __invoke($requirements, $data, $exception = E4xx_UnsupportedType::class)
    {
        return self::check($requirements, $data, $exception);
    }
}