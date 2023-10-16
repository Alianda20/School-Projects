// Get the form and result elements
const form = document.querySelector("form");
const result = document.querySelector(".result");
const error = document.querySelector(".error");

// Add event listener to the form submit button
form.addEventListener("submit", (event) => {
  // Prevent the default form submission behavior
  event.preventDefault();

  // Get the total bill amount and the amount paid
  const total = parseFloat(document.getElementById("total").value);
  const paid = parseFloat(document.getElementById("paid").value);

  // Check if the input values are valid
  if (isNaN(total) || isNaN(paid)) {
    error.textContent = "Please enter valid numbers.";
    result.textContent = "";
    return;
  }

  
  if (paid > total) {
    error.textContent = "The paid amount must be  equal to or less than the total bill amount.";
    result.textContent = "";
    return;
  }

  // Calculate the remaining amount
  const remaining = total - paid;

  // Display the result
  error.textContent = "";
  result.innerHTML = `You paid KES${paid.toFixed(2)}, and your remaining balance is KES${remaining.toFixed(2)}.`;
});
