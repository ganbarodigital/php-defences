# CHANGELOG

## develop branch

Nothing yet.

### Fixes

* RequireAnyOneOf - now accepts callables for requirements (instead of requiring only callable objects)

## 1.0.0 - Wed Jul 22 2015

Initial release. Largely based on Stuart's old ContractLib2.

### New

* Contracts\AssertValue - checks that a value meets a given expression
* Contracts\EnsureValue - alias for AssertValue for readability
* Contracts\ForAll - apply a check to every value in an array
* Contracts\RequireValue - alias for AssertValue for readability
* Contracts\RunPreconditions - run contract checks if wrapped contracts are enabled
* Contracts\UnreachableCode - return exception when executed
* Contracts\WrappedContracts - manages whether wrapped contracts are to be checked or not
* Exceptions\E4xx_BadRequirementData - a requirements container has been given data it cannot use
* Exceptions\E4xx_BadRequirements - a requirements contianer has been given requirements it cannot use
* Exceptions\Exxx_DefensiveException - base catchable for all exceptions thrown by this library
* Exceptions\E4xx_DefensiveException - base catchable for all "bad input" exceptions
* Exceptions\E4xx_UnsupportedType - thrown when a bad type is passed into a method
* Exceptions\E5xx_ContractFailed - thrown when any of the Contracts\* checks fail
* Exceptions\E5xx_DefensiveException - base catchable for all "programmer error" exceptions
* Requirements\RequireAllOf - a requirements container where every requirement has to be matched
* Requirements\RequireAnyOneOf - a requirements container where only one requirement has to be matched