// Get all "REQUEST" buttons
const requestButtons = document.querySelectorAll('table button');

// Add event listener to each button
requestButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Get the book details (row)
        const row = button.closest('tr');

        // Get the book details (cells)
        const bookName = row.querySelector('td:nth-child(2)').innerText;
        const authorName = row.querySelector('td:nth-child(3)').innerText;
        const copiesAvailable = row.querySelector('td:nth-child(4)').innerText;

        // Display an alert with the book details
        alert(`Requested book: ${bookName} by ${authorName}. Copies available: ${copiesAvailable}`);

        // You can replace the alert with your desired functionality, e.g., sending a request to the server
    });
});