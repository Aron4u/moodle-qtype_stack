# Development track for STACK

Requests for features and ideas for developing STACK are all recorded in [Future plans](Future_plans.md). The
past development history is documented on [Development history](Development_history.md).

How to report bugs and make suggestions is described on the [community](../About/Community.md) page.

## Version 4.2

_STACK 4.2 requires at least Moodle 3.1.0_  Do not upgrade the plugin on an earlier version of Moodle!

Version 4.2 contains re-factored and enhanced code for dealing with Maxima, lisp and platform dependencies.  When upgrading to version 4.2 please expect changes to the settings page, and healthcheck.  You will need to review all setting carefully.

To do:

* Add in a version number to STACK questions.
* Add support for matrices with floating point entries, and testing numerical accuracy.
* Refactor equiv_input and MCQ to make use of the new extra options mechanism.
* Update MCQ to accept units.
* Add a base N check to the numeric input.
* Enable individual questions to load Maxima libraries.  (See issue #305)
* Add an answer test to check if decimal separator is in the wrong place (See issue #314)
* Sort out the "addrow" problem. (See issue #333)
* Expand support for input validation options to matrices (e.g. floatnum, rationalize etc.)
* Add in full parser, to address issue #324.
