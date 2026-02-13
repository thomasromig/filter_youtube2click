define([], function () {
  function init() {
    // Nur einmal binden (Sicherheitsnetz)
    console.log("youtube2click init called"); // <-- DEBUG
    // ...
    if (window.__youtube2clickBound) {
      return;
    }
    window.__youtube2clickBound = true;

    document.addEventListener("click", function (e) {
      const btn = e.target.closest(".youtube2click-load");
      if (!btn) {
        return;
      }

      e.preventDefault();

      const wrapper = btn.closest(".youtube2click-placeholder");
      if (!wrapper) {
        return;
      }

      const videoId = wrapper.getAttribute("data-videoid");

      const iframe = document.createElement("iframe");
      iframe.setAttribute("src", "https://www.youtube.com/embed/" + videoId);
      iframe.setAttribute("frameborder", "0");
      iframe.setAttribute("allowfullscreen", "1");
      iframe.style.width = "100%";
      iframe.style.height = "400px";

      wrapper.replaceWith(iframe);
    });
  }

  // 🔥 WICHTIG: Sofort initialisieren, sobald das Modul geladen wird
  init();

  // Und zusätzlich exportieren (falls Moodle es doch noch explizit aufruft)
  return {
    init: init,
  };
});
