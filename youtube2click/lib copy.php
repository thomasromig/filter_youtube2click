<?php
defined("MOODLE_INTERNAL") || die();

function filter_youtube2click_page_init(moodle_page $page)
{
    $page->requires->js_call_amd("filter_youtube2click/loader", "init");
    $page->requires->css("/filter/youtube2click/styles.css");
}
