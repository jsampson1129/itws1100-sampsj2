// Wait for the DOM to be fully loaded before running the script
document.addEventListener("DOMContentLoaded", () => {
    
    // Get the container where pet cards will be inserted
    const petGrid = document.getElementById("pet-grid");

    /**
     * Fetches pet data from the JSON file and populates the grid.
     */
    async function loadPets() {
        if (!petGrid) {
            // This script is only for pages with the pet-grid
            // console.log("Pet grid container not found on this page.");
            return;
        }

        try {
            // Fetch data from the info.json file
            // This path is relative to the root index.html
            const response = await fetch('pet_data/info.json');
            
            // Check if the network response was ok
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            // Parse the JSON data from the response
            const pets = await response.json();

            // Clear any existing content (e.g., a loading message)
            petGrid.innerHTML = "";

            // Check if the pets array is empty
            if (pets.length === 0) {
                petGrid.innerHTML = "<p>No pets available for adoption at this time.</p>";
                return;
            }

            // Loop through each pet in the array
            pets.forEach(pet => {
                // Create a new article element for the pet card
                const card = document.createElement("article");
                card.className = "pet-card";

                // Set the inner HTML of the card using template literals
                // This matches the structure and classes from your mockup
                card.innerHTML = `
                    <div class="pet-card-image">
                        <img src="${pet.image}" alt="${pet.name}, ${pet.type}" onerror="this.src='https://placehold.co/300x250/eeeeee/aaaaaa?text=Image+Missing'; this.alt='Image missing for ${pet.name}'">
                    </div>
                    <div class="pet-card-info">
                        <div class="pet-card-header">
                            <span class="pet-name">Name: ${pet.name}</span>
                            <span class="pet-details">Type: ${pet.type} | Age: ${pet.age}</span>
                        </div>
                        <div class="pet-card-buttons">
                            <button class="btn btn-secondary">Adopt</button>
                            <button class="btn btn-secondary">Visit</button>
                        </div>
                    </div>
                `;
                
                // Add the newly created card to the grid
                petGrid.appendChild(card);
            });

        } catch (error) {
            // Log any errors to the console
            console.error("Could not fetch or display pet data:", error);
            // Show a user-friendly error message
            petGrid.innerHTML = "<p>Sorry, we couldn't load the pet information. Please try again later.</p>";
        }
    }

    // Call the function to load pets when the page loads
    loadPets();
});