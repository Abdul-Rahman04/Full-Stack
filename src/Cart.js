import React from 'react';

const Cart = ({ cartItems, removeItem }) => {
  return (
    <div>
      <h2>Shopping Cart</h2>
      {cartItems.length === 0 ? (
        <p>Your cart is empty.</p>
      ) : (
        <ul>
          {cartItems.map((item) => (
            <li key={item.id}>
              <p>Name: {item.name}</p>
              <p>Email: {item.email}</p>
              <p>Message: {item.message}</p>
              <button onClick={() => removeItem(item.id)}>Remove</button>
            </li>
          ))}
        </ul>
      )}
    </div>
  );
};

export default Cart;
