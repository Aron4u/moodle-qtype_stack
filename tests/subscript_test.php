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

defined('MOODLE_INTERNAL') || die();

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
require_once(__DIR__ . '/fixtures/subscriptsfixtures.class.php');

/**
 * Unit tests for all answertests.
 *
 * @copyright  2016 The University of Edinburgh
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @group qtype_stack
 */
class stack_subscript_test extends qtype_stack_testcase {

    /**
     * @dataProvider subscripts_fixtures
     */
    public function test_subscripts($testrep, $resultfalse, $resulttrue) {
        if ('invalid' == $resultfalse->maxima) {
            $this->assertFalse($resultfalse->valid);
        } else {
            $this->assertEquals($resultfalse->maxima, $resultfalse->value);
            $this->assertEquals($resultfalse->tex, $resultfalse->display);
        }

        if ('invalid' == $resulttrue->maxima) {
            $this->assertFalse($resulttrue->valid);
        } else {
            $target = $resulttrue->maxima;
            if ($resulttrue->maximasimp != '!') {
                $target = $resulttrue->maximasimp;
            }
            $this->assertEquals($target, $resulttrue->value);
            $target = $resulttrue->tex;
            if ($resulttrue->maximasimp != '!') {
                $target = $resulttrue->texsimp;
            }
            $this->assertEquals($target, $resulttrue->display);
        }
    }

    public function subscripts_fixtures() {

        $tests = stack_subscripts_test_data::get_raw_test_data();

        $testdata = array();
        foreach ($tests as $data) {
            $test1 = stack_subscripts_test_data::test_from_raw($data);
            $resultfalse = stack_subscripts_test_data::run_test($test1, false);

            $test2 = stack_subscripts_test_data::test_from_raw($data);
            $resulttrue = stack_subscripts_test_data::run_test($test2, true);

            $testrep = $test1->rawinput . ' | ' . $test1->tex;

            $testdata[] = array($testrep, $resultfalse, $resulttrue);
        }
        return $testdata;
    }
}
