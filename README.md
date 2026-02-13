# Moodle YouTube Two-Click Filter

A Moodle filter plugin that replaces YouTube embeds and links with a privacy-friendly
two-click solution. The video is only loaded after the user explicitly clicks a button.

This helps to avoid loading external content and tracking scripts before user consent
(e.g. for GDPR / privacy compliance).

## Features

- Replaces YouTube embeds and YouTube links in course content
- Shows a thumbnail preview with an overlay and a consent button
- Loads the YouTube iframe only after the user clicks
- Works with TinyMCE embeds
- No YouTube requests before user interaction
- Lightweight and simple

## How it works

Instead of directly embedding the YouTube iframe, the filter renders:

- The video thumbnail
- A privacy notice text
- A "Load video" button

Only after the user clicks the button, the real YouTube iframe is inserted into the page.

## Installation

1. Copy or clone this plugin into your Moodle installation:

