<?php
// This file is part of the TOCSV plugin for Moodle - http://moodle.org/
//
// TOCSV plugin is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// TOCSV plugin is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with TOCSV plugin.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This plugin for Moodle is used to prepare a CSV-file through a web form.
 *
 * @copyright  2017 Natalia Sekulich
 * @author     Natalia Sekulich sekulich.n@gmail.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->libdir.'/formslib.php');

class tocsvform extends moodleform {

    public function definition() {
        global $CFG;

        $mform = $this->_form;
        $mform->addElement('header', 'general', get_string('form_header','local_tocsv'));

        $mform->addHelpButton('general', 'header','local_tocsv');

        $mform->addElement('text','department')->setLabel(get_string('department'));
        $mform->setType('department', PARAM_CLEANHTML);
//        $mform->addHelpButton('department', 'department_help','local_tocsv');

        $mform->addElement('text','city')->setLabel(get_string('city'));
        $mform->setType('city', PARAM_CLEANHTML);
        $mform->setDefault('city',core_user::get_property_default('city'));

        $choices = get_string_manager()->get_list_of_countries();
        $choices = array('' => get_string('selectacountry') . '...') + $choices;
        $mform->addElement('select', 'country', get_string('selectacountry'), $choices);
        if (!empty($CFG->country)) {
            $mform->setDefault('country', core_user::get_property_default('country'));
        }

        $mform->addElement('textarea', 'namelist','NameList',['cols' => 70, 'rows' => 12])->setLabel(get_string('lastname').' '.get_string('firstname').' '.get_string('middlename').',  '.get_string('email').get_string('namelist_header','local_tocsv'));
        $mform->setType('namelist', PARAM_CLEANHTML);
        $mform->addRule('namelist', get_string('missingnamelist','local_tocsv'), 'required', null, 'client');

        $mform->setDefault('namelist', 'Иванова Наталья Ивановна, ivanova@example.com '.PHP_EOL.'Петров Петр Сергеевич, petro@example.com');
        $mform->addHelpButton('namelist', 'namelist','local_tocsv');

        $this->add_action_buttons(false, get_string('download'));
    }

    function validation($data, $files) {
        return array();
    }


}