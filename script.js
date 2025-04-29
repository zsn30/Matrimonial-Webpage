function loadSection(section) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `${section}.php`, true);
    xhr.onload = function () {
      if (this.status === 200) {
        document.getElementById("content-area").innerHTML = this.responseText;

      // 📢 Very important: Re-bind event listeners after new content loaded!
      if (section === "search") {
        bindSearchForm();
      }
        
      }
    };
    xhr.send();
  }
  

  function bindSearchForm() {
    const searchForm = document.getElementById("searchForm");
    if (searchForm) {
      searchForm.addEventListener("submit", function(e) {
        e.preventDefault();
        const formData = new FormData(searchForm);
        fetch("search_result.php", {
          method: "POST",
          body: formData
        })
        .then(response => response.text())
        .then(data => {
          document.getElementById("search_results").innerHTML = data;
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Search failed. Check console.');
        });
      });
    }
  }
  


  // Handle profile picture upload
  document.getElementById("uploadForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch("upload_pic.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.text())

      .then((data) => {
        const result = JSON.parse(data);
        if (result.status === "success") {
          document.getElementById("user-pic").src = result.path;
        }
        alert(data);
      });
  });
  
  // Load profile picture on page load
window.addEventListener("DOMContentLoaded", () => {
  fetch("get_profile_pic.php")
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "success" || data.status === "default") {
        document.getElementById("user-pic").src = data.path;
      }
    });
});
