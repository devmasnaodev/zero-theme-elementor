(function ($) {
  let zt_main_navbar = {
    $navbar: "",

    init: function () {
      this.$navbar = document.querySelector(".js-main-navbar");
      let $navbar_v2 = document.querySelector(".js-main-navbar-default");

      if (this.$navbar){
        zt_main_navbar.$navbar.style.transition = "all .2s ease-out";

        document.body.onscroll = () => {
          this.scrollFunction(350);
        };
      };

      if ($navbar_v2){
        this.$navbar = $navbar_v2;
        zt_main_navbar.$navbar.style.transition = "all .2s ease-out";

        document.body.onscroll = () => {
          this.scrollFunction(120);
        };
      };

      return;
    },

    scrollFunction: function (px) {
      if (
        document.body.scrollTop > px ||
        document.documentElement.scrollTop > px
      ) {
        zt_main_navbar.$navbar.classList.add("scroll");
      } else {
        zt_main_navbar.$navbar.classList.remove("scroll");
      }
    },
  };

  // When Elementor was loaded Hack
  window.addEventListener("elementor/frontend/init", () => {
    setTimeout(function () {
      zt_main_navbar.init();
    }, 20);
  });

})(jQuery);
