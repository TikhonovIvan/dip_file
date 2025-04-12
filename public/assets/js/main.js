document.querySelectorAll('.modal').forEach(modal => {
    const modalId = modal.getAttribute('id');
    const deleteBtn = modal.querySelector(`#confirmDeleteBtn-${modalId.split('-')[1]}`);
    const countdownText = modal.querySelector(`#countdownText-${modalId.split('-')[1]}`);

    let countdownInterval;

    modal.addEventListener('shown.bs.modal', function () {
        let timeLeft = 15;
        deleteBtn.disabled = true;
        countdownText.textContent = `Ожидайте... ${timeLeft} сек`;

        countdownInterval = setInterval(() => {
            timeLeft--;
            if (timeLeft > 0) {
                countdownText.textContent = `Ожидайте... ${timeLeft} сек`;
            } else {
                clearInterval(countdownInterval);
                deleteBtn.disabled = false;
                countdownText.textContent = '';
            }
        }, 1000);
    });

    modal.addEventListener('hidden.bs.modal', function () {
        clearInterval(countdownInterval);
        deleteBtn.disabled = true;
        countdownText.textContent = '';
    });
});
