<?php
defined("MOODLE_INTERNAL") || die();

return [
    [
        "hook" => \core\hook\output\before_standard_html_head::class,
        "callback" => "filter_youtube2click_before_standard_html_head",
        "priority" => 0,
    ],
];
