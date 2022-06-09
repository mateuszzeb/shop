window.addEventListener("load", function () {
  const admin_menu = document.querySelector(".admin_menu");
  if (admin_menu) {
    admin_menu.addEventListener("mouseleave", function () {
      document.querySelector(".admin_menu").style.transform =
        "translate(calc(-100% + 30px), -50%)";
    });
  }
  const admin_menu_btns = document.querySelector(".admin_menu button");
  if (admin_menu_btns) {
    admin_menu_btns.addEventListener("click", function () {
      if (
        document.querySelector(".admin_menu").style.transform ==
        "translate(0px, -50%)"
      ) {
        document.querySelector(".admin_menu").style.transform =
          "translate(calc(-100% + 30px), -50%)";
      } else {
        document.querySelector(".admin_menu").style.transform =
          "translate(0, -50%)";
      }
    });
  }
  const drop_downs = document.querySelectorAll(".drop-down");
  if (drop_downs)
    drop_downs.forEach(function (drop_down) {
      drop_down.querySelector(".content ").style.maxHeight = "0";
      drop_down.addEventListener("click", function (ev) {
        if (ev.target.classList.contains("top")) {
          if (drop_down.querySelector(".content").style.maxHeight != "30000px") {
            drop_down.querySelector(".content").style.maxHeight = "30000px";
            drop_down.classList.add("drop-down-on");
          } else if (drop_down.querySelector(".content").style.maxHeight == "30000px") {
            drop_down.querySelector(".content").style.maxHeight = "0";
            drop_down.classList.remove("drop-down-on");
          }
        }
      });
    });
});
