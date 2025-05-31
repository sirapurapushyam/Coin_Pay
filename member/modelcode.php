 <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="feedbackModalContent">
                <div class="modal-header" id="feedbackModalHeader">
                    <h5 class="modal-title" id="feedbackModalLabel">Feedback</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" id="feedbackModalBody">
                </div>
            </div>
        </div>
    </div>
    <?php if (isset($_SESSION["feedback"])): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalHeader = document.getElementById('feedbackModalHeader');
        const modalContent = document.getElementById('feedbackModalContent');
        const modalBody = document.getElementById('feedbackModalBody');

        const type = "<?php echo $_SESSION['feedback']['type']; ?>";
        const message = `<?php echo $_SESSION['feedback']['message']; ?>`;

        if (type === "success") {
            modalHeader.className = 'modal-header bg-success text-white';
            modalContent.className = 'modal-content border-success';
            modalBody.innerHTML = `<div class='d-flex flex-column align-items-center'>
                <div class='text-success mb-3'>
                    <i class='fas fa-check-circle fa-3x'></i>
                </div>
                <h5 class='text-center'>${message}</h5>
            </div>`;
        } else {
            modalHeader.className = 'modal-header bg-danger text-white';
            modalContent.className = 'modal-content border-danger';
            modalBody.innerHTML = `<div class='d-flex flex-column align-items-center'>
                <div class='text-danger mb-3'>
                    <i class='fas fa-times-circle fa-3x'></i>
                </div>
                <h5 class='text-center'>${message}</h5>
            </div>`;
        }

        var feedbackModal = new bootstrap.Modal(document.getElementById('feedbackModal'));
        feedbackModal.show();

        setTimeout(() => {
            feedbackModal.hide();
        }, 5000);
    });
    </script>
    <?php unset($_SESSION["feedback"]); ?>
    <?php endif; ?>
