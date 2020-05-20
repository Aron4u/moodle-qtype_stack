<?php
// This file is part of Stack - http://stack.maths.ed.ac.uk/
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

global $CFG;
require_once($CFG->libdir . '/questionlib.php');
require_once(__DIR__ . '/fixtures/test_base.php');

require_once(__DIR__ . '/../stack/input/factory.class.php');

// Unit tests for stack_autocomplete_input.
//
// @copyright  2019 The University of Edinburgh.
// @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.

/**
 * @group qtype_stack
 */
class stack_autocomplete_input_test extends qtype_stack_testcase {

    public function test_render_blank() {
        $ta = '[x^2,[]]';
        $el = stack_input_factory::make('autocomplete', 'ans1', $ta);
        $el->adapt_to_model_answer($ta);
        $this->assertEquals('<input type="text" name="stack1__ans1" id="stack1__ans1" class="autocompleteinput" ' .
                'size="16.5" style="width: 13.6em" autocapitalize="none" spellcheck="false" value="" ' .
                'data-options="[&quot;&quot;]" />',
                $el->render(new stack_input_state(stack_input::VALID, array(), '', '', '', '', ''),
                        'stack1__ans1', false, null));
    }

    public function test_render_blank_allowempty() {
        $ta = '[x^2,[]]';
        $options = new stack_options();
        $el = stack_input_factory::make('autocomplete', 'ans1', $ta);
        $el->adapt_to_model_answer($ta);
        $el->set_parameter('options', 'allowempty');
        $this->assertEquals('<input type="text" name="stack1__ans1" id="stack1__ans1" class="autocompleteinput" ' .
                'size="16.5" style="width: 13.6em" autocapitalize="none" spellcheck="false" value="" ' .
                'data-options="[&quot;&quot;]" />',
                $el->render(new stack_input_state(stack_input::VALID, array(), '', '', '', '', ''),
                        'stack1__ans1', false, null));
    }

    public function test_validate_student_response_0() {
        $options = new stack_options();
        $ta = '[x^2/(1+x^2),[]]';
        $el = stack_input_factory::make('autocomplete', 'sans1', $ta);
        $el->adapt_to_model_answer($ta);
        $el->set_parameter('insertStars', 0);
        $el->set_parameter('strictSyntax', true);

        $state = $el->validate_student_response(array('sans1' => '2x(1+x^2)+tans'), $options, 'x^2/(1+x^2)',
                new stack_cas_security());
        $this->assertEquals(stack_input::INVALID, $state->status);
        $this->assertEquals('missing_stars | Variable_function | forbiddenVariable', $state->note);
    }

    public function test_validate_student_response_1() {
        $options = new stack_options();
        $ta = '[a^2+2*a*b+b^2,[a^2+b^2,(a+b)^2,a^2+2*a*b+b^2]]';
        $el = stack_input_factory::make('autocomplete', 'sans1', $ta);
        $el->adapt_to_model_answer($ta);

        $state = $el->validate_student_response(array('sans1' => 'a^2+2*a*b+b^2'), $options, 'a^2+2*a*b+b^2',
                new stack_cas_security());
        $this->assertEquals(stack_input::VALID, $state->status);
        $this->assertEquals(array('sans1' => 'a^2+2*a*b+b^2', 'sans1_val' => 'a^2+2*a*b+b^2'),
                $el->get_correct_response($ta));
    }

    public function test_validate_student_response_2() {
        $options = new stack_options();
        $ta = '[a^2+2*a*b+b^2,[a^2+b^2,(a+b)^2,a^2+2*a*b+b^2]]';
        $el = stack_input_factory::make('autocomplete', 'sans1', $ta);
        $el->adapt_to_model_answer($ta);

        $state = $el->validate_student_response(array('sans1' => 'a^2+2*a*b+b^2', 'sans1_val' => 'a^2+2*a*b+b^2'),
                $options, 'a^2+2*a*b+b^2', new stack_cas_security());
        $this->assertEquals(stack_input::SCORE, $state->status);
    }
}
