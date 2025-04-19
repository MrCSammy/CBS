// Custom JavaScript for interactivity

// Confirmation for sensitive actions
document.addEventListener("DOMContentLoaded", () => {
    const deleteButtons = document.querySelectorAll(".btn-delete");
    deleteButtons.forEach(button => {
        button.addEventListener("click", (e) => {
            if (!confirm("Are you sure you want to proceed with this action?")) {
                e.preventDefault();
            }
        });
    });
});
