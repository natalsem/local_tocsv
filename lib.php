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
 *
 * File : lib.php
 * Library functions
 */
function local_tocsv_extend_settings_navigation($settingsnav, $context) {
    global $CFG, $PAGE;
    if ($settingnode = $settingsnav->find('root', navigation_node::TYPE_SITE_ADMIN)) {
        $url = new moodle_url('/local/tocsv/index.php');
        $menu = $settingnode->add(get_string('pluginname', 'local_tocsv'),
            $url, 'tocsv');
        if ($PAGE->url->compare($url, URL_MATCH_BASE)) {
            $menu->make_active();
        }
    }
}

function local_tocsv_extend_navigation(global_navigation $navigation) {
    global $PAGE;
    if ($home = $navigation->find('home', global_navigation::TYPE_SETTING)) {
        $home->remove();
    }
    if ($settingnode = $navigation->find('root', navigation_node::TYPE_SITE_ADMIN)) {
        $strfoo = get_string('pluginsettings', 'local_csv');
        $url = new moodle_url('/local/tocsv/settings.php');
        $foonode = navigation_node::create(
            $strfoo,
            $url,
            navigation_node::NODETYPE_LEAF,
            'local_csv',
            'pluginsettings',
            new pix_icon('t/addcontact', $strfoo)
        );
        if ($PAGE->url->compare($url, URL_MATCH_BASE)) {
            $foonode->make_active();
        }
        $settingnode->add_node($foonode);
    }
}

function prepare_usersdata($data, $options){
    $users=[];
    foreach ($data as $line) {
        $lastname='';
        $firstname='';
        $middlename='';
        $person_data = explode(',',$line);
        $fio=explode(' ',$person_data[0]);
        if(isset($fio[0]))$lastname=trim($fio[0]);
        if(isset($fio[1]))$firstname=trim($fio[1]);
        if(isset($fio[2]))$middlename=trim($fio[2]);
        $users[]=[
            'username'=>trim($person_data[1]),
            'email'=>trim($person_data[1]),
            'lastname'=>$lastname,
            'firstname'=>$firstname,
            'middlename'=>$middlename,
            'department'=>trim($options['department']),
            'city'=>trim($options['city']),
            'country'=>trim($options['country'])
        ];
    }
    return $users;

}

function create_csv_file($users){
    $content='';
    $title='username;email;lastname;firstname;middlename;department;city;country';
    $content.=$title."\r\n";
    foreach ($users as $user) {
        $content.=implode(';', $user)."\r\n";
    }
    return $content;

}
function create_file($result){
    $filename='users_'.date('Y-m-d_Hms').'.csv';
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0\r\n");
    header("Cache-Control: private\r\n");
    header ("Content-Type: text/plain; charset=UTF-8\r\n");
    header("Content-Disposition: attachment; filename=\".$filename\"\r\n");
    echo $result;
    die();
}

