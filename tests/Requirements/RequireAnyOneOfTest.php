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

use GanbaroDigital\Defensive\Exceptions\E4xx_UnsupportedType;
use PHPUnit_Framework_TestCase;
use stdClass;

class RequireAnyOneOfTest_CheckNull
{
    public function __invoke($item)
    {
        return is_null($item);
    }
}

class RequireAnyOneOfTest_CheckNumeric
{
    public function __invoke($item)
    {
        return is_numeric($item);
    }
}

class RequireAnyOneOfTest_CheckString
{
    public function __invoke($item)
    {
        return is_string($item);
    }
}

class RequireAnyOneOfTest_Group1
{
    private $req;

    public function __construct()
    {
        $this->req = [
            new RequireAnyOneOfTest_CheckNull,
            new RequireAnyOneOfTest_CheckNumeric
        ];
    }

    public function __invoke($item)
    {
        RequireAnyOneOf::check($this->req, [$item]);
    }
}

class RequireAnyOneOfTest_Group2
{
    private $req;

    public function __construct()
    {
        $this->req = [
            new RequireAnyOneOfTest_CheckNull,
            new RequireAnyOneOfTest_CheckString
        ];
    }

    public function __invoke($item)
    {
        RequireAnyOneOf::check($this->req, [$item]);
    }
}

/**
 * @coversDefaultClass GanbaroDigital\Defensive\Requirements\RequireAnyOneOf
 */
class RequireAnyOneOfTest extends PHPUnit_Framework_TestCase
{
    /**
     * @coversNothing
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $obj = new RequireAnyOneOf;

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($obj instanceof RequireAnyOneOf);
    }

    /**
     * @covers ::__invoke
     */
    public function testCanUseAsObject()
    {
        // ----------------------------------------------------------------
        // setup your test

        $requirements = [
            new RequireAnyOneOfTest_CheckNull,
            new RequireAnyOneOfTest_CheckNumeric,
        ];

        $obj = new RequireAnyOneOf;

        // ----------------------------------------------------------------
        // perform the change

        $obj($requirements, [1.0]);

        // ----------------------------------------------------------------
        // test the results
        //
        // if we get here, then no exception has been thrown :)
    }

    /**
     * @covers ::check
     * @dataProvider provideBadRequirements
     * @expectedException GanbaroDigital\Defensive\Exceptions\E4xx_BadRequirements
     */
    public function testMustProvideAnArrayOfRequirements($requirements)
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        RequireAnyOneOf::check($requirements, []);
    }

    /**
     * @covers ::check
     * @dataProvider provideBadRequirementData
     * @expectedException GanbaroDigital\Defensive\Exceptions\E4xx_BadRequirementData
     */
    public function testMustProvideAnArrayOfRequirementData($data)
    {
        // ----------------------------------------------------------------
        // setup your test

        $requirements = [
            new RequireAnyOneOfTest_CheckNull,
            new RequireAnyOneOfTest_CheckNumeric,
        ];

        // ----------------------------------------------------------------
        // perform the change

        RequireAnyOneOf::check($requirements, $data);
    }

    /**
     * @covers ::__invoke
     * @covers ::check
     */
    public function testWillMatchAnyRequirementGiven()
    {
        // ----------------------------------------------------------------
        // setup your test

        // this group accepts null and numeric
        $obj = new RequireAnyOneOfTest_Group1;

        // ----------------------------------------------------------------
        // perform the change

        // if these do not match, an exception is thrown
        $obj(null);
        $obj(1.0);
    }

    /**
     * @covers ::check
     * @dataProvider provideGroup1NoMatches
     * @expectedException GanbaroDigital\Defensive\Exceptions\E4xx_UnsupportedType
     */
    public function testThrowsExceptionIfNothingMatches($item)
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new RequireAnyOneOfTest_Group1;

        // ----------------------------------------------------------------
        // perform the change

        $obj($item);
    }

    public function provideBadRequirements()
    {
        return [
            [ null ],
            [ false ],
            [ true ],
            [ [ 1, 2, 3 ] ],
            [ 3.1415927 ],
            [ 100 ],
            [ new stdClass ]
        ];
    }

    public function provideBadRequirementData()
    {
        return [
            [ null ],
            [ false ],
            [ true ],
            [ 3.1415927 ],
            [ 100 ],
            [ new stdClass ],
            [ "hello, world!" ],
        ];
    }

    public function provideGroup1NoMatches()
    {
        return [
            [ false ],
            [ true ],
            [ "hello, world!" ],
            [ new stdClass ]
        ];
    }
}