// ---------------------------------------- SEARCH ----------------------------------------
document.addEventListener("DOMContentLoaded", function () {
  const searchContainers = document.querySelectorAll(".form-field-search");

  function updateOptions() {
    const selectedValues = Array.from(searchContainers)
      .map((container) => {
        const soValue = container.querySelector('input[type="text"][readonly]');
        return soValue ? soValue.dataset.id : null;
      })
      .filter(Boolean);

    searchContainers.forEach((container) => {
      const optionsList = container.querySelectorAll("li");
      optionsList.forEach((option) => {
        if (
          option &&
          option.dataset &&
          selectedValues.includes(option.dataset.id)
        ) {
          option.style.display = "none";
        } else if (option) {
          option.style.display = "";
        }
      });
    });
  }

  function addClickAndTouchListener(element, callback) {
    if (element) {
      element.addEventListener("click", callback);
    }
  }

  searchContainers.forEach(function (container) {
    const selectOption = container.querySelector(".form-select-option");
    const soValue = container.querySelector('input[type="text"][readonly]');
    const optionSearch = container.querySelector(
      'input[type="text"]:not([readonly])'
    );
    const options = container.querySelector(".form-search-option");
    const optionsList = options
      ? options.querySelectorAll("li.search-element")
      : [];

    addClickAndTouchListener(selectOption, function () {
      container.classList.toggle("active");
    });

    if (!document.getElementById("projects-header")) {
      optionsList.forEach(function (optionsListSingle) {
        addClickAndTouchListener(optionsListSingle, function () {
          const text = this.textContent;
          userId = this.dataset.id;
          if (soValue) {
            soValue.value = text;
            soValue.dataset.id = userId;
          }
          container.classList.toggle("active");
          updateOptions();
        });
      });
    }

    if (optionSearch) {
      optionSearch.addEventListener("input", function () {
        const filter = optionSearch.value.toUpperCase();
        optionsList.forEach(function (option) {
          if (option) {
            const text = option.textContent.toUpperCase();
            if (text.includes(filter)) {
              option.style.display = "";
            } else {
              option.style.display = "none";
            }
          }
        });
      });
    }

    const form = document.querySelector("form");
    if (form) {
      form.addEventListener("submit", function () {
        const userId = soValue ? soValue.dataset.id : "";
        const hiddenInput = document.createElement("input");
        hiddenInput.type = "hidden";
        hiddenInput.name = soValue ? soValue.name : "";
        hiddenInput.value = userId;
        form.appendChild(hiddenInput);
      });
    }
  });

  updateOptions();

  // ---------------------------------------- SCROLL ANIMATIONS ----------------------------------------
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("show");
      }
    });
  });

  const hiddenElements = document.querySelectorAll(".hidden");
  hiddenElements.forEach((el) => observer.observe(el));

  // ---------------------------------------- HANDLE MENU ----------------------------------------
  var burger = document.getElementById("burger");
  var headerMenu = document.getElementById("header");

  if (burger && headerMenu) {
    burger.addEventListener("click", function () {
      headerMenu.classList.toggle("open");
      burger.classList.toggle("open");
      document.body.classList.toggle("no-scroll");
    });
  }
});
