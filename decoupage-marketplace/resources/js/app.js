import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const cartBadge = document.getElementById('nav-cart-count');

    const refreshCartCounter = (items = []) => {
        if (cartBadge) {
            const totalItems = items.reduce((carry, item) => carry + Number(item.quantity), 0);
            cartBadge.textContent = totalItems;
        }
    };

    const updateCartSummary = (totals = null) => {
        if (!totals) {
            return;
        }
        const subtotalEl = document.querySelector('[data-cart-subtotal]');
        const shippingEl = document.querySelector('[data-cart-shipping]');
        const totalEl = document.querySelector('[data-cart-total]');
        if (subtotalEl) subtotalEl.textContent = `EGP ${Number(totals.subtotal).toFixed(2)}`;
        if (shippingEl) shippingEl.textContent = `EGP ${Number(totals.shipping).toFixed(2)}`;
        if (totalEl) totalEl.textContent = `EGP ${Number(totals.total).toFixed(2)}`;
    };

    const updateCartRow = (items = [], productId) => {
        const row = document.querySelector(`[data-cart-row="${productId}"]`);
        const line = document.querySelector(`[data-cart-line="${productId}"]`);
        const item = items.find((entry) => Number(entry.id) === Number(productId));
        if (row && item) {
            const input = row.querySelector('[data-cart-update]');
            if (input) input.value = item.quantity;
            if (line) line.textContent = `EGP ${(item.price * item.quantity).toFixed(2)}`;
        }
        if (row && !item) {
            row.remove();
        }
    };

    document.querySelectorAll('[data-add-to-cart]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            event.preventDefault();
            const productId = form.dataset.product;
            const quantity = form.querySelector('input[name="quantity"]')?.value ?? 1;

            axios.post(form.action, { product_id: productId, quantity })
                .then((response) => {
                    refreshCartCounter(response.data.items ?? []);
                    const toast = document.getElementById('cart-toast');
                    if (toast) {
                        toast.textContent = response.data.message;
                        toast.classList.remove('d-none');
                        setTimeout(() => toast.classList.add('d-none'), 2500);
                    }
                })
                .catch(() => alert('Unable to add item. Please try again.'));
        });
    });

    document.querySelectorAll('[data-cart-update]').forEach((input) => {
        input.addEventListener('change', (event) => {
            const productId = input.dataset.cartUpdate;
            axios.patch(`/cart/${productId}`, { quantity: event.target.value })
                .then((response) => {
                    const { items = [], totals = null } = response.data;
                    refreshCartCounter(items);
                    updateCartSummary(totals);
                    updateCartRow(items, productId);
                })
                .catch(() => alert('Unable to update quantity.'));
        });
    });

    document.querySelectorAll('[data-cart-remove]').forEach((button) => {
        button.addEventListener('click', () => {
            const productId = button.dataset.cartRemove;
            axios.delete(`/cart/${productId}`)
                .then((response) => {
                    const { items = [], totals = null } = response.data;
                    refreshCartCounter(items);
                    updateCartSummary(totals);
                    updateCartRow(items, productId);
                })
                .catch(() => alert('Unable to remove item.'));
        });
    });

    const recycleForm = document.getElementById('recycle-form');
    if (recycleForm) {
        recycleForm.addEventListener('submit', (event) => {
            event.preventDefault();
            const formData = new FormData(recycleForm);
            axios.post(recycleForm.action, formData)
                .then((response) => {
                    recycleForm.reset();
                    const successEl = document.getElementById('recycle-success');
                    if (successEl) {
                        successEl.textContent = response.data.message;
                        successEl.classList.remove('d-none');
                        setTimeout(() => successEl.classList.add('d-none'), 3000);
                    }
                })
                .catch((error) => {
                    alert(error.response?.data?.message ?? 'Unable to submit request.');
                });
        });
    }
});
