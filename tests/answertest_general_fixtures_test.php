<?php
// This file is part of Stack - http://stack.maths.ed.ac.uk//
//
// Stack is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Stack is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Stack.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Add in all the tests from answertestsfixtures.class into the unit testing framework.
 * While these are exposed to users as documentation, the Travis integration should also
 * run all the tests.
 *
 * @copyright  2016 The University of Edinburgh
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(__DIR__ . '/../locallib.php');
require_once(__DIR__ . '/../stack/answertest/controller.class.php');
require_once(__DIR__ . '/../stack/options.class.php');
require_once(__DIR__ . '/fixtures/test_base.php');
require_once(__DIR__ . '/fixtures/answertestfixtures.class.php');

/**
 * Unit tests for all answertests.
 *
 * @copyright  2016 The University of Edinburgh
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @group qtype_stack
 */
class stack_answertest_fixtures_cas_test extends qtype_stack_testcase {
    /**
     * @dataProvider answertest_fixtures
     */

    public function test_answertest($testrep, $passed, $ansnote, $expectednote) {
            $this->assertTrue($passed);
            $this->assertEquals($expectednote, $ansnote);
    }

    public function answertest_fixtures() {

        $testdata = array();
        // Get the list of available tests.
        $tests = stack_answertest_test_data::get_all();

        foreach ($tests as $test) {
            $testrep = 'AT' . $test->name . "( " . $test->studentanswer . ", " .$test->teacheranswer. ")";
            if ($test->options != '') {
                $testrep .= ' Options: ' . $test->options;
            }

            list($passed, $error, $rawmark, $feedback, $ansnote, $anomalynote) = stack_answertest_test_data::run_test($test);
            $testdata[] = array($testrep, $passed, $ansnote, $test->ansnote);
        }
        return $testdata;
    }

}
