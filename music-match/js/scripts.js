/*!
* Start Bootstrap - Shop Homepage v5.0.6 (https://startbootstrap.com/template/shop-homepage)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-shop-homepage/blob/master/LICENSE)
*/
// This file is intentionally blank
// Use this file to add JavaScript to your project

document.addEventListener('DOMContentLoaded', () => {
    // Cargar el carrito desde localStorage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    function renderCart() {
        const cartItemsContainer = document.getElementById('cart-items');
        cartItemsContainer.innerHTML = '';

        let total = 0;
        
        cart.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.name}</td>
                <td>$${item.price.toFixed(2)}</td>
                <td>${item.quantity}</td>
                <td>$${itemTotal.toFixed(2)}</td>
                <td><button class="btn btn-danger btn-sm" data-index="${index}">Eliminar</button></td>
            `;
            cartItemsContainer.appendChild(row);
        });

        document.getElementById('cart-total').textContent = total.toFixed(2);
        
        const deleteButtons = document.querySelectorAll('.btn-danger');
        deleteButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                const itemIndex = event.target.getAttribute('data-index');
                removeFromCart(itemIndex);
            });
        });
    }
    
    function removeFromCart(index) {
        cart.splice(index, 1); 
        localStorage.setItem('cart', JSON.stringify(cart)); 
        renderCart(); 
        updateCartCounter(); 
    }

    function updateCartCounter() {
        const cartCount = cart.reduce((total, item) => total + item.quantity, 0);
        const badge = document.querySelector('.badge');
        if (badge) {
            badge.textContent = cartCount; 
        }
    }
    
    function addToCart(productId, productName, productPrice) {
        const productIndex = cart.findIndex(item => item.id === productId);

        if (productIndex !== -1) {
            cart[productIndex].quantity += 1; 
        } else {
            
            cart.push({
                id: productId,
                name: productName,
                price: parseFloat(productPrice),
                quantity: 1
            });
        }

        localStorage.setItem('cart', JSON.stringify(cart)); 
        updateCartCounter(); 
        renderCart(); 
    }

    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', event => {
            event.preventDefault(); 
            const productId = parseInt(button.getAttribute('data-id'), 10);
            const productName = button.getAttribute('data-name');
            const productPrice = button.getAttribute('data-price');
            addToCart(productId, productName, productPrice); 
        });
    });

    renderCart();
    updateCartCounter(); 
});