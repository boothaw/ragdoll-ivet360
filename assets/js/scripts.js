$ = jQuery;

// ─── GSAP: scroll-triggered fade-in selectors ────────────────────────────────
const scrollFadeSelectors = [
  ".card-item",
  ".entry-content > .wp-block-heading",
  ".entry-content > p",
  ".entry-content > ul",
  ".image-content-block .image-section",
  ".image-content-block .content-section > *",
  ".full-width-col h2",
  ".testimonial-card",
  ".wp-block-buttons",
  ".accordion-block",
  ".footer .lite-card",
  ".visit-cta",
  ".wp-block-columns.lite-card",
  ".gform_wrapper",
  ".dvm-team-container-inner",
  ".staff-team-container-inner",
  ".staff-container > h2",
  ".wp-block-columns.inner-wrapper.lite-card .wp-block-column > *",
  ".contact-sidebar .lite-card",
  ".contact-sidebar iframe",
  ".service-item",
  ".page-template-services-page .entry-content > .wp-block-columns:not(.full-width-col) .wp-block-column:first-of-type",
];

// On basic-post and basic-page templates, skip fade-ins for anything inside .entry-content.
const skipEntryContentFades =
  document.body.classList.contains("post-template-basic-post") ||
  document.body.classList.contains("page-template-basic");

function getScrollFadeEls(selector) {
  let els = Array.from(document.querySelectorAll(selector));
  if (skipEntryContentFades) {
    els = els.filter((el) => !el.closest(".entry-content"));
  }
  return els;
}

// Hide them immediately to prevent flash before ScrollTrigger picks them up.
if (typeof gsap !== "undefined") {
  const elsToHide = scrollFadeSelectors.flatMap(getScrollFadeEls);
  if (elsToHide.length) gsap.set(elsToHide, { opacity: 0, y: 40 });
}

// ─── HAMBURGER MENU ──────────────────────────────────────────────────────────
function hamburgerMenu() {
  const hamburger = document.getElementById("hamburger");
  const mobileMenu = document.getElementById("mobile-menu-container");
  const subMenus = document.getElementsByClassName("sub-menu");
  let hamburgerOpen = false;

  hamburger.addEventListener("click", () => {
    if (!hamburgerOpen) {
      let subMenuTotals = 0;
      for (let i = 0; i < subMenus.length; i++) {
        subMenuTotals += parseInt(subMenus[i].scrollHeight);
      }
      hamburger.classList.add("open");
      hamburgerOpen = true;
      mobileMenu.style.maxHeight =
        mobileMenu.scrollHeight + subMenuTotals + "px";
    } else {
      hamburger.classList.remove("open");
      hamburgerOpen = false;
      mobileMenu.style.maxHeight = null;
    }
  });
}

function animateElement(e, className, duration) {
  const elements = document.getElementsByClassName(e);
  for (let i = 0; i < elements.length; i++) {
    setTimeout(
      () => elements[i].classList.add(className),
      i * parseInt(duration),
    );
  }
}

// ─── ONLOAD ──────────────────────────────────────────────────────────────────
window.onload = function () {
  if (!document.body.classList.contains("page-template-landing")) {
    // Disable href="#" links
    const menuItems = document.getElementsByClassName("menu-item");
    for (let i = 0; i < menuItems.length; i++) {
      if (menuItems[i].children[0].href === `${window.location.href}#`) {
        menuItems[i].children[0].addEventListener("click", (e) =>
          e.preventDefault(),
        );
      }
    }

    // Desktop nav: add dropdown arrow icons
    document.querySelectorAll("#menu .menu > li").forEach((item) => {
      if (item.querySelector("ul")) {
        const svg = document.createElementNS(
          "http://www.w3.org/2000/svg",
          "svg",
        );
        svg.setAttribute("width", "10");
        svg.setAttribute("height", "7");
        svg.setAttribute("viewBox", "0 0 10 7");
        svg.classList.add("menu-chevron");
        const path = document.createElementNS(
          "http://www.w3.org/2000/svg",
          "path",
        );
        path.setAttribute("d", "M1 1L5 6L9 1");
        svg.appendChild(path);
        item.appendChild(svg);
      }
    });

    hamburgerMenu();
    animateElement("hero-fade", "fade-in", 250);

    // Mobile nav: submenu toggles
    const mobileMenu = document.getElementById("mobile-menu-container");
    if (mobileMenu) {
      const subMenus = mobileMenu.children[0].children[0].children;
      for (let i = 0; i < subMenus.length; i++) {
        if (subMenus[i].classList.contains("menu-item-has-children")) {
          const icon = document.createElement("i");
          icon.className = "fas fa-chevron-right";
          subMenus[i].querySelector("a").after(icon);

          subMenus[i].addEventListener("click", function () {
            const isOpen = this.classList.contains("sub-menu-open");
            this.querySelector("i").classList.toggle("rotate", !isOpen);
            this.classList.toggle("sub-menu-open", !isOpen);
            this.querySelector(".sub-menu").style.maxHeight = isOpen
              ? null
              : this.querySelector(".sub-menu").scrollHeight + "px";
          });
        }
      }
    }

    if ($(".accordion").length) {
      $(".accordion .body").hide();
      $(".accordion .head").click(function () {
        $(this).next().slideToggle();
      });
    }
  }

  // ─── GSAP animations ───────────────────────────────────────────────────────
  if (typeof gsap !== "undefined") {
    const h1 = document.querySelector(".entry-title h1");
    const thumb = document.querySelector(".thumbnail-image");
    const excerpts = Array.from(document.querySelectorAll(".entry-title p"));
    const buttons = document.querySelector(".entry-title .buttons-ctn");
    const nav = document.querySelector(".nav-header-inner");

    const tl = gsap.timeline({
      defaults: { ease: "power1.out", duration: 0.3 },
    });
    const tl2 = gsap.timeline({
      defaults: { ease: "power1.inOut", duration: 0.3 },
    });
    const tl3 = gsap.timeline({
      defaults: { ease: "power3.inOut", duration: 0.7 },
    });

    const header = document.querySelector(".header");
    if (header) {
      tl.fromTo(
        header,
        { "--header-reveal": "0%" },
        { "--header-reveal": "100%", duration: 0.2, ease: "power1.out" },
        0,
      );
    }

    const phase1 = [nav].filter(Boolean);
    if (phase1.length) {
      tl.fromTo(phase1, { opacity: 0 }, { opacity: 1 }, 0);
    }

    const phase2 = [h1, ...excerpts, buttons].filter(Boolean);
    if (phase2.length) {
      tl2.fromTo(
        phase2,
        { opacity: 0, y: 40 },
        { opacity: 1, y: 0, stagger: 0.1 },
        0,
      );
    }
    const phase3 = [thumb].filter(Boolean);
    if (phase3.length) {
      tl3.fromTo(phase3, { opacity: 0 }, { opacity: 1 }, 0);
    }

    // ─── Scroll-triggered fade-ins ─────────────────────────────────────────
    if (typeof ScrollTrigger !== "undefined") {
      gsap.registerPlugin(ScrollTrigger);

      const staggeredSelectors = [
        ".testimonial-card",
        ".card-item",
        ".footer .lite-card",
        ".staff-team-container-inner",
      ];

      scrollFadeSelectors.forEach((selector) => {
        const els = getScrollFadeEls(selector);
        if (!els.length) return;

        if (staggeredSelectors.includes(selector)) {
          ScrollTrigger.batch(els, {
            start: "top 95%",
            onEnter: (batch) =>
              gsap.to(batch, {
                opacity: 1,
                y: 0,
                ease: "power1.in",
                duration: 0.2,
                stagger: 0.1,
              }),
          });
        } else {
          els.forEach((el) => {
            gsap.to(el, {
              opacity: 1,
              y: 0,
              ease: "power1.inOut",
              duration: 0.3,
              scrollTrigger: {
                trigger: el,
                start: "top 95%",
              },
            });
          });
        }
      });
    }
  }

  testimonialSlider();
  lpSlider();
  enableImageModals();
  moveEars();
  setInterval(moveEars, 4000);
};

// ─── EARS ANIMATION ──────────────────────────────────────────────────────────
const moveEars = () => {
  const earSvgs = document.querySelectorAll(".ears");
  earSvgs.forEach((svg, i) => {
    setTimeout(() => {
      earSvgs.forEach((s) => s.classList.remove("ears-active"));
      svg.classList.add("ears-active");
    }, i * 1000);
  });
};

// ─── LP SLIDER ───────────────────────────────────────────────────────────────
function lpSlider() {
  let slCounter = 0;
  const slSlideArray = $(".sl-lp-content").toArray();
  $(slSlideArray).hide();
  $(slSlideArray[0]).show();

  function setCounter(increment) {
    $(slSlideArray[slCounter]).hide();
    slCounter = increment;
    $(slSlideArray[slCounter]).show();
  }

  function changeSlides() {
    setCounter(slCounter < slSlideArray.length - 1 ? slCounter + 1 : 0);
  }

  let myTimer = setInterval(changeSlides, 5000);

  $(".sl-lp-right").click(function () {
    clearInterval(myTimer);
    myTimer = setInterval(changeSlides, 5000);
    changeSlides();
  });

  $(".sl-lp-left").click(function () {
    clearInterval(myTimer);
    setCounter(slCounter > 0 ? slCounter - 1 : slSlideArray.length - 1);
  });
}

// ─── IMAGE MODALS ─────────────────────────────────────────────────────────────
function enableImageModals() {
  document
    .querySelectorAll(".new-lp .hero-card img.modal-on")
    .forEach((img) => {
      img.style.cursor = "pointer";
      img.addEventListener("click", (event) => {
        event.preventDefault();

        const dialog = document.createElement("dialog");
        const modalContainer = document.createElement("div");
        modalContainer.className = "modal-container";

        const closeBtn = document.createElement("button");
        closeBtn.textContent = "✕";
        closeBtn.className = "close-btn";
        closeBtn.addEventListener("click", (e) => {
          e.stopPropagation();
          dialog.close();
          dialog.remove();
        });
        dialog.addEventListener("click", (e) => {
          if (e.target === dialog) {
            dialog.close();
            dialog.remove();
          }
        });

        modalContainer.appendChild(closeBtn);
        modalContainer.appendChild(img.cloneNode());
        dialog.appendChild(modalContainer);
        document.body.appendChild(dialog);
        dialog.showModal();
      });
    });
}

// ─── TESTIMONIAL SLIDER ──────────────────────────────────────────────────────
function testimonialSlider({ debug = false } = {}) {
  const carousel = document.querySelector(
    ".testimonial-section .carousel-body",
  );
  if (!carousel) return;

  const inner = carousel.querySelector(".carousel-inner");
  const arrow = document.querySelector(".testimonial-section .title-arrow");
  const cards = Array.from(carousel.getElementsByClassName("carousel-card"));
  if (!inner || !arrow || cards.length === 0) return;

  arrow.addEventListener("click", () => {
    const style = window.getComputedStyle(cards[0]);
    const increment =
      cards[0].offsetWidth + (parseFloat(style.marginRight) || 0);
    inner.scrollBy({ left: increment, behavior: "smooth" });
  });
}

// ─── FIRST ACCORDION CLASS (homepage) ────────────────────────────────────────
(function () {
  if (!document.body?.classList.contains("home")) return;

  function mark() {
    const first = document.querySelector(".entry-content .accordion-block");
    if (first && !first.classList.contains("first-accordion")) {
      first.classList.add("first-accordion");
    }
    return !!first;
  }

  function init() {
    if (mark()) return;
    const root = document.querySelector(".entry-content") || document.body;
    const observer = new MutationObserver((_, obs) => {
      if (mark()) obs.disconnect();
    });
    observer.observe(root, { childList: true, subtree: true });
    setTimeout(() => observer.disconnect(), 5000);
  }

  document.readyState === "loading"
    ? document.addEventListener("DOMContentLoaded", init)
    : init();
})();
