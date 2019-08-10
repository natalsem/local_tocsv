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
/**
 * Plugin 'local_tocsv', branch 'MOODLE_20_STABLE'
 *
 * @copyright  2017 Natalia Sekulich
 * @author     Natalia Sekulich
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once('tocsv_form.php');
require_once ('lib.php');

global $PAGE;
global $CFG;

require_login();

$sitecontext = context_system::instance(0);
$PAGE->set_context($sitecontext);
$PAGE->set_pagelayout('admin');
$title=get_string('title','local_tocsv');
$PAGE->set_url('/local/tocsv/index.php');
$pagedesc=$title;

if (has_capability('moodle/site:config', $sitecontext)) {
    $form = new tocsvform();
    if($data=$form->get_data()){
        $namelist = $data->namelist;
        $lines=explode("\n",$namelist);
        $options=array('city'=>$data->city,'country'=>$data->country,'department'=>$data->department);
        $users = prepare_usersdata($lines, $options);
        $file_time=date('Ymdhis');
        $csv = create_csv_file($users);
        create_file($csv);
    }else {
        echo $OUTPUT->header();
        $form->display();
        $html = get_string('gotoupload','local_tocsv') . html_writer::link(
            $CFG->httpswwwroot . '/admin/tool/uploaduser/index.php',  get_string('uploadusers', 'tool_uploaduser')
            );
        echo format_text($html, FORMAT_HTML, array('trusted' => true, 'noclean' => true, 'filter' => false));
        echo $OUTPUT->footer();
    }

}else {
    throw new moodle_exception('requireloginerror');
}


