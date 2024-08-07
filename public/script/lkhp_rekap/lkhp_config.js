function Getyear() {
    const yearSelects = document.querySelectorAll(".yearSelect");
    const currentYear = new Date().getFullYear();
    const yearRange = 5;

    yearSelects.forEach((select) => {
        // Clear existing options
        select.innerHTML = "<option selected disabled>- Pilih Tahun -</option>";

        // Create options for the last 5 years
        for (let i = 0; i <= yearRange; i++) {
            const year = currentYear - i;
            const option = document.createElement("option");
            option.value = year;
            option.textContent = year;
            select.appendChild(option);
        }
    });
}

// Populate the select element on page load
document.addEventListener("DOMContentLoaded", Getyear);
