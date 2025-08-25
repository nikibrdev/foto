document.addEventListener('DOMContentLoaded', function () {
  const forms = document.querySelectorAll('.form');
  if (!forms.length) return;

  forms.forEach(form => {
    // Создаем модальное окно и оверлей для каждой формы
    const modal = document.createElement('div');
    const overlay = document.createElement('div');
    modal.className = 'form-modal';
    modal.innerHTML = `
      <div class="form-modal__content">
        <div class="form-modal__content-title">Спасибо!</div>
        <div class="form-modal__content-text">Ваша заявка отправлена.</div>
      </div>
    `;
    overlay.className = 'modal-overlay';
    document.body.appendChild(modal);
    document.body.appendChild(overlay);

    // Скрываем ошибки при загрузке
    const errorElements = form.querySelectorAll('.form__error');
    if (errorElements.length) {
      errorElements.forEach(error => {
        error.style.display = 'none';
      });
    }

    // Обработка ввода в полях формы
    const inputs = form.querySelectorAll('.form__input');
    if (inputs.length) {
      inputs.forEach(input => {
        input.addEventListener('input', function() {
          const errorElement = this.closest('.form__item')?.querySelector('.form__error');
          if (errorElement) {
            errorElement.style.display = 'none';
          }
        });
      });
    }

    // Обработка чекбокса
    const checkbox = form.querySelector('.custom-checkbox__field');
    if (checkbox) {
      checkbox.addEventListener('change', function() {
        const checkboxError = form.querySelector('.form__error--checkbox');
        if (checkboxError) {
          checkboxError.style.display = this.checked ? 'none' : 'block';
        }
      });
    }

    // Обработка отправки формы
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      let isValid = true;

      // Валидация обязательных полей
      const requiredInputs = form.querySelectorAll('.form__input[placeholder*="*"]');
      if (requiredInputs.length) {
        requiredInputs.forEach(input => {
          const errorElement = input.closest('.form__item')?.querySelector('.form__error');
          if (!input.value.trim() && errorElement) {
            errorElement.style.display = 'block';
            isValid = false;
          }
        });
      }

      // Валидация чекбокса
      if (checkbox) {
        const checkboxError = form.querySelector('.form__error--checkbox');
        if (checkboxError) {
          if (!checkbox.checked) {
            checkboxError.style.display = 'block';
            isValid = false;
          }
        }
      }

      // Если форма валидна, показываем модальное окно
      if (isValid) {
        overlay.classList.add('active');
        modal.classList.add('active');
        form.reset();

        setTimeout(() => {
          modal.classList.remove('active');
          overlay.classList.remove('active');

          setTimeout(() => {
            window.location.reload();
          }, 100);
        }, 800);
      }
    });
  });
});
