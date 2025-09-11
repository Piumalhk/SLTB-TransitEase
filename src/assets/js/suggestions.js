// assets/js/suggestions.js

// Sample list of cities (can later be fetched from DB with AJAX)
const cities = [
  "Colombo", "Kandy", "Galle", "Matara", "Jaffna",
  "Negombo", "Trincomalee", "Batticaloa",
  "Anuradhapura", "Kurunegala", "Polonnaruwa", "Ratnapura"
];

/**
 * Show suggestions below the input field
 */
function showSuggestions(inputElement, suggestionBoxId) {
  const query = inputElement.value.toLowerCase();
  const suggestionBox = document.getElementById(suggestionBoxId);

  suggestionBox.innerHTML = ""; // clear old results

  if (!query) return; // no query = no suggestions

  const matches = cities.filter(city =>
    city.toLowerCase().includes(query)
  );

  matches.forEach(city => {
    const div = document.createElement("div");
    div.classList.add("suggestion-item");
    div.textContent = city;

    // when user clicks a suggestion
    div.addEventListener("click", () => {
      inputElement.value = city;
      suggestionBox.innerHTML = ""; // clear suggestions
    });

    suggestionBox.appendChild(div);
  });
}

/**
 * Hide suggestions when input loses focus
 */
function hideSuggestions(suggestionBoxId) {
  setTimeout(() => {
    const suggestionBox = document.getElementById(suggestionBoxId);
    if (suggestionBox) {
      suggestionBox.innerHTML = "";
    }
  }, 200); // small delay so click can register
}
