<?php
namespace filter_youtube2click;

defined("MOODLE_INTERNAL") || die();

class text_filter extends \core_filters\text_filter
{
    public function filter($text, array $options = [])
    {
        if (!is_string($text) || empty($text)) {
            return $text;
        }

        if (
            stripos($text, "youtube.com") === false &&
            stripos($text, "youtu.be") === false
        ) {
            return $text;
        }

        // JS & CSS direkt und zuverlässig einbinden.
        if (!empty($this->page)) {
            $this->page->requires->css("/filter/youtube2click/styles.css");

            $js = <<<'JS'
            (function() {
                if (window.__youtube2clickBound) {
                    return;
                }
                window.__youtube2clickBound = true;

                document.addEventListener('click', function(e) {
                    var btn = e.target.closest('.youtube2click-load');
                    if (!btn) {
                        return;
                    }
                    e.preventDefault();

                    var wrapper = btn.closest('.youtube2click-placeholder');
                    if (!wrapper) {
                        return;
                    }

                    var videoId = wrapper.getAttribute('data-videoid');

                    var iframe = document.createElement('iframe');
                    iframe.setAttribute('src', 'https://www.youtube.com/embed/' + videoId);
                    iframe.setAttribute('frameborder', '0');
                    iframe.setAttribute('allowfullscreen', '1');
                    iframe.style.width = '100%';
                    iframe.style.height = '400px';

                    wrapper.replaceWith(iframe);
                });
            })();
            JS;

            $this->page->requires->js_init_code($js);
        }

        // 1) Ganze YouTube-IFRAMES ersetzen (z.B. Tiny Embed)
        $pattern_iframe =
            '#<iframe[^>]+src="https?://(?:www\.)?(?:youtube\.com/embed/|youtube\.com/watch\?v=|youtu\.be/)([^"?&/ ]+)[^"]*"[^>]*>.*?</iframe>#is';

        $text = preg_replace_callback(
            $pattern_iframe,
            function ($matches) {
                return $this->render_placeholder($matches[1]);
            },
            $text,
        );

        // 2) Ganze <a>-Tags mit YouTube-Link ersetzen
        $pattern_linktag =
            '#<a[^>]+href="https?://(?:www\.)?(?:youtube\.com/watch\?v=|youtu\.be/)([^"&?/ ]+)[^"]*"[^>]*>.*?</a>#is';

        $text = preg_replace_callback(
            $pattern_linktag,
            function ($matches) {
                return $this->render_placeholder($matches[1]);
            },
            $text,
        );

        return $text;
    }

    protected function render_placeholder($videoid)
    {
        $thumb = "https://i.ytimg.com/vi/" . $videoid . "/hqdefault.jpg";
        $warning = get_string("privacywarning", "filter_youtube2click");
        $button = get_string("loadvideo", "filter_youtube2click");

        return '
    <div class="youtube2click-placeholder" data-videoid="' .
            s($videoid) .
            '">
        <div class="youtube2click-thumb" style="background-image:url(' .
            s($thumb) .
            ');">
            <div class="youtube2click-overlay">
                <p>' .
            s($warning) .
            '</p>
                <button type="button" class="youtube2click-load">' .
            s($button) .
            '</button>
            </div>
        </div>
    </div>
    <script>
    (function() {
        if (window.__youtube2clickBound) {
            return;
        }
        window.__youtube2clickBound = true;

        document.addEventListener("click", function(e) {
            var btn = e.target.closest(".youtube2click-load");
            if (!btn) {
                return;
            }
            e.preventDefault();

            var wrapper = btn.closest(".youtube2click-placeholder");
            if (!wrapper) {
                return;
            }

            var videoId = wrapper.getAttribute("data-videoid");

            var iframe = document.createElement("iframe");
            iframe.setAttribute("src", "https://www.youtube.com/embed/" + videoId);
            iframe.setAttribute("frameborder", "0");
            iframe.setAttribute("allowfullscreen", "1");
            iframe.style.width = "100%";
            iframe.style.height = "400px";

            wrapper.replaceWith(iframe);
        });
    })();
    </script>
    ';
    }
}
