/**
 * YouTube 2-Click loader (DEBUG).
 */
define([], function () {
  let bound = false;

  /**
   * Initialise the click handler for YouTube 2-click placeholders.
   */
  function init() {
    console.log("[youtube2click] init() called");

    if (bound) {
      console.log("[youtube2click] already bound, skipping");
      return;
    }
    bound = true;

    document.addEventListener("click", function (e) {
      console.log("[youtube2click] document click detected");

      const btn = e.target.closest(".youtube2click-load");
      if (!btn) {
        return;
      }

      console.log("[youtube2click] load button clicked");

      e.preventDefault();

      const wrapper = btn.closest(".youtube2click-placeholder");
      if (!wrapper) {
        console.log("[youtube2click] no wrapper found");
        return;
      }

      const videoId = wrapper.getAttribute("data-videoid");
      console.log("[youtube2click] videoId:", videoId);

      const iframe = document.createElement("iframe");
      iframe.setAttribute("src", "https://www.youtube.com/embed/" + videoId);
      iframe.setAttribute("frameborder", "0");
      iframe.setAttribute("allowfullscreen", "1");
      iframe.style.width = "100%";
      iframe.style.height = "400px";

      wrapper.replaceWith(iframe);
      console.log("[youtube2click] iframe inserted");
    });
  }

  console.log("[youtube2click] module loaded");

  return {
    init: init,
  };
});
