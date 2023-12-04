import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";

(function ($) {

gsap.registerPlugin(ScrollTrigger);

ScrollTrigger.defaults({
  markers: false
});
  
$(".hero-section").each(function (index) {
  let triggerElement = $(this);
  let targetElement = $("#logotipo-punto");

  let tl = gsap.timeline({
    scrollTrigger: {
      trigger: triggerElement,
      start: "top top",
      end: "bottom top",
      scrub: 1
    }
  });

  let mm = gsap.matchMedia();

    mm.add("(min-width: 1367px)", () => {
      tl.from(targetElement, {
          width: "350px",
          y: "380px",
          x: "1000px",
          duration: 1
        }
      );
    });

    mm.add("(min-width: 1024px) and (max-width: 1366px)", () => {
        tl.from(targetElement, {
            width: "350px",
            y: "380px",
            x: "1000px",
            duration: 1
          }
        );
    });
});

})(jQuery);