(() => {
    const root = document.documentElement;
    const storageKey = 'directionPreference';

    const applyDirection = (dir) => {
        root.setAttribute('dir', dir);
        document.body.classList.toggle('rtl', dir === 'rtl');
    };

    const savedDir = localStorage.getItem(storageKey) || 'ltr';
    applyDirection(savedDir);

    document.addEventListener('DOMContentLoaded', () => {
        const rtlToggle = document.getElementById('rtlToggle');
        if (rtlToggle) {
            rtlToggle.addEventListener('click', () => {
                const nextDir = root.getAttribute('dir') === 'ltr' ? 'rtl' : 'ltr';
                applyDirection(nextDir);
                localStorage.setItem(storageKey, nextDir);
                showToast('info', nextDir === 'rtl' ? 'تم تفعيل الواجهة العربية' : 'Switched to English layout');
            });
        }

        document.querySelectorAll('.nav-search .search-input').forEach((input) => {
            input.addEventListener('focus', () => input.closest('.nav-search')?.classList.add('is-focused'));
            input.addEventListener('blur', () => input.closest('.nav-search')?.classList.remove('is-focused'));
        });

        if (typeof Swiper !== 'undefined') {
            document.querySelectorAll('.featured-swiper').forEach((container) => {
                new Swiper(container, {
                    slidesPerView: 1.2,
                    spaceBetween: 20,
                    breakpoints: {
                        576: { slidesPerView: 2 },
                        992: { slidesPerView: 3 },
                        1200: { slidesPerView: 4 },
                    },
                    navigation: {
                        nextEl: container.querySelector('.swiper-button-next'),
                        prevEl: container.querySelector('.swiper-button-prev'),
                    },
                });
            });

            document.querySelectorAll('.testimonial-swiper').forEach((container) => {
                new Swiper(container, {
                    slidesPerView: 1,
                    autoHeight: true,
                    pagination: {
                        el: container.querySelector('.swiper-pagination'),
                        clickable: true,
                    },
                });
            });
        }

        if (typeof AOS !== 'undefined') {
            AOS.init({
                once: true,
                duration: 800,
            });
        }

        initCartUI();
        initRecycleUpload();
    });

    window.showToast = (type = 'success', message = '') => {
        const background = type === 'success'
            ? 'linear-gradient(135deg, #0f766e, #2dd4bf)'
            : type === 'error'
                ? '#ef4444'
                : '#3b82f6';

        Toastify({
            text: message || 'Action completed',
            duration: 3000,
            gravity: 'top',
            position: 'right',
            close: true,
            style: { background },
        }).showToast();
    };

    function initCartUI() {
        const summarySubtotal = document.querySelector('[data-cart-subtotal]');
        const summaryTotal = document.querySelector('[data-cart-total]');
        const summaryShipping = document.querySelector('[data-cart-shipping]');

        const updateTotals = () => {
            let subtotal = 0;
            document.querySelectorAll('[data-cart-item]').forEach((row) => {
                const qty = Number(row.querySelector('[data-qty-input]')?.value || 0);
                const price = Number(row.dataset.price || 0);
                const lineTotal = qty * price;
                subtotal += lineTotal;
                const lineElement = row.querySelector('[data-line-total]');
                if (lineElement) {
                    lineElement.textContent = `EGP ${lineTotal.toFixed(2)}`;
                }
            });

            const shipping = subtotal > 0 ? 60 : 0;
            if (summarySubtotal) summarySubtotal.textContent = `EGP ${subtotal.toFixed(2)}`;
            if (summaryShipping) summaryShipping.textContent = `EGP ${shipping.toFixed(2)}`;
            if (summaryTotal) summaryTotal.textContent = `EGP ${(subtotal + shipping).toFixed(2)}`;
        };

        document.querySelectorAll('[data-qty-btn]').forEach((button) => {
            button.addEventListener('click', () => {
                const container = button.closest('[data-cart-item]') || button.closest('.input-group');
                const input = container?.querySelector('[data-qty-input]');
                if (!input) return;
                const step = Number(button.dataset.qtyBtn);
                const nextValue = Math.max(1, Number(input.value || 1) + step);
                input.value = nextValue;
                updateTotals();
            });
        });

        document.querySelectorAll('[data-qty-input]').forEach((input) => {
            input.addEventListener('change', () => {
                input.value = Math.max(1, Number(input.value) || 1);
                updateTotals();
            });
        });

        document.querySelectorAll('[data-remove-item]').forEach((button) => {
            button.addEventListener('click', () => {
                const row = button.closest('[data-cart-item]');
                row?.remove();
                updateTotals();
                showToast('info', 'Item removed from cart');
            });
        });

        updateTotals();
    }

    function initRecycleUpload() {
        const input = document.getElementById('recycleImage');
        const preview = document.getElementById('recyclePreview');
        if (!input || !preview) return;

        input.addEventListener('change', (event) => {
            const file = event.target.files?.[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.style.backgroundImage = `url('${e.target.result}')`;
                preview.classList.add('has-image');
            };
            reader.readAsDataURL(file);
        });
    }
})();
