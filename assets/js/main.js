//============================================ Sidebar ============================================
// jQuery(function() {
//
//   if (jQuery(".sidebar").length > 0) {
//     var Scrollbar = window.Scrollbar;
//     Scrollbar.init(document.querySelector('.sidebar'));
//   }
// });

function openNav() {
  document.getElementById("menuSidebar").style.width = "240px";
  document.getElementById("main").style.marginLeft = "240px";
}

function closeNav() {
  document.getElementById("menuSidebar").style.width = "0";
  document.getElementById("main").style.marginLeft = "0";
}

//============================================ Sidebar ============================================

// ======================================== Accordion ============================================
const accordionItems = document.querySelectorAll(".accord-item");

accordionItems.forEach((item) => {
  const header = item.querySelector(".accord-main");
  const content = item.querySelector(".accordion-content");

  header.addEventListener("click", () => {
    item.classList.toggle("active");
    if (item.classList.contains("active")) {
      content.style.maxHeight = content.scrollHeight + "px";
    } else {
      content.style.maxHeight = "0";
    }
  });
});

// ======================================== Accordion ============================================

// ======================================== Dropdown ============================================

const feedback = document.getElementById("feedback");
const toggleDropdownButton = () => {
  feedback.classList.toggle("open");
};

const notification = document.getElementById("notification");
const notificationBtn = () => {
  notification.classList.toggle("open");
};

// ======================================== Dropdown ============================================

// ======================================== AutoComplete ============================================
function autocomplete(inp, arr) {
  var currentFocus;
  inp.addEventListener("input", function (e) {
    var a,
      b,
      i,
      val = this.value;
    closeAllLists();
    if (!val) {
      return false;
    }
    currentFocus = -1;
    a = document.createElement("DIV");
    a.setAttribute("id", this.id + "autocomplete-list");
    a.setAttribute("class", "autocomplete-items");
    this.parentNode.appendChild(a);
    for (i = 0; i < arr.length; i++) {
      if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
        b = document.createElement("DIV");
        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
        b.innerHTML += arr[i].substr(val.length);
        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
        b.addEventListener("click", function (e) {
          inp.value = this.getElementsByTagName("input")[0].value;
          closeAllLists();
        });
        a.appendChild(b);
      }
    }
  });
  inp.addEventListener("keydown", function (e) {
    var x = document.getElementById(this.id + "autocomplete-list");
    if (x) x = x.getElementsByTagName("div");
    if (e.keyCode == 40) {
      currentFocus++;
      addActive(x);
    } else if (e.keyCode == 38) {
      currentFocus--;
      addActive(x);
    } else if (e.keyCode == 13) {
      e.preventDefault();
      if (currentFocus > -1) {
        if (x) x[currentFocus].click();
      }
    }
  });
  function addActive(x) {
    if (!x) return false;
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = x.length - 1;
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  document.addEventListener("click", function (e) {
    closeAllLists(e.target);
  });
}

var data = ["test 1", "test 2", "test 3", "test 4", "test 5", "test 6", "test 7"];

autocomplete(document.getElementById("search"), data);

// ======================================== AutoComplete ============================================
