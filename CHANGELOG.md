# CHANGELOG

## develop branch

### New

* Contracts\AssertValue - checks that a value meets a given expression
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