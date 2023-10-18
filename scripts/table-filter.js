function filterTable() {
	console.log("h");
	// The Filter Input
	// The Filter String
	let filter = input.value.toUpperCase();
	// The table to filter through
	table.appendChild(noResultsFound);
	// All the rows of the table
	let tr = table.getElementsByTagName("tr");

	// variable to see if a result was found
	let foundResult = false;

	// Loop through all table rows
	for (let i = 0; i < tr.length; i++) {
		// Get all the cells of the row
		td = tr[i].getElementsByTagName("td");
		// Loop through all the cells of the row
		for (let j = 0; j < td.length; j++) {
			// If cell exists and cell doesn't have the colspan attribute (empty row)
			if (td[j] && !td[j].hasAttribute("colspan")) {
				// Get the text content or innerTest of the cell
				txtValue = td[j].textContent || td[j].innerText;
				// Searches txtValue to find an index of filter that is greater than -1 (0-...)
				// If the indexOf is -1 it means not found 
				if (txtValue.toUpperCase().indexOf(filter) > -1) {
					tr[i].style.display = "";
					foundResult = true;
					break; // Break if a match is found
				} else {
					// Add "display: none"
					// to the columns where a match is not found
					tr[i].style.display = "none";
				}
			}
		}
	}

	noResultsFound.style.display = foundResult ? "none" : "";
}

const input = document.getElementById("searchInput");
input.addEventListener("input", filterTable);

const table = document.getElementById("filterableTable");
const noResultsFound = document.createElement("tr");
noResultsFound.innerHTML = "<td colspan='9999'>No Results Found</td>"
