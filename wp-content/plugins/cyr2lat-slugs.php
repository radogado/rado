<?php
/*
Plugin Name: Ulanoff.com Cyr2Lat Slugs
Plugin URI: http://ulanoff.com/blogs/codeshack/cyr2lat-slugs
Description: Converts Cyrillic letters in post slugs to their Latin phonetic equivalent to avoid various URL issues.
Version: 1.0
Author: Ruslan Ulanov
Author URI: http://ulanoff.com 
*/

/*  Copyright 2008  Ruslan Ulanov  (email : wp.plugins@ulanoff.com)
    Based on original idea by Petko Bossakov (http://petko.bossakov.eu/)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Cyr2LatSlug 
{
	var $translit_table = array(
	"�"=>'a',
	"�"=>'b',
	"�"=>'v',
	"�"=>'g',
	"�"=>'d',
	"�"=>'e',
	"�"=>'zh',
	"�"=>'z',
	"�"=>'i',
	"�"=>'j',
	"�"=>'k',
	"�"=>'l',
	"�"=>'m',
	"�"=>'n',
	"�"=>'o',
	"�"=>'p',
	"�"=>'r',
	"�"=>'s',
	"�"=>'t',
	"�"=>'u',
	"�"=>'f',
	"�"=>'h',
	"�"=>'c',
	"�"=>'ch',
	"�"=>'sh',
	"�"=>'sch',
	"�"=>'',
	"�"=>'y',
	"�"=>'',
	"�"=>'e',
	"�"=>'yu',
	"�"=>'ya',
	"�"=>'e',
	"�"=>'g',
	"�"=>"e",
	"�"=>'yi',
	"�"=>'i',
	"�"=>'e',
	"�"=>'g',
	"�"=>"e",
	"�"=>'yi',
	"�"=>'i',
	" "=>'-');
	
	function Cyr2LatSlug() {
		add_filter('name_save_pre', array(&$this, 'doCyr2LatSlug'), 1);
	}

	function doCyr2LatSlug($slug) {
		global $wpdb;
		//setlocale(LC_ALL, 'en_US.UTF8');

	    // We don't want to change an existing slug
		if (!empty($slug)) {return $slug;}

		$s = trim($_POST['post_title']);
		$s = iconv('utf-8', 'windows-1251', $s);
		//$s = mb_strtolower($s, 'windows-1251');
		$s = $this->cyr_strtolower(strtolower(stripslashes($s)));
		$s = strtr($s, $this->translit_table);
		return $s;
	}

	function cyr_strtolower($a) {
		// Just in case standard strtolower doesn't work
		// this function is written by Petko Bossakov
		$offset=32;
		$m=array();
		for($i=192;$i<224;$i++){$m[chr($i)]=chr($i+$offset);}
		return strtr($a,$m);
	}
}
$Cyr2LatSlug = new Cyr2LatSlug();
?>