function toggleDropdown() {
        document.getElementById("userDropdown").classList.toggle("visible");
    }

    window.onclick = function (event) {
        if (!event.target.closest('.dropdown')) {
            const dropdown = document.getElementById("userDropdown");
            if (dropdown) dropdown.classList.remove("visible");
        }
    }