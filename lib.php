<?php
defined("MOODLE_INTERNAL") || die();

/**
 * Hook callback to load JS/CSS for the YouTube 2-click filter.
 */
function filter_youtube2click_before_standard_html_head(): void
{
    global $PAGE;

    // Load CSS.
    $PAGE->requires->css("/filter/youtube2click/styles.css");

    // Load AMD module.
    $PAGE->requires->js_call_amd("filter_youtube2click/loader", "init");
}
