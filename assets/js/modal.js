document.addEventListener("DOMContentLoaded", function () {
  console.log("[Micromodal] DOM loaded");

  if (typeof MicroModal !== "undefined") {
    console.log("[Micromodal] Found MicroModal, initializing...");
    MicroModal.init({
      awaitOpenAnimation: true,
      awaitCloseAnimation: true,
      disableScroll: true,
    });
  } else {
    console.error("[Micromodal] MicroModal is not defined.");
  }
});
