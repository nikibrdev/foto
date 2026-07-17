document.addEventListener('DOMContentLoaded', function () {
  const forms = document.querySelectorAll('.form');
  if (!forms.length) return;

  const i18n = (window.sfData && window.sfData.i18n) || {};
  const ajaxUrl = (window.sfData && window.sfData.ajaxUrl) || '/wp-admin/admin-ajax.php';

  forms.forEach(form => {
    const modal = document.createElement('div');
    const overlay = document.createElement('div');
    modal.className = 'form-modal';
    overlay.className = 'modal-overlay';
    document.body.appendChild(modal);
    document.body.appendChild(overlay);

    function showModal(title, text) {
      modal.innerHTML = `
        <div class="form-modal__content">
          <div class="form-modal__content-title">${title}</div>
          <div class="form-modal__content-text">${text}</div>
        </div>
      `;
      overlay.classList.add('active');
      modal.classList.add('active');

      setTimeout(() => {
        modal.classList.remove('active');
        overlay.classList.remove('active');
      }, 2500);
    }

    const errorElements = form.querySelectorAll('.form__error');
    errorElements.forEach(error => {
      error.style.display = 'none';
    });

    const inputs = form.querySelectorAll('.form__input');
    inputs.forEach(input => {
      input.addEventListener('input', function () {
        const errorElement = this.closest('.form__item')?.querySelector('.form__error');
        if (errorElement) {
          errorElement.style.display = 'none';
        }
      });
    });

    const checkbox = form.querySelector('.custom-checkbox__field');
    if (checkbox) {
      checkbox.addEventListener('change', function () {
        const checkboxError = form.querySelector('.form__error--checkbox');
        if (checkboxError) {
          checkboxError.style.display = this.checked ? 'none' : 'block';
        }
      });
    }

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      if (form.dataset.submitting === '1') return;

      let isValid = true;

      const requiredInputs = form.querySelectorAll('.form__input[placeholder*="*"]');
      requiredInputs.forEach(input => {
        const errorElement = input.closest('.form__item')?.querySelector('.form__error');
        if (!input.value.trim() && errorElement) {
          errorElement.style.display = 'block';
          isValid = false;
        }
      });

      if (checkbox) {
        const checkboxError = form.querySelector('.form__error--checkbox');
        if (checkboxError) {
          if (!checkbox.checked) {
            checkboxError.style.display = 'block';
            isValid = false;
          }
        }
      }

      if (!isValid) return;

      const submitButton = form.querySelector('.form__btn');
      form.dataset.submitting = '1';
      submitButton?.setAttribute('disabled', 'disabled');

      const formData = new FormData(form);

      fetch(ajaxUrl, {
        method: 'POST',
        credentials: 'same-origin',
        body: formData,
      })
        .then(response => response.json())
        .then(response => {
          if (response && response.success) {
            showModal(
              i18n.successTitle || 'Спасибо!',
              i18n.successText || 'Ваша заявка отправлена.'
            );
            form.reset();
          } else {
            const message = (response && response.data && response.data.message) || i18n.errorText;
            showModal(i18n.errorTitle || 'Ошибка', message || 'Не удалось отправить заявку. Попробуйте ещё раз.');
          }
        })
        .catch(() => {
          showModal(i18n.errorTitle || 'Ошибка', i18n.errorText || 'Не удалось отправить заявку. Попробуйте ещё раз.');
        })
        .finally(() => {
          form.dataset.submitting = '0';
          submitButton?.removeAttribute('disabled');
        });
    });
  });
});
